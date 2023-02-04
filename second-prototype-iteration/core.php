<?php
    // Define database credentials
	$servername = "wyvernsite.net";
	$username = "wyvernsi_sebMurray";
	$password = "L0n3someP0l3cat";
	$dbname = "wyvernsi_sebM";

    //Define error types
    const ERROR_TYPE = ['Database error', 'Logic error'];

    //2 dimensional array containing database column names and their corresponding titles in plain English
    const FIELD_TITLES = [
        0 => ["club_ID", "Club ID"],
        1 => ["club_name", "Club Name"],
        2 => ["event_ID", "Event ID"],
        3 => ["event_name", "Event Name"],
        4 => ["guardianship_ID", "Guardianship ID"],
        5 => ["parent_ID", "Parent ID"],
        6 => ["child_ID", "Child ID"],
        7 => ["member_ID", "Member ID"],
        8 => ["member_name", "Member Name"],
        9 => ["member_DOB", "Member DOB"],
        10 => ["member_gender", "Member Gender"],
        11 => ["admin", "Admin"],
        12 => ["participant_ID", "Participant ID"],
        13 => ["team_member_ID", "Team Member ID"],
        14 => ["event_ID", "Event ID"],
        15 => ["role_ID", "Role ID"],
        16 => ["role_name", "Role Name"],
        17 => ["team_ID", "Team ID"],
        18 => ["team_name", "Team Name"],
        19 => ["team_nickname", "Team Nickname"],
        20 => ["team_member_ID", "Team Member ID"]
    ];

    //2 parts of button code, so ID can be stitched inside
    const BUTTONS = [
        // First part of button / Second part of button / Button type
        1 => ['<button class="btn btn-danger"type="button" onclick="click_remove_button(event)"', '><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
        </svg></button>', "trashcan_button"]
    ];

    function get_title($field_name)
    {
        //Can pass in both strings and arrays to get_title()

        //Check if $field_name is a string
        if (is_string($field_name))
        {
            //Loop through items in FIELD_TITLES[] - (count(FIELD_TITLES) - 1) because count() returns the number of items in an array, but array indexes start from 0
            for ($x = 0; $x <= (count(FIELD_TITLES) - 1); $x++)
            {
                //If the database field name matches the parameter entered, return the corresponding plain English field title
                if (FIELD_TITLES[$x][0] == $field_name)
                {
                    return FIELD_TITLES[$x][1];
                }
            }
            //If no match is found, log an error and return null
            error(ERROR_TYPE[1], "An input did not match any items in array");
            return "Null";
        }
        //Check if $field_name is an array - this section of code could be rewritten recursively if time allows
        elseif (is_array($field_name))
        {
            //Define empty array, so the output can be added to the end of it inside the loop
            $result = [];
            
            //Loop through items in the array passed in the parameter - (count($field_name) - 1) because count() returns the number of items in an array, but array indexes start from 0
            for ($y = 0; $y <= (count($field_name) - 1); $y++)
            {
                //Loop through items in FIELD_TITLES[] - (count(FIELD_TITLES) - 1) because count() returns the number of items in an array, but array indexes start from 0
                //Must loop through all values in FIELD_TITLES[] for every value in the parameter array
                for ($x = 0; $x <= (count(FIELD_TITLES) - 1); $x++)
                {
                    if (FIELD_TITLES[$x][0] == $field_name[$y])
                    {
                        //If the database field name matches the parameter entered, add the corresponding plain English field title to the end of the array which will be returned
                        array_push($result, FIELD_TITLES[$x][1]);
                    }
                }
            }
            //Return the $result[] array
            return $result;
        }
    }

    //Custom error logging function - allows easy changes to how errors are logged. This will be improved if time allows.
    function error($error_type, $error_message)
    {
        echo '<script type="text/javascript">alert("' . $error_type . ': ' . $error_message . '.");</script>';
        die();
    }

    class Query 
    {
        // Will contain credentials
        private $servername;
        private $username;
        private $password;
        private $database;
        
        // Database connection
        private $connection;
        
        // Contains SQL query results
        private $result;

        public function __construct($query, string $alt_database = null)
        {
            // Define database credentials
            $this->servername = "wyvernsite.net";
            $this->username = "wyvernsi_sebMurray";
            $this->password = "L0n3someP0l3cat";
            $this->database = "wyvernsi_sebM";
            
            //Initialise MySQLi connection
            if ($alt_database == null)
            {
                $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->database);
            }
            else
            {
                $this->connection = new mysqli($this->servername, $this->username, $this->password, $alt_database);
            }
            

            //If an error occurs, call error log function
            if ($this->connection->connect_error) 
            {
                error(ERROR_TYPE[0], $this->connection->connect_error);
            }

            $this->result = $this->connection->query($query);

            //Place result in $result variable - accessible by class methods
            if ($this->result == false)
            {
            error(ERROR_TYPE[0], $this->connection->error);
            }
            
        }

        //Build table from MySQLi output
        //Array containing database field names / Toggle for showing ID in table / Variable containing button to show in table (e.g. delete record, defaults to null) / Array containing which fields should show a checkbox for Boolean values (defaults to null)
        public function build_table(array $fields, bool $show_ID = false, $button = null, array $checkbox = null)
        {
            $columns = get_title(split_2d_array($fields, 0));
            $tables = split_2d_array($fields, 1);
            $db_columns = split_2d_array($fields, 0);

            echo '<div class="mt-2 col-md-12">';
            echo '<table class="table table-striped table-bordered">';
            echo '<thead>';
            echo '<tr>';

            $x = 0;

            if ($show_ID == false)
            {
                $x = 1;
            }
            else
            {
                $x = 0;
            }

            //Table column headings
            while ($x < count($columns))
            {
                echo '<th scope="col">' . $columns[$x] . '</th>';
                $x++;
            }

            if ($button != null)
            {
                echo '<th scope="col" style="background-color: white; border: none;"></th>';
            }
            
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            while ($row = mysqli_fetch_array($this->result)) 
            {
                echo "<tr>";

                if ($show_ID == false)
                {
                    $i = 1;
                }
                else
                {
                    $i = 0;
                }

                for (; $i < mysqli_num_fields($this->result); $i++) 
                {
                    if (in_array($i, $checkbox))
                    {
                        echo '<td align="center"> <input class="form-check-input" autocomplete="off" type="checkbox" value="" onclick="update_checkbox(event)" id="' . strtolower($columns[$i]) . "_" . $row[0] . '" db_ID="' . $row[0] . '" db_table="' . $tables[$i] . '" db_field="' . $db_columns[$i] . '"';			
                        
                        if ($row[$i] == "1") {
                        echo ' checked> </td>';
                        }
                        elseif ($row[$i] == "0") {
                        echo ' ></td>';
                        }
                    }
                    else
                    {
                        echo "<td>" . $row[$i] . "</td>";
                    }
                }
                if ($button != null)
                {
                    echo '<td align="center" style="background-color: white; border: none;">' . BUTTONS[$button][0] . ' id="' . BUTTONS[$button][2] . "_" . $row[0] . '" db_id="' . $row[0] . '" db_table="' . $tables[0] . '"' . BUTTONS[$button][1] . '</td>';
                }
                echo "</tr>";
            }
            echo '</tbody>';
            echo "</table>";
        }

        public function get_result()
        {
            $result = [];
            
            if (is_bool($this->result) == false)
            {
                while ($row = mysqli_fetch_array($this->result)) 
                {
                    for ($i = 0; $i < mysqli_num_fields($this->result); $i++) 
                    {
                        array_push($result, $row[$i]);
                    }
                }
                
                return $result;
            }
            else
            {
            return "Error :(";
            }
            
        }

        public function get_plain_result()
        {
            return $this->result;
        }

        public function __destruct()
        {
            //Attempt to close
            $closeResults = $this->connection->close();

            //Error reporting
            if($closeResults === false)
            {
            error(ERROR_TYPE[0], "Could not close MySQL connection");
            }
        }
    }

    function get_DB_ID(string $table_name)
    {
        $query = new Query("SELECT UNIQUE K.COLUMN_NAME FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS T JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE K ON K.CONSTRAINT_NAME = T.CONSTRAINT_NAME WHERE K.TABLE_NAME='" . $table_name . "' AND T.CONSTRAINT_TYPE = 'PRIMARY KEY'", "information_schema");
        $PK = $query->get_result();
        return implode($PK);
    }

    function split_2d_array(array $array, int $column)
    {
        $output = [];

        for ($i = 0; $i <= (count($array) - 1); $i++)
        {
            array_push($output, $array[$i][$column]);
        }

    return $output;
    }

?>