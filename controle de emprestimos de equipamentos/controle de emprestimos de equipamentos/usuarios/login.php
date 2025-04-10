<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'cadastro_professores';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    // Consultar o banco de dados para verificar as credenciais
    $sql = "SELECT * FROM cadastro WHERE Nome = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nome);  // Corrigido para usar a variável $nome
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se encontrar o usuário
        $user = $result->fetch_assoc();
        
        // Verificar se a senha fornecida corresponde à senha criptografada no banco de dados
        if (password_verify($senha, $user['Senha'])) {
            // Login bem-sucedido, redirecionar para a página de cadastro de livros
            // Armazenar a sessão do usuário para verificar se está logado em outras páginas
            session_start();
            $_SESSION['usuario'] = $nome;  // Salvar o nome do usuário na sessão

            // Redireciona para a página de cadastro de livros
            header('Location: ../usuarios/index.php');
            exit();
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Nome de usuário não encontrado!";
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
    <title>Login - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../img/ASN02.png">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form action="../usuarios/login.php" method="POST">  <!-- Corrigir a action para apontar para o próprio arquivo -->
        <label for="nome">Nome do usuário:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="senha">Senha:</label>
            <input 
                type="password" 
                id="senha" 
                name="senha" 
                required 
                minlength="8" 
                title="A senha deve ter pelo menos 8 caracteres">

        <br><br>
        <br><br>
        <button type="submit">Logar</button>
        <br><br>
        <button type="button" onclick="window.location.href='../usuarios/acesso.php';">Voltar para a Página Inicial</button>

        <br><br>
        <p>Não tem conta? <a href="../processos/teste.php">Faça seu cadastro aqui</a></p>
    </form>
</div>
</body>
</html>
