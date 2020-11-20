<?php

	require_once("propagandaConfig.php");
	require_once("db.php");
	
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

	";  

	if ($stmt = $db->prepare($sql)) 
	{
		$stmt->execute();    // Execute the prepared query.
		$stmt->store_result();
		$stmt->bind_result($id, $contentType, $contentLocation, $displayTime, $dateStart, $dateEnd, $addedBy);
		$content = "";
		
		while($stmt->fetch())
		{
			$displayTimeInSeconds = $displayTime/1000;
		
			if($contentType == 'iframe')
			{
				$content .= "
					<div style='width: 500px; margin: 5px; display: inline-block; border: solid 1px; padding: 10px;'>
						<img src='images/iframe.jpg' style='width:100%;'>
						<br />
						<strong><a href='$contentLocation' target='_blank'>$contentLocation</a></strong>
						<br />
						Live from <strong>$dateStart</strong> through <strong>$dateEnd</strong>
						<br />
						Display Time: <strong>$displayTimeInSeconds seconds</strong>
						<br />
						Added by <strong>$addedBy</strong>
					</div>
				";
			}
			else if($contentType == 'image')
			{
				$content .= "
					<div style='width: 500px; margin: 5px; display: inline-block; border: solid 1px; padding: 10px;'>
						<a href='$contentLocation' target='_blank'><img src='$contentLocation' style='width:100%;'></a>
						<br />
						<strong><a href='$contentLocation' target='_blank'>$contentLocation</a></strong>
						<br />
						Live from <strong>$dateStart</strong> through <strong>$dateEnd</strong>
						<br />
						Display Time: <strong>$displayTimeInSeconds seconds</strong>
						<br />Added by <strong>$addedBy</strong>
					</div>
				";
			}
			
		}
		
		echo("$content");		

	}
	else
	{
		echo("<div class='alertWarning'>Error preparing SQL in propagandaGetActiveContent.php: That's weird!");
	}

?>
