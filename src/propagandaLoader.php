<?php

	require_once("propagandaConfig.php");
	require_once("includes/db.php");

	$db = new db();
	$conn = $db->getMariaDbConnection();
	$orderBy = "";
	$paramString = "";
	$paramsArray = [];
	
	if(isset($_POST['channelID']))
	{
		//Channel ID comes in as 0 if not set via get variables
		//Channel ID must be an integer
		if($_POST['channelID'] != 0 && intval($_POST['channelID']))
		{ 
			$channelID = $_POST['channelID']; 
		}
		else
		{
			$channelID = DEFAULTCHANNELID; 
		}	
	}
	else
	{ 
		$channelID = DEFAULTCHANNELID; 
	}
	
	if(isset($_POST['excludeAll'])){ $excludeAll = intval($_POST['excludeAll']); }else{ $excludeAll = 0; }
	
	if(RANDOMIZEDCONTENT === true)
	{
		$orderBy = "order by rand()";
	}
	
	if($excludeAll === 1)
	{
		$whereClause = "where channelID = ?";
		$paramString .= "i";
		$paramsArray[] = $channelID;
	}
	else
	{
		$whereClause = "where (channelID = ? OR channelID = ?)";
		$paramString .= "ii";
		$paramsArray[] = DISPLAYONALLCHANNELSCHANNELID;
		$paramsArray[] = $channelID;
	}
	
	$sql="
		select 
			id
			,contentType
			,contentLocation
			,displayTime
			,getVariables
		from propaganda
		$whereClause
			and NOW() between dateStart and dateEnd
			and isDeleted = 0
		$orderBy
	";  

	array_unshift($paramsArray, $paramString);
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
