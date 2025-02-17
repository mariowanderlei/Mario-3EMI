<?php
// Configuração de conexão ao banco de dados
$servername = "localhost";
$username = "root";
$Senha = "";
$dbname = "cadastro_de_livro";

// Criar conexão com PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $Senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>
