<?php

	require_once("../propagandaConfig.php");
	require_once("../db.php");
	
	$user = $_SERVER['REMOTE_USER']; 
	$dbObj = new Db();
	$db = $dbObj->getMariaDbConnection();
	
	$sql="
		select 
			id
			,contentType
			,contentLocation
			,displayTime
			,dateStart
			,dateEnd
			,addedBy
		from propaganda
		where NOW() between dateStart and dateEnd
			and isDeleted = 0
		order by id desc

	";  

	if ($stmt = $db->prepare($sql)) 
	{
		$stmt->execute();    // Execute the prepared query.
		$stmt->store_result();
		$stmt->bind_result($id, $contentType, $contentLocation, $displayTime, $dateStart, $dateEnd, $addedBy);
		$content = '';
		$deleteHTML = '';
		
		while($stmt->fetch())
		{
			$displayTimeInSeconds = $displayTime/1000;
			
		
			if($contentType == 'iframe')
			{
				$content .= "
					<div style='width: 500px; margin: 5px; display: inline-block; border: solid 1px; padding: 10px;'>
						<img src='../images/iframe.jpg' style='width:100%;'>
						<p>
							Location:
							<br /><a href='$contentLocation' target='_blank'>$contentLocation</a>
						</p>
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
				";
			}
			else if($contentType == 'image')
			{
				$contentLocation = "../$contentLocation";
				
				$content .= "
					<div style='width: 500px; margin: 5px; display: inline-block; padding: 10px; background: #63585E;'>
						<a href='$contentLocation' target='_blank'><img src='$contentLocation' style='width:100%;'></a>
						<p>
							Live from: 
							<br />
							<br /><strong>$dateStart</strong> 
							<br />through 
							<br /><strong>$dateEnd</strong>
						</p>
						<p>
							Display Time: <strong>$displayTimeInSeconds seconds</strong>
							<br />
							Added by <strong>$addedBy</strong>
						</p>

				";
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
			
			$content .= "$deleteHTML</div>";
		}
		
		echo("$content");		

	}
	else
	{
		echo("<div class='alertWarning'>Error preparing SQL in propagandaGetActiveContent.php: That's weird!");
	}

?>