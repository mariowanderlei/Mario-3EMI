<?php
include '../processos/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (isset($_POST['cadastrar'])) {
        // Cadastro de Professor
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Verificar se o email já está cadastrado
        $stmt = $conn->prepare("SELECT id FROM professores WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Este email já está cadastrado!'); window.location.href='../usuarios/acesso.php';</script>";
            exit();
        }
        $stmt->close();

        // Inserir no banco de dados
        $stmt = $conn->prepare("INSERT INTO professores (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senha_hash);

        if ($stmt->execute()) {
            echo "<script>alert('Cadastro realizado com sucesso! Faça login.'); window.location.href='../usuarios/acesso.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar!'); window.location.href='../usuarios/acesso.php';</script>";
        }

        $stmt->close();
    }

    if (isset($_POST['login'])) {
        // Login do Professor
        $stmt = $conn->prepare("SELECT id, senha FROM professores WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $senha_db);
            $stmt->fetch();

            if (password_verify($senha, $senha_db)) {
                $_SESSION['usuario'] = $id;
                header("Location: ../usuarios/index.php");
                exit();
            } else {
                echo "<script>alert('Senha incorreta!'); window.location.href='../usuarios/acesso.php';</script>";
            }
        } else {
            echo "<script>alert('Usuário não encontrado!'); window.location.href='../usuarios/acesso.php';</script>";
        }

        $stmt->close();
    }
}
?>
