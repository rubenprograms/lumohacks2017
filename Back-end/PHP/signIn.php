<?php
	require_once 'connect.php';

	//Connect to the database
	$connection = openConnection();

	if (!$connection) die("Unable to connect to MySQL: " . mysql_error());

	//Get the user input
	$email = $_POST['Email'];
	$password = $_POST['Password'];

	$query = "SELECT * FROM Patient WHERE email = '$email' AND thePassword = '$password'";

	$data = $connection->query($query);

	$nameOfCookieToKnowIfAUserIsRegistered = "email";
	//The user has not signed up
	if($data->num_rows == 0)
	{
		$signingInFailed = '../../Hackathon/SignIn.html';
		setcookie("$nameOfCookieToKnowIfAUserIsRegistered", "failedSignIn");
		header('Location: '.$signingInFailed);
	}
	//The user has signed up!
	else
	{
		setcookie($nameOfCookieToKnowIfAUserIsRegistered, $email);
		$signingInSuccessful = '../../Hackathon/Home.html';
		//echo "cookie: " . $_COOKIE[$nameOfCookieToKnowIfAUserIsRegistered];
		header('Location: '.$signingInSuccessful);
	}


	print "Email: $email Password: $password";
	print "query = $query ";


?>