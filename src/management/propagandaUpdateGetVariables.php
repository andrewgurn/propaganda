<?php
	require_once("../includes/db.php");

	$user = $_SERVER['REMOTE_USER'];
	$contentID = $_POST['contentID'];
	$getVariables = $_POST['getVariables'];
	
	$db = new db();
	$conn = $db->getMariaDbConnection();
	$sql="
		update propaganda
		set getVariables = ?
		where id = ?
	";  
	
	$paramsArray = ['si', $getVariables, $contentID];
	$stmt = $db->parameterQuery($conn, $sql, $paramsArray);
	
	if(is_object($stmt))
	{
		echo("<div class='alertSuccess'><strong>Updated!</strong></div>");
	}
	else
	{
		echo("<div class='alertWarning'><strong>ERROR:</strong> $stmt</div>");
	}
	

?>
