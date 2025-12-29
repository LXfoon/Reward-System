<?php
     //create db connection
    $host = "localhost"; //IP address
    $user = "root"; //admin by def
    $password = "";
    $db = "pointsyst";
    $conn = mysqli_connect($host, $user, $password, $db);

    if(!$conn){
        die("Connection failed: ".mysqli_connect_error()); //die: print and execute
    }else{
        echo "Connected successfully";
    }
?>