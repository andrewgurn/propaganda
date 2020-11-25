<?php
	require_once("../propagandaConfig.php");
	$user = $_SERVER['REMOTE_USER'];
?>

<html>
	<head>
		<title>Propaganda Uploader</title>
		<script type="text/javascript" src="https://code.jquery.com/jquery-latest.js"></script>
		<style>
			.left
			{
				display: inline-block;
				width: 25%;
				left: 5%;
				vertical-align: top;
			}
			
			.right
			{
				display: inline-block;
				width: 65%;
				right: 5%;
			}
			
			.imagePreviewDiv img
			{
				width: 100%;
			}
			
			.formDiv div
			{
				padding: 5px;
			}
			
		</style>
	</head>
	<body>
		<?php if(in_array($user, UPLOADERS) || is_empty(UPLOADERS)) : ?>
		
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
				<input type="text" id="displayTime" length="3"> seconds
			</div>
			<div>
				<input type="button" id="submit" value="Sumbit!">
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
			<h1>Here's everything currently active:</h1>
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

				var formDataObject = new FormData();
				var files = $('#uploadedDocument')[0].files;

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
				
				var contentType = $('#contentType').val();
				var contentLocation = $('#contentLocation').val();
				var dateStart = $('#dateStart').val();
				var dateEnd = $('#dateEnd').val();
				var displayTime = $('#displayTime').val();
				var addedBy = $('#addedBy').val();
				
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
	</body>

	

</html>
