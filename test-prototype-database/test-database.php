<?php

	// Prevent browser from caching page, and stopping database connection for every request.
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");

?>

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
	  
	<script type="text/javascript">
		async function checkboxClick() {
			//Set database ID as a variable.
			var databaseID = document.getElementById(event.srcElement.id).getAttribute("databaseID");
			//Default checked to false.
			var checked = false;

			if (document.getElementById(event.srcElement.id).checked == true) {
				checked = true;
				console.log(checked);
			}

			
			//Using fetch() API
			
			//Set URL as a variable.
			var url = 'update-database-from-checkbox.php';

			var data = new FormData();
			data.append("checked", checked);
			data.append("databaseID", databaseID);
			
			//Use fetch API with POST method. Then turn JSON object containing data into a string to be read in PHP.
			let resp = await fetch(url, { method: 'POST', body: data });
			let result = await resp.text();
			alert(result);
		}
		
		async function removeClick() {
			//Set database ID as a variable.
			var databaseID = document.getElementById(event.srcElement.id).getAttribute("databaseID");
			
			if (document.getElementById(event.srcElement.id).checked == true) {
				checked = true;
				console.log(checked);
			}

			//Using fetch() API
			
			//Set URL as a variable.
			var url = 'remove-element-script.php';

			var data = new FormData();
			data.append("databaseID", databaseID);
			
			//Use fetch API with POST method. Then turn JSON object containing data into a string to be read in PHP.
			let resp = await fetch(url, { method: 'POST', body: data });
			let result = await resp.text();
			alert(result);
			location.reload();
		}
	</script>

  </head>
  <body>
	  <div class="mt-2 col-md-12">
		  <table class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th scope="col">#</th>
			<th scope="col">Name</th>
			  <th scope="col">Created</th>
			  <th scope="col">Description</th>
			  <th scope="col">Enabled</th>
			  <th scope="col" style="background-color: white; border: none;"></th>
			</tr>
		  </thead>
		  <tbody>
			<?php
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
				$sql = "SELECT * FROM $tablename";
				//Request SQL query, store the response in $result
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
				//---------------USE AS SAMPLE CODE---------------
				  // Output data from each field in a table
				  while($row = $result->fetch_assoc()) {
					echo '<tr id="row_' . $row['Test_ID'] . '">';
					  //Repeat the following lines for as many regular columns as needed.
					echo '<th scope="row">' . $row['Test_ID'] . '</th>'; //Bold  cell
					 echo '<td>' . $row['Test_Name'] . '</td>';
					echo '<td>' . $row['Test_Created'] . '</td>'; //Regular cell
					echo '<td>' . $row['Test_Description'] . '</td>';
					  //Following places a checkbox for a boolean value - currently cannot be changed.
					echo '<td align="center"> <input class="form-check-input" autocomplete="off" type="checkbox" value="" id="checkbox_' . $row['Test_ID'] . '" onclick="checkboxClick()" databaseID="' . $row['Test_ID'] . '"';
					if ($row['Test_Enabled'] == "1") {
					  echo ' checked> </td>';
					}
					elseif ($row['Test_Enabled'] == "0") {
					  echo ' ></td>';
					}
					echo '';
					echo '<td align="center" style="background-color: white; border: none;"> <button class="btn btn-danger"type="button"id="remove_' . $row['Test_ID'] . '" onclick="removeClick()" databaseID="' . $row['Test_ID'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
</svg></button>';
				  }
				} else {
					//If $result contains no fields, show '0 results'
					echo "0 results";
				}
				$conn->close();
			  ?>
		  </tbody>
		</table>
	  </div>
	  <div class="mt-2 col-md-12">
		  <form action="new-element.php">
			<input type="submit" class="btn btn-outline-primary" value="Add element" />
		  </form>
	  </div>
  </body>
</html>
