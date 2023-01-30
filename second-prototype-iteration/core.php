<?php

    //Define error types
    const ERROR_TYPE = ['Database error'];

    function error($error_type, $error_message)
    {
        echo '<script type="text/javascript">alert("' . $error_type . ': ' . $error_message . '.");</script>';
        die();
    }

    function generate_SQL_select($tables, $columns, $join_methods = null, $conditions = null)
    {
        $sql = "SELECT " . implode(", ", $columns) . " FROM " . implode(", ", $tables);

        if($join_methods != null)
        {
            $sql .= " JOIN " . $join_methods;
        }

        if($conditions != null)
        {
            $sql .= " WHERE " . $conditions;
        }

        return $sql;
    }

    function generate_SQL_insert() 
    {
        //Needs writing
    }

    class Query 
    {
        // Database credentials
        private $servername;
        private $username;
        private $password;
        private $database;
        private $connection;
        private $result;
        private $sql;
        private $query_all = false;
        private $query_array;

        public function __construct($query = null, $query_type = null, $tables = null, $columns = null, $join_methods = null, $conditions = null)
        {
            if ($query != null)
            {
                $this->servername = "wyvernsite.net";
                $this->username = "wyvernsi_sebMurray";
                $this->password = "L0n3someP0l3cat";
                $this->database = "wyvernsi_sebM";
                
                $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->database);

                if ($this->connection->connect_error) 
                {
                    error(ERROR_TYPE[0], $this->connection->connect_error);
                }

                $this->result = $this->connection->query($query);
            } 
            else 
            {
                if ($query_type == "SELECT") 
                {
                    $this->sql = generate_SQL_select($tables, $columns, $join_methods, $conditions);
                }

                if ($columns == "*")
                {
                    $this->query_all = true;
                }
                else
                {
                    $this->query_array = $columns;
                }


                $this->servername = "wyvernsite.net";
                $this->username = "wyvernsi_sebMurray";
                $this->password = "L0n3someP0l3cat";
                $this->database = "wyvernsi_sebM";

                $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->database);

                if ($this->connection->connect_error) {
                    error(ERROR_TYPE[0], $this->connection->connect_error);
                }

                $this->result = $this->connection->query($this->sql);
            }
        }

        public function build_table($columns, $button = null)
        {
            echo '<div class="mt-2 col-md-12">';
            echo '<table class="table table-striped table-bordered">';
            echo '<thead>';
            echo '<tr>';

            $output = [];

            if ($this->query_all != true)
            {
                for ($x = 0; $x <= count($this->query_array); $x++)
                {
                    $columns_query = new Query('SELECT column_title FROM _COLUMNS WHERE column_name = "' . $this->query_array[$x] . '"');
                    
                    $result = $columns_query->get_result();

                    $output = array_push($output, $result->fetch_array(MYSQLI_NUM));

                    echo $output;
                }
            }

            $count = 0;

            //Table column headings
            while ($count < count($columns))
            {
                echo '<th scope="col">' . $columns[$count] . '</th>';
                $count = $count + 1;
            }

            if ($button != null)
            {
                echo '<th scope="col" style="background-color: white; border: none;"></th>';
            }
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_array($this->result)) {
                echo "<tr>";
                for ($i = 0; $i < mysqli_num_fields($this->result); $i++) {
                    echo "<td>" . $row[$i] . "</td>";
                }
                echo "</tr>";
            }
            echo '</tbody>';
            echo "</table>";
        }

        public function get_result()
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
?>