<!doctype html>
<html><head>
<meta charset="UTF-8">
<title>New Element</title>
	<link rel="icon" type="image/x-icon" href="\favicon.ico">
	
	<!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
	
	
	<script type="text/javascript">
		window.onload = function() {
			const submitButton = document.getElementById("submit-button");
			submitButton.addEventListener("click", addElement); //Event listener.
			//No brackets after addElement() to pass function byRef, so it only runs when the submit button is pressed.
		}
		
		async function addElement() {
			
			var name = document.getElementById("element-name").value;
			var description = document.getElementById("element-description").value;
			
			console.log(name);
			console.log(description);
			
			var url = 'add-element-script.php';

			var data = new FormData();
			data.append("name", name);
			data.append("description", description);
			
			//Use fetch API with POST method. Then turn JSON object containing data into a string to be read in PHP.
			let resp = await fetch(url, { method: 'POST', body: data });
			let result = await resp.text();
			alert(result);

			window.location.replace("test-database.php");
		}
	</script>
</head>

<body>
	<div class="mt-2 col-md-12">
			<div class="d-grid gap-5">
				
				<div class="mt-3">
					<label for="element-name" class="form-label">Element name</label>
					<input type="text" class="form-control" id="element-name" placeholder="Name" value="" required="">
				</div>

				<div class="mt-3">
					<label for="element-description">Element description</label>
					<textarea class="form-control" id="element-description" rows="3" placeholder="Description"></textarea>
				</div>
				
				<div class="mt-3">
					<button class="w-100 btn btn-primary" id="submit-button" type="submit" >Submit</button>
				</div>	
				
			</div>
	</div>
</body>
</html>