<?php
	require_once("../includes/db.php");

	$dateStart =$_POST['dateStart'];
	$dateEnd = $_POST['dateEnd'];
	$contentType = $_POST['contentType'];
	$contentLocation = $_POST['contentLocation'];
	$displayTime = ($_POST['displayTime'])*1000;
	$addedBy = $_POST['addedBy'];
	$channelID = $_POST['channelID'];
	
	$paramsArray = ['ssssisi', $dateStart, $dateEnd, $contentType, $contentLocation, $displayTime, $addedBy, $channelID ];
	
	$db = new db();
	$conn = $db->getMariaDbConnection();
	$sql="
		insert into propaganda
		(dateStart, dateEnd, contentType, contentLocation, displayTime, addedBy, channelID)
		values 
		(
			?
			,?
			,?
			,?
			,?
			,?
			,?
		)
	
	";  
	
	$stmt = $db->parameterQuery($conn, $sql, $paramsArray);

?>
