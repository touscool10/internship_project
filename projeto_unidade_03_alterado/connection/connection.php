<?php
// Stabilish connection
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "andes";
    $connection = mysqli_connect($server,$user,$password,$database);

// Connection test
    if(mysqli_connect_errno()) {
        die("Connection error no: " . mysqli_connect_errno());
    }
?>