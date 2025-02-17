<?php
// Recebe os dados do formulário de login
$login = $_POST['login'];
$senha = $_POST['senha'];

// Conexão com o banco de dados
$connect = new mysqli("nome_do_servidor", "nome_de_usuario", "senha", "nome_do_banco_de_dados");

// Verifica a conexão
if ($connect->connect_error) {
    die("Erro de conexão: " . $connect->connect_error);
}

// Verifica se o login e a senha foram fornecidos
if (empty($login) || empty($senha)) {
    echo "Login e senha são obrigatórios!";
    exit();
}

// Verifica se o login existe no banco de dados
$query_select = "SELECT cadastrolivroNome, Senha FROM cadastro WHERE cadastrolivroNome = ?";
$stmt = $connect->prepare($query_select);
$stmt->bind_param("s", $login); // "s" para string
$stmt->execute();
$stmt->store_result();

// Se o login não existir
if ($stmt->num_rows === 0) {
    echo "Login ou senha inválidos.";
    exit();
}

// Obtém os dados do usuário
$stmt->bind_result($db_login, $db_senha);
$stmt->fetch();

// Verifica se a senha fornecida corresponde ao hash armazenado
if (password_verify($senha, $db_senha)) {
    // Login bem-sucedido, redireciona para o dashboard
    echo "Bem-vindo, " . htmlspecialchars($db_login) . "!";
    // Aqui você pode redirecionar para outra página, como a página de dashboard
    // header("Location: dashboard.php");
} else {
    // Senha inválida
    echo "Login ou senha inválidos.";
}

// Fecha a conexão
$stmt->close();
$connect->close();
?>
