<?php
$host = "localhost";
$user = "root"; // Alterar se necessário
$password = ""; // Coloque sua senha do MySQL
$dbname = "emprestimos_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

?>
