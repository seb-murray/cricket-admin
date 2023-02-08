<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Seb Murray">

    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link href="../bootstrap-5.0.2/css/bootstrap.min.css" rel="stylesheet">

    <title>Sign up</title>

    <script type="module"> 

    import sha512 from '../sha512/package.json' assert { type: "json" };

    //Event is onChange for the select club dropdown
    global async function select_team_from_club(event) 
    {
        //Assign HTML elements to constants for easier reading code
        const club_list = event.target;
        const team_list = document.getElementById("team_select");

        //Set database ID as a variable - this is the HTML value attribute of the option chosen

        var databaseID = club_list.value;

        //If there is no HTML value attribute, x.value defaults to the text contents of the option chosen
        //Default options, such as "Select club" are not assigned a value attribute
        //Therefore it's important to ensure the value passed into the PHP script is actually an ID from the database.
        //This can be done by ensuring the value is a number.

        //If databaseID is not a number, ensure team_list is hidden
        if (isNaN(parseInt(databaseID))) {
            //Empry team_list options
            team_list.innerHTML = "";

            //Create new HTML "option" element
            option = document.createElement("option");
            //Set option text "Please select a club"
            option.appendChild(document.createTextNode("Please select a club"));
            //Disable option so it can't be selected
            option.setAttribute("disabled", "disabled");
            //Add option element to team_list
            team_list.appendChild(option);
        }
        //Otherwise, call PHP script and populate team_list with database query results
        else {
            //Using fetch() API

            //Set PHP script URL as a constant
            const url = 'get-teams-from-club.php';

            //Create new FormData object
            var data = new FormData();
            //Add databaseID to FormData, with field name "databaseID"
            data.append("databaseID", databaseID);

            //Create new fetch() API request using POST method to PHP script
            //Enclose data (FormData object) in POST body
            let response = await fetch(url, {
                method: 'POST',
                body: data
            });
            //Wait for response from PHP script before continuing
            //result stores response from PHP script
            let result = await response.text();

            //PHP script output used function JSON_encode()
            //result contains stringified JSON
            //Parse result as JSON and store in JSON_result
            JSON_result = JSON.parse(result);

            //Empty team_list options
            team_list.innerHTML = "";

            //If JSON_result is not empty, add database query results as team_list options
            if (JSON_result.length != 0) {
                //Loop through every item in database query output
                for (let i = 0; i < JSON_result.length; i++) {
                    //Create new HTML "option" element
                    option = document.createElement("option");
                    //Set option "value" attribute to team_ID (primary key in TEAMS table)
                    option.setAttribute("value", JSON_result[i][0]);
                    //Set option text to team_name
                    option.appendChild(document.createTextNode(JSON_result[i][1]));
                    //Add option element to team_list
                    team_list.appendChild(option);
                }
            }
            //Otherwise, add one option: "No teams in club"
            else {
                option = document.createElement('option');
                option.appendChild(document.createTextNode("No teams in club"));
                option.setAttribute("disabled", "disabled");
                team_list.appendChild(option);
            }
        }
    }

    function sign_up()
    {
        //Assign HTML elements to constants for easier reading code
        const club_list = document.getElementById("club_select");
        const team_list = document.getElementById("team_select");
        const first_name = document.getElementById("first_name");
        const last_name = document.getElementById("last_name");
        const email = document.getElementById("email");
        const password = document.getElementById("password");

        let hashed_password = sha512(password.value);
        console.log(hashed_password);
    }
    </script>

</head>

<body>
    <div class="container">
        <div class="py-5">
            <h1>Sign up</h2>
                <p class="lead">Below is a prototype sign up form which communicates with the database. On the actual
                    system, a member won't select their club - they will be sent a club specific invite link.
                </p>
        </div>
        

        <div class="row g-5">
            <div class="col-md-7 col-lg-12">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="country" class="form-label">Club</label>
                            <?php
                    include 'core.php';
                    //Get all CLUBS (club_ID and club_name) and order by their ID
                    $select_query = new Query("SELECT club_ID, club_name 
                                                FROM CLUBS 
                                                ORDER BY club_ID ASC");
                    //Show results in a HTML select element
                    //"Select club" is the default
                    $select_query->form_select_options("Select club", "club_select", null, "select_team_from_club(event)");
				?>
                            <div class="invalid-feedback">
                                Please select a valid club.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="team_select" class="form-label">Teams
                                <span class="text-muted">(Hint: first select your club, then hold down ctrl to select
                                    multiple teams).</span>
                            </label>
                            <select multiple class="form-select" id="team_select">
                                <option disabled>Please select a club</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a club.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="first_name" class="form-label">First name</label>
                            <input type="text" class="form-control" id="first_name" placeholder="Sachin" value=""
                                required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="last_name" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="last_name" placeholder="Tendulkar" value=""
                                required>
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email"
                                placeholder="sachintendulkar@example.com">
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Please enter password">
                            <br>
                            <label for="password" class="form-label">
                                <span class="text-muted">
                                    Password must have:
                                    <ul>
                                        <li class="text-success">at least 6 characters</li>
                                        <li>one uppercase letter</li>
                                        <li>one number or symbol</li>
                                    </ul>
                                </span>
                            </label>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <button class="w-100 btn btn-primary btn-lg" onclick="sign_up()">Add member</button>
            </div>
        </div>
    </div>
</body>

</html>