<?php
	require_once("../db.php");

	$user = $_SERVER['REMOTE_USER'];
	$contentID = $_POST['contentID'];
	$getVariables = $_POST['getVariables'];
	
	$dbObj = new Db();
	$db = $dbObj->getMariaDbConnection();
	$sql="
		update propaganda
		set getVariables = ?
		where id = ?
	";  

	if ($stmt = $db->prepare($sql)) 
	{
		$stmt->bind_param('si', $getVariables, $contentID);
		if($stmt->execute())
		{
			echo("<div class='alertSuccess'><strong>Updated!</strong></div>");
		}
		else 
		{
			echo('<div class="alertWarning"><strong>ERROR:</strong> SQL execution error in propagandaUpdateGetVariables.php</div>');
		}
	} 
	else 
	{
  		echo('<div class="alertWarning"><strong>ERROR:</strong> SQL prepare error in propagandaUpdateGetVariables.php</div>');
	}

	$db->close();

?>
