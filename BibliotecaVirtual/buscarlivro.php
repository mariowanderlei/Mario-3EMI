<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_de_livro";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Inicializa a variável de pesquisa
$pesquisa = isset($_POST['pesquisar']) ? $_POST['pesquisar'] : '';

// A consulta SQL que vai buscar os livros por título ou ISBN
$query = "SELECT * FROM Cadastrolivro WHERE Titulo LIKE ? OR ISBN LIKE ?";

// Prepara a consulta
$stmt = $conn->prepare($query);
$termo = '%' . $pesquisa . '%'; // Utiliza o % para pesquisa parcial (LIKE)
$stmt->bind_param("ss", $termo, $termo); // Parametriza a consulta
$stmt->execute();

// Obtém os resultados da consulta
$result = $stmt->get_result();
?>

<!-- Barra de pesquisa -->
<div class="search-bar">
    <form action="" method="POST">
        <input type="text" name="pesquisar" class="botao" value="<?= htmlspecialchars($pesquisa) ?>" placeholder="Buscar Livro por ISBN ou Título">
        <link rel="stylesheet" href="estilos.css">
        <link rel="icon" href="img/ASN02.png">
        <button class="btn" type="submit">
            <i class="fas fa-search">🔍</i> <!-- Ícone da lupa -->
        </button>
    </form>
</div>

<div class="container1">
    <?php
    if ($result->num_rows > 0): 
        while ($livro = $result->fetch_assoc()): ?>
            <div class="game">
                <img src="<?= htmlspecialchars($livro['Imagem']) ?>" alt="Imagem do Livro" width="100" height="150">
                <h2 class="animated-text"><?= htmlspecialchars($livro['Titulo']) ?></h2>
                <p class="animated-text"><strong>Autor:</strong> <?= htmlspecialchars($livro['Autor']) ?></p>
                <p class="animated-text"><strong>Editora:</strong> <?= htmlspecialchars($livro['editora']) ?></p>
                <p class="animated-text"><strong>ISBN:</strong> <?= htmlspecialchars($livro['ISBN']) ?></p>
                <p class="animated-text"><strong>Data de Lançamento:</strong> <?= htmlspecialchars($livro['Data_lançamento']) ?></p>
            </div>
    <?php 
        endwhile;
    else: 
        echo "<p>Nenhum livro encontrado com os critérios de busca.</p>";  // Caso não haja resultados
    endif; 
    ?>
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
