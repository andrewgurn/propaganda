<?php

	require_once("propagandaConfig.php");
	require_once("includes/db.php");
	
	$db = new db();
	$conn = $db->getMariaDbConnection();
	$orderBy = "";
	
	if(isset($_POST['channelID'])){ $channelID = $_POST['channelID']; }else{ $channelID = 1; }
	
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
		where (channelID = 1 OR channelID = ?)
			and NOW() between dateStart and dateEnd
			and isDeleted = 0
		$orderBy
	";  

	$paramsArray = ['i', $channelID];
	$stmt = $db->parameterQuery($conn, $sql, $paramsArray);
	$styleDisplay = '';
	$classCurrent = 'current';

	if (is_object($stmt)) 
	{
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
		return "<div class='alertWarning'>Error: $stmt</div>";
	}

?>
