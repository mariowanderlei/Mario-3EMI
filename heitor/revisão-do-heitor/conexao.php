<?php 

    $localserver = "localhost";
    $username = "root";
    $password = "";
    $database = "crud_php";
    $conn = new mysqli($localserver, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Conexão falho: " . $conn->connect_error);
    }
?>