<?php
	require_once("db.php");

	$dateStart =$_POST['dateStart'];
	$dateEnd = $_POST['dateEnd'];
	$contentType = $_POST['contentType'];
	$contentLocation = $_POST['contentLocation'];
	$displayTime = ($_POST['displayTime'])*1000;
	$addedBy = $_POST['addedBy'];
	
	$dbObj = new Db();
	$db = $dbObj->getMariaDbConnection();
	$sql="
		insert into propaganda
		(dateStart, dateEnd, contentType, contentLocation, displayTime, addedBy)
		values 
		(
			?
			,?
			,?
			,?
			,?
			,?
		)
	
	";  

	if ($stmt = $db->prepare($sql)) 
	{
		$stmt->bind_param('ssssis', $dateStart, $dateEnd, $contentType, $contentLocation, $displayTime, $addedBy);
		if($stmt->execute())
		{
			echo("<div class='alertSuccess'>Propaganda successfully added!!</div>");
		}
		else 
		{
			echo('<div class="alertWarning">ERROR: SQL execution error in propagandaAdd.php</div>');
		}
	} 
	else 
	{
  		echo('<div class="alertWarning">ERROR: SQL prepare error in propagandaAdd.php</div>');
	}

	$db->close();

?>
