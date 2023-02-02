async function update_checkbox() 
		{
			//Set database ID as a variable.
			var databaseID = document.getElementById(event.srcElement.id).getAttribute("db_ID");
			//Set database table as a variable.
			var database_table = document.getElementById(event.srcElement.id).getAttribute("db_table");
			//Set database field as a variable.
			var database_field = document.getElementById(event.srcElement.id).getAttribute("db_field");

			//Default checked to false.
			var checked = false;
		
			if (document.getElementById(event.srcElement.id).checked == true) {
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

		async function click_remove_button() 
		{
			//Set database ID as a variable.
			var databaseID = document.getElementById(event.srcElement.id).getAttribute("db_ID");
			
			if (document.getElementById(event.srcElement.id).checked == true) {
				checked = true;
				console.log(checked);
			}

			//Using fetch() API
			
			//Set URL as a variable.
			var url = 'remove-record.php';

			var data = new FormData();
			data.append("databaseID", databaseID);
			
			//Use fetch API with POST method. Then turn JSON object containing data into a string to be read in PHP.
			let resp = await fetch(url, { method: 'POST', body: data });
			let result = await resp.text();
			alert(result);
			
			//Refresh page
			location.reload();
		}