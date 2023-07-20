<?php

class db
{
	function getMariaDbConnection($serverName="[your server]", $dbName="[propaganda]", $userName="[a MariaDB user with CRUD permissions]", $password="[password for that user]")
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
	
	function basicQuery($conn, $sql)
	{
		if ($stmt = $conn->prepare($sql)) 
		{
			if($stmt->execute())
			{
				$stmt->store_result();
				return $stmt;
			}
			else
			{
				$error = $conn->error;
				return "Died executing: $error";
			}
		}
		else
		{
			$error = $conn->error;
			return "Died preparing: $error";
		}
	}
	
	function parameterQuery($conn, $sql, $paramsArray)
	{
		if ($stmt = $conn->prepare($sql)) 
		{
			$tmp = array();
			foreach($paramsArray as $key => $value) $tmp[$key] = &$paramsArray[$key];
			call_user_func_array(array($stmt, 'bind_param'), $tmp);
		
			if($stmt->execute())
			{
				$stmt->store_result();
				return $stmt;
			}
			else
			{
				return $conn->error;
				//return "exec fail";
			}
		}
		else
		{
			return $conn->error;
		}
	}
	
	
	function getLastInsertedID($conn)
	{
		$sql = "
			select LAST_INSERT_ID();
		";
	
		$stmt = $this->basicQuery($conn, $sql);
		$stmt->bind_result($lastID);
		$stmt->fetch();
		return $lastID;
	}
	

}

?>
