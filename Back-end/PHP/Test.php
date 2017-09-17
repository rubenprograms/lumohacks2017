<?php
	require_once 'connect.php';

	$connection = openConnection();

	if (!$connection) die("Unable to connect to MySQL: " . mysql_error());


	//Get user input:
	$predisposition = $_POST['Answer2']; //This should be a boolean value. 0 for false and 1 for true
	$diagnosed = $_POST['Answer1']; //Should be a boolean value
	$substanceUser = $_POST['Answer3']; //Should be a boolean value

	$questionnaireID = time();

	//Assemble the query to insert the basic questionnaire's responses into the database:
	$storeQuestionnaireResponsesQuery = "INSERT INTO QuestionnaireResults(id, diagnosedBefore, susbtanceUser, familyHistoryOfMentalIllness) VALUES($questionnaireID, $diagnosed, $substanceUser, $predisposition)";
	echo $storeQuestionnaireResponsesQuery . "<br/>";
	if(! $connection->query($storeQuestionnaireResponsesQuery))
	{
		echo "The answers to the questionnaire were not stored!";
	}

	//Associate the patient's health record to its questionnaire's responses:
	$email = $_POST['email']; //Get who is filling out the questionnaire right now.
	$theHealthRecordID = $connection->query("SELECT id FROM healthRecord WHERE email = '$email'");
	$hrIDs = $theHealthRecordID->fetch_array();
	foreach($hrIDs as $el)
	{
		echo "element = $el<br/>";
	}
	if(!$theHealthRecordID)
	{
		echo "User $email has no health record! Try signing up again.";
	}
	else
	{
		echo "\$hrIDs[0] = $hrIDs[0]<br/>";
		$associateHRwithQuestionnaireR = "INSERT INTO healthRecord_records_QuestionnaireResults(healthRecordID, questionnaireResultsID) VALUES($hrIDs[0],$questionnaireID)";
		if($connection->query($associateHRwithQuestionnaireR) == FALSE)
		{
			echo "The health record of $email was not associated with questionnaire $questionnaireID";
		}
	}

	$symptomps = $_POST['Answer4'];
	if(!$symptomps)
	{
		die("Empty array of symptomps!");
	}
	foreach($symptomps as $s)
	{
		$symptompID = $connection->query("SELECT id FROM Symptomp WHERE name = '$s'");
		$symptompIDs= $symptompID->fetch_array();
		$symptompIDValue = $symptompIDs[0];
		//DEBUGecho "\$symptompIDValue = $symptompIDValue";
		$insertQuery = "INSERT INTO Patient_has_Symptomps(patientsEmail, symptompID) VALUES('$email', $symptompIDValue)";
		if(! $connection->query($insertQuery))
		{
			echo "Symptomp $s could not be added to patient $email";
		}
	}

	//Retrieve the names of the disorders that have the same symptomps as the person's symptomps.
	$patientsDisorders;
	$disorders;
	for($i = 0; $i < count($symptomps); $i++)
	{
		$disorders[$i] = "SELECT DISTINCT d.disorderName FROM Disorder_has_Symptomps d, Symptomp s WHERE d.symptompID = s.id AND s.name = '$symptomps[$i]'";
	}
	//Get all disorders possible:
	$getAllDisorders = "SELECT name FROM Disorder";
	$allDisordersResponse = $connection->query($getAllDisorders);
	echo "num of rows in \$allDisordersResponse: $allDisordersResponse->num_rows<br/>";
	$allDisorders = $allDisordersResponse->fetch_all(MYSQLI_NUM);
	//For each disorder, create an key-value pair in $patientsDisorders:
	for($i = 0; $i < count($allDisorders); $i++)
	{
		$currentArray = $allDisorders[$i];
		print "The size of \$currentArray is " . count($currentArray) ."<br/>";
		print "The contents of current array \n\r are: <br/>";
		for($j = 0; $j < count($currentArray); $j++)
		{
			print "\$currentArray[$j] : $currentArray[$j]<br/>";
		}
	}
	/*
	foreach($allDisorders as $d)
	{
		echo "DISORDER--------->$d[0]             .";
		$patientsDisorders[$d[0]] = 0;//False
	}
	*/

	//For each of the identified disorders, set its value to true in array $patientsDisorders:
	header("Location: ../../Hackathon/Help.html");
	for($i = 0; $i < count($disorders); $i++)
	{
		for($arrOfDisorders = $disorders[$i], $j = 0; $j < count($arrOfDisorders); $j++)
		{
			echo "Implement this! Test.php: line 76";
		}

	}





?>