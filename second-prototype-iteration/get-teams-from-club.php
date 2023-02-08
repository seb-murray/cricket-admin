<?php

    include 'core.php';

	$databaseID = $_POST['databaseID'];

    $sql = "SELECT TEAMS.team_ID, TEAMS.team_name FROM CLUBS INNER JOIN TEAMS WHERE TEAMS.club_ID = CLUBS.club_ID AND TEAMS.club_ID = " . $databaseID;

    //echo $sql;

    $query = new Query($sql);

	//Request SQL query, store the response in $result
    $result = $query->get_result();

    $output = [];

    for ($x = 0; $x <= (count($result) - 1); $x += 2)
    {
        array_push($output, [$result[$x], $result[($x + 1)]]);
    }

    echo json_encode($output);
?>