<?php

class db
{


	function getMariaDbConnection($serverName="localhost", $dbName="your-db-here", $userName="your-user-here", $password="your-db-user-password-here")
	{
		$conn = new mysqli($serverName, $userName, $password, $dbName);
		
		if( !$conn )
		{
			 return "DB Connection failed!";
		}
		else
		{
			return $conn;
		}
	}


}

?>
