<?php
class createConnection
{
    

    function connectToDatabase() 
    {
        $host="localhost";
     $username="root";
     $password="";
     $database="xmltosql";
     $myconn;
	    $conn= new PDO("mysql:host=$host;dbname=$database",$username,$password);

        if(!$conn)
        {
            die ("Cannot connect to the database");
        }

        else
        {

            $this->myconn = $conn;

            echo "Connection established";

        }

        return $this->myconn;

    }


    function closeConnection()
    {
        mysql_close($this->myconn);

        echo "Connection closed";
    }

}

?>