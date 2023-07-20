<?php
	require_once("../includes/db.php");

	$user = $_SERVER['REMOTE_USER'];
	$contentID = $_POST['contentID'];
	
	$db = new db();
	$conn = $db->getMariaDbConnection();
	$sql="
		update propaganda
		set isDeleted = 1
		where id = ?
			and addedBy = ?
	
	";  

	$paramsArray = ['is', $contentID, $user];
	$stmt = $db->parameterQuery($conn, $sql, $paramsArray);

	if(is_object($stmt))
	{
		echo("<div class='alertSuccess'>Propaganda successfully deleted!!</div>");
	}
	else
	{
		echo("<div class='alertWarning'><strong>ERROR:</strong> $stmt</div>");
	}	
		
?>
