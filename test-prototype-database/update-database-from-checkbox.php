<?php
	
	// Prevent browser from caching page, and stopping database connection for every request.
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	$databaseID = $_POST['databaseID'];
	$POSTchecked = $_POST['checked'];

	if ($POSTchecked == 'true')
	{
		$checked = 1;
	}
	else
	{
		$checked = 0;
	}
	
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
	$sql = "SELECT Test_Enabled FROM Test_Table WHERE Test_ID='" . $databaseID . "'";

	//Request SQL query, store the response in $result
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
		$enabled = $row["Test_Enabled"];
	  }
	}

	//Value has just been changed to trigger the PHP, therefore check it is NOT equal to.
	if ($enabled != $checked)
	{
		$sql = "UPDATE $tablename SET Test_Enabled='" . $checked . "' WHERE Test_ID='" . $databaseID . "'";
		
		//Request SQL query, store the response in $result
		$result = $conn->query($sql);

		if ($result === TRUE) {
		  echo "Record updated successfully.";
		} else {
		  echo "Error updating record: " . $conn->error . ".";
		}
		$conn->close();
	}
	else {
		echo "Error: Checkbox does not match database value of " . $enabled;
		$conn->close();
	}

?>
