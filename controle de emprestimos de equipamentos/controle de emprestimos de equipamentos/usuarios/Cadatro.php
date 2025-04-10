<?php
include '../processos/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT); // Criptografar a senha

    $sql = "INSERT INTO professores (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='../usuarios/acesso.php';</script>";
    } else {
        echo "Erro: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/eeee.css">
    <link rel="icon" href="../img/ASN02.png">   
</head>
<body>
    <br><br>
    <br><br>
    <br><br>
    
    <form method="POST">
    Nome: <input type="text" name="nome" required><br>
    Email: <input type="email" name="email" required><br>
    Senha: <input type="password" name="senha" required><br>
    <button type="submit">Cadastrar</button>
    <a href="../usuarios/acesso.php">Já tem uma conta? Faça login</a>
</form>
</body>
</html>
