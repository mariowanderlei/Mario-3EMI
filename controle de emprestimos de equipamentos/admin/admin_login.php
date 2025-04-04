<?php
include '../processos/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM admins WHERE email='$email' AND senha='$senha'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin'] = $email;
        header("Location: ../admin/admin_painel.php");
        exit();
    } else {
        echo "<script>alert('Email ou senha incorretos!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../css/eeee.css">
    <link rel="icon" href="../img/ASN02.png">   
</head>
<body>
    <br><br>
    <br><br>
    <form method="POST">
        <h2>Login do Administrador</h2>
        <input type="email" name="email" placeholder="E-mail" required><br>
        <input type="password" name="senha" placeholder="Senha" required><br>
        <button type="submit" name="admin_login" class="botao">Entrar</button>
    </form>
</body>
</html>
