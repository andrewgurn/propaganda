<?php

	require_once("../propagandaConfig.php");
	require_once("../includes/db.php");
	
	$user = $_SERVER['REMOTE_USER']; 
	$db = new db();
	$conn = $db->getMariaDbConnection();
	
	$sql="
		select 
			p.id
			,p.contentType
			,p.contentLocation
			,p.displayTime
			,p.dateStart
			,p.dateEnd
			,p.addedBy
			,p.getVariables
			,pc.channelName
		from propaganda p
			,propagandaChannel pc
		where p.dateEnd >= NOW()
			and p.isDeleted = 0
			and p.channelID = pc.id
		order by p.id desc

	";  

	$stmt = $db->basicQuery($conn, $sql);
	$stmt->bind_result($id, $contentType, $contentLocation, $displayTime, $dateStart, $dateEnd, $addedBy, $getVariables, $channelName);
	$content = '';
	$deleteHTML = '';
	
	while($stmt->fetch())
	{
		$displayTimeInSeconds = $displayTime/1000;
		$image = '';
		$variables = '';
		$location = '';
	
		if($contentType == 'iframe')
		{
			$image = "<img src='../images/iframe.jpg' style='width:100%;'>";
			$variables = "<p>
						Variable(s): 
						<input type='text' id='getVariables$id' value='$getVariables'>
						<input type='button' id='updateGetVariables$id' value='Update'>
						<div id='updateGetVariablesResultsDiv$id'></div>
						<script>
							$('#updateGetVariables$id').on('click', function(){
								var contentID = '$id';
								var getVariables = $('#getVariables$id').val();
								var data = { 'contentID' : contentID , 'getVariables' : getVariables };
								standardAjaxWrapper('text', 'POST', 'propagandaUpdateGetVariables.php', 'application/x-www-form-urlencoded', data, 'updateGetVariablesResultsDiv$id', 'updateGetVariablesResultsDiv$id', false, false, '');
							});
						</script>
					</p>
			";
			$location = "<p>
						Location:
						<br /><a href='$contentLocation' target='_blank'>$contentLocation</a>
					</p>
			";

		}
		else if($contentType == 'image')
		{
			$contentLocation = "../$contentLocation";
			$image = "<a href='$contentLocation' target='_blank'><img src='$contentLocation' style='width:100%;'></a>";
			$variables = '';
			$location = '';
		}
		
		if($addedBy == $user || in_array($user, MANAGERS))
		{
			$deleteHTML = "
					<br />
					<input type='hidden' id='delete$id' value='$id'>
					<input type='button' id='deleteButton$id' value='Delete This'>
					<script>
						$('#deleteButton$id').on('click', function(){
							propagandaDeleteContent($('#delete$id').val());
						});
					</script>
					
			";
		}
		$content .= "
			<div class='contentDiv'>
				$image
				$location
				$variables
				<p>
					Live from: 
					<br /><strong>$dateStart</strong> 
					<br />through 
					<br /><strong>$dateEnd</strong>
				</p>
				<p>
					Display Time: <strong>$displayTimeInSeconds seconds</strong>
					<br />
					Added by <strong>$addedBy</strong>
				</p>
				<p>
					Channel: <strong>$channelName</strong>
				</p>
				$deleteHTML
			</div>
			";
	}
	
	echo("$content");		

?>
