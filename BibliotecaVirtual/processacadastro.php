<?php
// Inclui a configuração de conexão ao banco de dados
require "config.php"; 

// Lógica de login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Recebe os dados do formulário de login
    $Nome = $_POST['Nome'];
    $Senha = $_POST['Senha'];
    $Telefone_responsável = $_POST['Telefone_responsável'];

    try {
        // Consulta o banco de dados para verificar o usuário
        $sql = "SELECT * FROM cadastro WHERE cadastrolivroNome = :Nome AND Telefone_responsável = :Telefone_responsável";
        $stmt = $pdo->prepare($sql);
        // Usar bindValue
        $stmt->bindValue(':Nome', $Nome, PDO::PARAM_STR);
        $stmt->bindValue(':Telefone_responsável', $Telefone_responsável, PDO::PARAM_STR);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e a senha é válida
        if ($usuario && $Senha === $usuario['Senha']) { // Comparando diretamente as senhas (sem hash)
            // Senha correta, login bem-sucedido
            echo "Bem-vindo, " . htmlspecialchars($usuario['cadastrolivroNome']) . "!";
            // Redireciona para a página de dashboard (exemplo: dashboard.php)
            header("Location: dashboard.php");
            exit();
        } else {
            // Dados incorretos
            echo "Nome, Senha ou telefone inválidos.";
        }
    } catch (PDOException $e) {
        // Trata erros de conexão ou execução de consulta
        echo "Erro ao verificar usuário: " . $e->getMessage();
    }
}

// Lógica de cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastro'])) {
    // Recebe os dados do formulário de cadastro
    $Nome = $_POST['Nome'];
    $Senha = $_POST['Senha'];
    $Telefone_responsável = $_POST['Telefone_responsável'];

    // Verifica se todos os campos foram preenchidos
    if (empty($Nome) || empty($Senha)) {
        echo "Nome e Senha são obrigatórios!";
        exit();
    }

    try {
        // Verifica se o nome ou telefone já existe no banco
        $sql_check = "SELECT * FROM cadastro WHERE cadastrolivroNome = :Nome OR Telefone_responsável = :Telefone_responsável";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindValue(':Nome', $Nome, PDO::PARAM_STR);
        $stmt_check->bindValue(':Telefone_responsável', $Telefone_responsável, PDO::PARAM_STR);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            echo "Nome ou telefone já registrados. Tente novamente com outros dados.";
        } else {
            // Insere os dados no banco de dados (sem criptografar a senha)
            $sql = "INSERT INTO cadastro (cadastrolivroNome, Senha, Telefone_responsável) VALUES (:Nome, :Senha, :Telefone_responsável)";
            $stmt = $pdo->prepare($sql);
            // Usando bindValue corretamente
            $stmt->bindValue(':Nome', $Nome, PDO::PARAM_STR);
            $stmt->bindValue(':Senha', $Senha, PDO::PARAM_STR); // Agora armazenando a senha em texto simples
            $stmt->bindValue(':Telefone_responsável', $Telefone_responsável, PDO::PARAM_STR);

            // Executa a inserção e verifica se foi bem-sucedida
            if ($stmt->execute()) {
                echo "Cadastro realizado com sucesso! Você pode fazer login agora.";
            } else {
                echo "Erro ao cadastrar usuário.";
            }
        }
    } catch (PDOException $e) {
        // Trata erros de inserção no banco
        echo "Erro ao cadastrar usuário: " . $e->getMessage();
    }
}
?>
