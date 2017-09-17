<?php
	//Establish a connection to the database:
	require_once 'login.php';
	require_once 'util.php';
	require_once 'connect.php';


	$connection = openConnection();

	if (!$connection) die("Unable to connect to MySQL: " . mysql_error());

	//Get values of fields
	$firstName = $_POST['firstname'];
	$lastName = $_POST['lastname'];
	$email = $_POST['email'];
	$password  = $_POST['password'];
	$birthday  = $_POST['bday'];
	
	$insertion_query = "INSERT INTO Patient(email, firstName, lastName, thePassword, dateOfBirth) VALUES('$email', '$firstName', '$lastName', '$password', '$birthday')";
	//echo $insertion_query;

	if($connection->query($insertion_query) == FALSE)
	{
		echo "The data was not stored in the database!";
	}
	else
	{
		$redirect = '../../Hackathon/SignIn.html';
		header("Location: ". $redirect);
	}

	$healthRecordID = time();

	$healthRecordQuery = "INSERT INTO healthRecord(id, email) VALUES('$healthRecordID', '$email')";

	if(!$connection->query($healthRecordQuery))
	{
		echo "The health record was not recorded!";
	}


	//mysql_fatal_error("Inside signUp.php, line 9: TESTING."); //DEBUG

?>