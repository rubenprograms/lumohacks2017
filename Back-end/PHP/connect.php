<?php

	function openConnection()
	{
		$db_hostname = 'localhost'; //IP address 127.0.0.1
		$db_database = 'lumohacksDatabase'; 
		$db_username = 'root'; 
		$db_password = 'root';
		$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database) or die("Connect failed: %s\n". $conn -> error);
		return $conn;
	}

	function CloseCon($conn)
	{
		$conn -> close();
	}
?>