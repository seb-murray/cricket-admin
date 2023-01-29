<?php

	$name = $_POST['name'];
	$description = $_POST['description'];

	// Define database credentials
	$servername = "wyvernsite.net";
	$username = "wyvernsi_sebMurray";
	$password = "L0n3someP0l3cat";
	$dbname = "wyvernsi_sebM";

	$tablename = "Test_Table";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	//Define SQL query in $sql
	$sql = "INSERT INTO $tablename (Test_Name, Test_Description, Test_Created) VALUES ('$name', '$description', DEFAULT)";
	//Request SQL query, store the response in $result
	$result = $conn->query($sql);

	if ($result === TRUE) {
	  echo "Record added successfully.";
	} 
	else 
	{
	  echo "Error adding record: " . $conn->error . ".";
	}

	$conn->close();
?>