<?php

    include 'core.php';

	$databaseID = $_POST['databaseID'];
    $tablename = $_POST['database_table'];
    $fieldname = $_POST['database_field'];
	$POSTchecked = $_POST['checked'];
    

	if ($POSTchecked == 'true')
	{
		$checked = 1;
	}
	else
	{
		$checked = 0;
	}


$query = new Query("SELECT " . $fieldname . " FROM " . $tablename . " WHERE " . get_DB_ID($tablename) . "='" . $databaseID . "'");

	$result = $query->get_plain_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $enabled = $row[$fieldname];
        }
    }

	//Value has just been changed to trigger the PHP, therefore check it is NOT equal to.
	if ($enabled != $checked)
	{
		$query = new Query("UPDATE " . $tablename . " SET " . $fieldname . " = " . $checked . " WHERE " . get_DB_ID($tablename) . "='" . $databaseID . "'");
	}
	else {
		echo "Error: Checkbox does not match database value of " . $enabled;
	}

?>