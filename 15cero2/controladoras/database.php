<?php

function getConnection(){
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "db15cero2";

    // Create connection
    $conn = new mysqli($servername, $username, $password,$dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
   }
    return $conn;
}
?>
