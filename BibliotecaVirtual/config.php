<?php
    

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cadastro_de_livro";


    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }
?>