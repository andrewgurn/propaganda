<?php
	require_once("../propagandaConfig.php");
	$user = $_SERVER['REMOTE_USER'];
?>

<html>
	<head>
		<title>Propaganda Uploader</title>
		<script type="text/javascript" src="https://code.jquery.com/jquery-latest.js"></script>
		<script type="text/javascript" src="../js/ajax.js"></script>
		<style>
			body
			{
				font-family: Verdana, Geneva, sans-serif;
				background: #63585E;
			}
			
			.container
			{
				background: #8AA29E;
				color: #FAFAFA;
				margin-left: auto;
				margin-right: auto;
				padding: 20px;
				text-align: center;
			}
			
			.left
			{
				display: inline-block;
				width: 25%;
				left: 5%;
				vertical-align: top;
				text-align: left;
			}
			
			.right
			{
				display: inline-block;
				width: 65%;
				right: 5%;
			}
			
			.imagePreviewDiv img
			{
				width: 75%;
			}
			
			.formDiv div
			{
				padding: 10px;
			}
			
		</style>
	</head>
	<body>
		<?php if(in_array($user, UPLOADERS) || is_empty(UPLOADERS)) : ?>
		<div class='container'>
		
			<h1>Propaganda Uploader</h1>
			<div class="left formDiv">
				<div>
					I am adding an: 
					<select id="contentType">
						<option value="">...</option>
						<option value="image">Image</option>
						<option value="iframe">iFrame</option>
					</select>
				</div>
				<div id="resultDiv">
				
				</div>
				
				<input type="hidden" id="contentLocation" value="">
				
				<div id="image" style="display: none;">
					Upload your image: 
					<input type="file" id="uploadedDocument">
				</div>
				<div id="iframe" style="display: none;">
					Enter the web address of your iFrame:
					<input type="text" id="iframeLocation">
				</div>
				<div>
					Start Date:
					<input type="date" id="dateStart">
				</div>
				<div>
					End Date:
					<input type="date" id="dateEnd">
				</div>
				<div>
					Show for:
					<input type="text" id="displayTime" style="width: 10%;"> seconds
				</div>
				<div>
					<input type="button" id="submit" value="Submit!">
				</div>
				<div id="addResultDiv">
				
				</div>
				<?php
					echo("<input type='hidden' id='addedBy' value='$user'>");
				?>
			</div>
			<div class="right">
				<div class="imagePreviewDiv">
					<img id="previewImage" src="../images/preview.jpg">
				</div>
			</div>
			<div>
				<h1>Here's everything currently active (and scheduled for the future):</h1>
				<div id="allContent">
					
				</div>
			</div>
			<script>
				$(document).ready(function(){
					allActiveContent();
				});
				
				//show the appropriate fields based on the content type
				$('#contentType').on('change', function(){
					
					if($('#contentType').val() == 'image')
					{
						$('#iframe').fadeOut();
						$('#image').delay(500).fadeIn();
					}
					else if($('#contentType').val() == 'iframe')
					{
						$('#image').fadeOut();
						$('#iframe').delay(500).fadeIn();
					}
				});
				
				//after the user selects an image, this will upload it to the propaganda/propagandaUploads directory
				$("#uploadedDocument").on("change", function(){

					let formDataObject = new FormData();
					let files = $('#uploadedDocument')[0].files;

					if(files.length > 0 )
					{
						formDataObject.append('file',files[0]);

						$.ajax({
							url: 'propagandaUpload.php',
							type: 'post',
							data: formDataObject,
							contentType: false,
							processData: false,
							success: function(response)
							{
								if(response != 0)
								{
									$("#previewImage").attr('src', '../'+response); 
									$("#contentLocation").val(response); 
									
								}
								else
								{
									$("#resultDiv").html("Well, your file didn't upload.  It has to be a JPG, PNG, or GIF and it must be less than 8MB in size."); 
								}
							},
						});
					}
					else
					{
						$("#resultDiv").html("You never selected a file, so...");
					}
				});
				
				$("#iframeLocation").on("change", function(){
					$('#contentLocation').val($('#iframeLocation').val());
				});
				
				//insert everything into the db	
				$("#submit").on("click", function(){
					
					let contentType = $('#contentType').val();
					let contentLocation = $('#contentLocation').val();
					let dateStart = $('#dateStart').val();
					let dateEnd = $('#dateEnd').val();
					let displayTime = $('#displayTime').val();
					let addedBy = $('#addedBy').val();
					
					$.ajax({
					    dataType: 'text',
					    type: 'POST',
					    url: 'propagandaAdd.php',
					    data: { 'contentType' : contentType , 'contentLocation' : contentLocation , 'dateStart' : dateStart , 'dateEnd' : dateEnd , 'displayTime' : displayTime , 'addedBy' : addedBy },
					    contentType: "application/x-www-form-urlencoded;",
					    success: function(result){
						  	
						   $('#addResultDiv').html(result);  
						   $('#contentType').val("");
						   $('#contentLocation').val("")
						   $('#dateEnd').val("");	
						   $('#displayTime').val("");
						   $("#previewImage").attr('src', '../images/preview.jpg'); 
						   $('#uploadedDocument').val('');
						   $('#image').hide();
						   $('#iframeLocation').val('');
						   $('#iframe').val('').hide();
						   $("#resultDiv").html('');
						   allActiveContent();
					    },
					    error: function(xhr, textStatus, errorThrown) {
					       	
						   $('#addResultDiv').html('<div class="error">AJAX error submitting your content!  Weird!  Did you lose your network connection?</div>');
						  
					    }
					});
					
				});
				
				function allActiveContent()
				{
					$.ajax({
						url: 'propagandaGetActiveContent.php',
						type: 'post',
						contentType: false,
						processData: false,
						success: function(response)
						{
							$("#allContent").html(response); 	
						},
					});
				}
				
				function propagandaDeleteContent(contentID)
				{
					
					$.ajax({
						url: 'propagandaDeleteContent.php',
						type: 'post',
						data: { 'contentID' : contentID },
						contentType: "application/x-www-form-urlencoded;",
						success: function(response)
						{
							allActiveContent();
						},
					});
					
				}
				
				
			</script>
			
			
			<?php else : ?>
		
					<!-- Bad Login -->
					<p>
						Hey, so, you're not allowed to use this page.  Sorry!
					</p>
			<?php endif; ?>
		</div>	
	</body>

	

</html>
