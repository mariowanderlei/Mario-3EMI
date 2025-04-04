<?php
    require_once 'conexao.php';

    $nome = isset($_POST ['nome']) ? trim($_POST['nome']) : '';
    $email = isset($_POST ['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST ['senha']) ? trim($_POST['senha']) : '';

    if ($nome === '' || $email === '' || $senha === '') {
        die("nome, email e senha são obrigatórios");
    }
    
    $stmt = $conn->prepare("inssert into usuarios (nome, email, senha) values (?, ?)");
    $stmt->bind_param("ss", $nome, $email);

    if ($stmt->execute()) {
        echo "usuário criado com sucesso: ";
        } else {
        echo "erro ao criar usuário: " . $stmt->error;
    }


    $stmt->close();
    $conn->close();
?>