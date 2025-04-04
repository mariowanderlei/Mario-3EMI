<?php
session_start();
include '../processos/db.php'; // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Proteção contra SQL Injection
    $nome = mysqli_real_escape_string($conn, $nome);
    $email = mysqli_real_escape_string($conn, $email);
    $senha = mysqli_real_escape_string($conn, $senha);

    // Verifica se é cadastro
    if (isset($_POST['cadastrar'])) {
        // Verifica se o e-mail já está cadastrado
        $sql_verifica = "SELECT * FROM professores WHERE email = '$email'";
        $result = mysqli_query($conn, $sql_verifica);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('E-mail já cadastrado!'); window.location.href='acesso.php';</script>";
            exit();
        } else {
            // Criptografa a senha antes de armazenar
            $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

            $sql_insert = "INSERT INTO professores (nome, email, senha) VALUES ('$nome', '$email', '$senha_cripto')";
            if (mysqli_query($conn, $sql_insert)) {
                echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='../usuarios/index.php';</script>";
            } else {
                echo "<script>alert('Erro ao cadastrar usuário.'); window.location.href='../usuarios/acesso.php';</script>";
            }
        }
    }

    // Verifica se é login
    if (isset($_POST['login'])) {
        $sql_login = "SELECT * FROM professores WHERE email = '$email'";
        $result = mysqli_query($conn, $sql_login);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verifica a senha
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['usuario'] = $user['nome'];
                $_SESSION['email'] = $user['email'];

                echo "<script>alert('Login realizado com sucesso!'); window.location.href='../usuarios/index.php';</script>";
                exit();
            } else {
                echo "<script>alert('Senha incorreta!'); window.location.href='../usuarios/acesso.php';</script>";
            }
        } else {
            echo "<script>alert('Usuário não encontrado!'); window.location.href='../usuarios/acesso.php';</script>";
        }
    }
}
?>
