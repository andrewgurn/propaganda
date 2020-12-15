<?php

	require_once("propagandaConfig.php");
	require_once("db.php");
	
	$dbObj = new Db();
	$db = $dbObj->getMariaDbConnection();
	$orderBy = "";
	if(RANDOMIZEDCONTENT === true)
	{
		$orderBy = "order by rand()";
	}
	
	$sql="
		select 
			id
			,contentType
			,contentLocation
			,displayTime
			,getVariables
		from propaganda
		where NOW() between dateStart and dateEnd
		$orderBy
	";  

	$styleDisplay = '';
	$classCurrent = 'current';

	if ($stmt = $db->prepare($sql)) 
	{
		$stmt->execute();    // Execute the prepared query.
		$stmt->store_result();
		$stmt->bind_result($id, $contentType, $contentLocation, $displayTime, $getVariables);
		$content = "";
		
		while($stmt->fetch())
		{
			
			if($contentType == 'iframe')
			{
				$iframeURL = $contentLocation.'?getVariables='.$getVariables;
				$content .= "<div id='content-$id' class='propagandaContent $displayTime $classCurrent' style='$styleDisplay'><iframe id='$id' src='$iframeURL'></iframe></div>";
			}
			else if($contentType == 'image')
			{
				$content .= "<div id='content-$id' class='propagandaContent $displayTime $classCurrent' style='$styleDisplay'><img id='$id' src='$contentLocation'></div>";
			}
			
			
			//after one run through, set the display to none and the current class flag to blank.
			$styleDisplay = 'display: none;';
			$classCurrent = '';	
		}
		
		echo("$content");		

	}
	else
	{
		return "<div class='alertWarning'>Error preparing SQL in propagandaLoader.php: Does your display device have a network connection?</div>";
	}

?>
