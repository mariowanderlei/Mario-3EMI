<?php
    include 'conexao.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $idade = $_POST['idade'];

        $stmt = $conn -> prepare("INSERT INTO users (nome, email, idade) VALUE (?, ?, ?)");
        $stmt->bind_Param($nome, $email, $idade);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Dados inseridos com sucesso!"]);
            } else {
                echo json_encode(["error" => "Erro ao inserir dados!"]);
        }


        $stmt -> close();
        $conn -> close();
    }
?>