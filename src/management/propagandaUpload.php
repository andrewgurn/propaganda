<?php

	$response = 0;

	if(isset($_FILES['file']['name']))
	{
		$filename = $_FILES['file']['name'];
		$date = new DateTime();
		$timestamp = $date->getTimestamp();
		$finalFilename = $timestamp.$filename;
		$location = "propagandaUploads/$finalFilename";
		$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
		$imageFileType = strtolower($imageFileType);
		$validExtensions = array("jpg","jpeg","png","gif");
		

		if(in_array(strtolower($imageFileType), $validExtensions)) 
		{
			if(move_uploaded_file($_FILES['file']['tmp_name'],'../'.$location))
			{
				$response = $location;
			}
		}

		echo $response;
	}
	else
	{
		echo $response;
	}
		

?>
