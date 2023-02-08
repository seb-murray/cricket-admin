<?php

    include 'core.php';

	$databaseID = $_POST['databaseID'];
    $tablename = $_POST['database_table'];

    $sql = "DELETE FROM $tablename WHERE " . get_DB_ID($tablename) . " = '$databaseID'";
    //echo $sql . "\n";

    $query = new Query($sql);


	//Request SQL query, store the response in $result
    $result = $query->get_result();

?>