<?php
session_start();

// Exibe mensagem de sucesso ou erro
if (isset($_SESSION['mensagem'])) {
    echo $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Remove a mensagem após exibi-la
}

// Conexão com o banco de dados
require "config.php"; 

// Verifica se existe um termo de pesquisa
$pesquisa = '';
if (isset($_GET['pesquisar'])) {
    $pesquisa = $_GET['pesquisar'];
}

// Modifica a consulta para filtrar os resultados com base no nome do livro ou ISBN
$query = "SELECT * FROM Cadastrolivro WHERE Titulo LIKE ? OR ISBN LIKE ?";
$stmt = $conn->prepare($query);
$termo = '%' . $pesquisa . '%';
$stmt->bind_param("ss", $termo, $termo);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o pedido de exclusão foi feito
if (isset($_POST['excluir_id'])) {
    $id_livro = $_POST['excluir_id'];

    // Prepara a query DELETE
    $delete_query = "DELETE FROM Cadastrolivro WHERE ISBN = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("s", $id_livro); // ISBN é um valor do tipo string (não inteiro)

    // Executa a exclusão
    if ($delete_stmt->execute()) {
        $_SESSION['mensagem'] = "Livro excluído com sucesso!";
        header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para a página atual para evitar o envio múltiplo
        exit();
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir o livro.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca de Livros</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="icon" href="img/ASN02.png">
</head>
<body>

<!-- Barra de pesquisa -->
<div class="search-bar">
    <form action="buscarlivro.php" method="POST">
        <input type="text" name="pesquisar" class="botao" value="<?= htmlspecialchars($pesquisa) ?>" placeholder="Buscar por ISBN ou Título">
        <button class="btn" type="submit">
            <i class="fas fa-search">🔍</i> <!-- Ícone da lupa -->
        </button>
    </form>
</div>

<div class="container1"> 
    <?php if ($result->num_rows > 0): ?>
        <?php while ($livro = $result->fetch_assoc()): ?>
        <div class="game">
            <img src="<?= htmlspecialchars($livro['Imagem']) ?>" alt="Imagem do Livro" width="100" height="150">
            <h2 class="animated-text"><?= htmlspecialchars($livro['Titulo']) ?></h2>
            <p class="animated-text"><strong>Autor:</strong> <?= htmlspecialchars($livro['Autor']) ?></p>
            <p class="animated-text"><strong>Editora:</strong> <?= htmlspecialchars($livro['editora']) ?></p>
            <p class="animated-text"><strong>ISBN:</strong> <?= htmlspecialchars($livro['ISBN']) ?></p>
            <p class="animated-text"><strong>Data de Lançamento:</strong> <?= htmlspecialchars($livro['Data_lançamento']) ?></p>

           <!-- Formulário de Exclusão -->
<form action="" method="POST" onsubmit="return confirm('Você tem certeza que deseja excluir este livro?');">
    <input type="hidden" name="excluir_id" value="<?= htmlspecialchars($livro['ISBN']) ?>">
    <button type="submit" class="btn-link">Excluir</button>
</form>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="animated-text">Nenhum livro encontrado com os critérios de busca.</p>
    <?php endif; ?>
</div>

<div class="centralizar">
    <button type="button" class="botao" onclick="window.location.href='index.php';">Voltar para a Página Inicial</button>
</div>

<script>
window.addEventListener("load", () => {
    const texts = document.querySelectorAll(".animated-text");
    texts.forEach((text) => {
        text.style.opacity = "1";
        text.style.transform = "translateY(0)";
    });
});
</script>

<script src="script.js"></script>
</body>
</html>
