<?php
// Conectar ao banco de dados
require "../processos/db.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $senha = $_POST["senha"];
    $hashed_password = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir no banco de dados
    $sql = "INSERT INTO cadastro (Nome, Telefone, Senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $telefone, $hashed_password); 

    if ($stmt->execute()) {
        // Redireciona para a página de login após cadastro bem-sucedido
        header("Location: login.php");
        exit();
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Biblioteca</title>
    <link rel="stylesheet" href="../css/eeee.css">
    <link rel="icon" href="../img/ASN02.png">
</head>
<body>
    <div class="container">
        <h2>Cadastro</h2>
        <form action="teste.php" method="POST">
            <label for="Nome do usuario">Nome do usuário:</label>
            <input type="text" id="Nome do usuario" name="nome" required>

            <label for="telefone_responsavel">Telefone do Responsável:</label>
            <input 
                type="number" 
                id="telefone_responsavel" 
                name="telefone" 
                pattern="[0-9]{10,12}" 
                maxlength="12" 
                required 
                title="Por favor, insira apenas números (10 a 12 dígitos)">
            
            <label for="senha">Senha:</label>
            <input 
                type="password" 
                id="senha" 
                name="senha" 
                required 
                minlength="8" 
                title="A senha deve ter pelo menos 8 caracteres">

            <br><br>
            <button type="submit">Cadastrar</button>
            <br><br>
            <button type="button" onclick="window.location.href='acesso.php';">Voltar para a Página Inicial</button>
            <br><br>
            <p>Já tem conta? <a href="login.php">Faça login aqui</a></p>
        </form>
    </div>
</body>
</html>
