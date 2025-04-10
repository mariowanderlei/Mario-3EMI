<?php
session_start();
include '../processos/db.php'; // Certifique-se de que este arquivo contém a conexão com o banco de dados

// Verifica se o administrador está logado
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os valores do formulário e evita SQL Injection
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);

    // Verifica se os campos estão preenchidos corretamente
    if (!empty($nome) && !empty($descricao)) {
        // Insere no banco de dados na TABELA CERTA (equipamentos)
        $query = "INSERT INTO adicionar (nome, descricao, status) VALUES ('$nome', '$descricao', 'disponível')";
        $query = "INSERT INTO equipamentos (nome, status) VALUES ('$nome', 'disponível')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Equipamento adicionado com sucesso!'); window.location.href='../equipamenots/listar_equipamentos.php';</script>";
        } else {
            echo "<script>alert('Erro ao adicionar equipamento: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Todos os campos são obrigatórios!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Equipamento</title>
    <link rel="stylesheet" href="../css/eee.css">
    <link rel="icon" href="../img/ASN02.png">   
</head>
<body>
    <h2>Adicionar Novo Equipamento</h2>
    <form method="POST">
       <strong> <h3><label>Nome do Equipamento:</label></h3></strong>
        <input type="text" name="nome" required><br>

        <strong> <h3><label>Descrição:</label></h3></strong>
        <textarea name="descricao" required></textarea><br>

        <button type="submit" class="botao">Adicionar Equipamento</button>
    </form>

    <br>
    <a href="../admin/admin_painel.php"><button class="butao">Voltar ao Painel</button></a>
</body>
</html>
