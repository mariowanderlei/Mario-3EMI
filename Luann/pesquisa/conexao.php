<?php
$servidor = "localhost";
$usuario = "root";
$senha = ""; // ajuste caso necessário
$banco = "projeto_sql";

$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>
