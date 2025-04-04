<?php

$host = "localhost";
$database = "faceclone";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
    }


    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {


        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - Name: " . $row
            ["name"]. " " . $row["email"]. "<br>";
            }
            }


            $conn->close();
            ?>
            <html>
                <head>
                    <title>Faceclone</title>


                </head>
            </html>
?>