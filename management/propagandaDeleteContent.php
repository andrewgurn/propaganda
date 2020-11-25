<?php
	require_once("../db.php");

	$user = $_SERVER['REMOTE_USER'];
	$contentID = $_POST['contentID'];
	
	$dbObj = new Db();
	$db = $dbObj->getMariaDbConnection();
	$sql="
		update propaganda
		set isDeleted = 1
		where id = ?
			and addedBy = ?
	
	";  

	if ($stmt = $db->prepare($sql)) 
	{
		$stmt->bind_param('is', $contentID, $user);
		if($stmt->execute())
		{
			echo("<div class='alertSuccess'>Propaganda successfully deleted!!</div>");
		}
		else 
		{
			echo('<div class="alertWarning">ERROR: SQL execution error in propagandaDeleteContent.php</div>');
		}
	} 
	else 
	{
  		echo('<div class="alertWarning">ERROR: SQL prepare error in propagandaDeleteContent.php</div>');
	}

	$db->close();

?>

?>
