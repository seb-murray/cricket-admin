<!DOCTYPE html>
<html lang="en">

<head>

	<link rel="icon" type="image/x-icon" href="../favicon.ico">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Database</title>

	<!-- Bootstrap -->
	<link href="../css/bootstrap-4.4.1.css" rel="stylesheet">
</head>

<body>
	<?php
		include 'core.php';

		$fields = 
		[
			["member_ID", "MEMBERS"], 
			["club_ID", "CLUBS"], 
			["member_name", "MEMBERS"], 
			["member_DOB", "MEMBERS"], 
			["member_gender", "MEMBERS"], 
			["admin", "MEMBERS"]
		];

		$query = new Query("SELECT " . implode(", ", split_2d_array($fields, 0)) . " FROM MEMBERS");
		$query->build_table($fields, 0, 1, [5]);
	?>

	<script>
		async function update_checkbox(event)
		{
			const element = event.target;

			//Set database ID as a variable.
			var databaseID = element.getAttribute("db_id");
			//Set database table as a variable.
			var database_table = element.getAttribute("db_table");
			//Set database field as a variable.
			var database_field = element.getAttribute("db_field");

			//Default checked to false.
			var checked = false;
		
			if (element.checked == true) {
				checked = true;
			}

			
			//Using fetch() API
			
			//Set URL as a variable.
			var url = 'checkbox-update-record.php';

			var data = new FormData();
			data.append("checked", checked);
			data.append("databaseID", databaseID);
			data.append("database_table", database_table);
			data.append("database_field", database_field);
			
			//Use fetch API with POST method. Then turn JSON object containing data into a string to be read in PHP.
			let resp = await fetch(url, { method: 'POST', body: data });
			let result = await resp.text();
		}

		async function click_remove_button(event) 
		{
			const element = event.target;

			//Set database ID as a variable.
			var databaseID = element.getAttribute("db_id");
			//Set database table as a variable.
			var database_table = element.getAttribute("db_table");

			//Using fetch() API
			
			//Set URL as a variable.
			var url = 'remove-record.php';

			var data = new FormData();
			data.append("databaseID", databaseID);
			data.append("database_table", database_table);
			
			//Use fetch API with POST method. Then turn JSON object containing data into a string to be read in PHP.
			let resp = await fetch(url, { method: 'POST', body: data });
			let result = await resp.text();
			
			//Refresh page
			location.reload();
		}
	</script>


</body>

</html>