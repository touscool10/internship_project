<?php
// Stabilish connection
    $server = "localhost";
    $user = "crespin";
    $password = "18501405";
    $database = "andes";
    $connection = mysqli_connect($server,$user,$password,$database);

// Connection test
    if(mysqli_connect_errno()) {
        die("Connection error no: " . mysqli_connect_errno());
    }
?>