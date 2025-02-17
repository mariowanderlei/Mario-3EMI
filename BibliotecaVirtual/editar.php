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

// Inicializa variáveis
$id_livro = $_GET['id'] ?? null;
$livro = null;

// Buscando todos os livros
$result = $conn->query("SELECT * FROM Cadastrolivro");

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
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Livros</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="icon" href="img/ASN02.png">
</head>
<body>



<!-- Barra de pesquisa -->
<div class="search-bar">
    <form action="buscarlivro.php" method="POST">
        <input type="text" name="pesquisar" class="botao" value="<?= htmlspecialchars($pesquisa) ?>" placeholder="Buscar Livro por ISBN ou Título">
        <button class="btn" type="submit">
            <i class="fas fa-search">🔍</i> 
        </button>
    </form>
</div>


<div class="container1"> 
    <?php while ($livro = $result->fetch_assoc()): ?>
    <div class="game">
        <img src="<?= htmlspecialchars($livro['Imagem']) ?>" alt="Imagem do Livro" width="100" height="150">
        <h2 class="animated-text"><?= htmlspecialchars($livro['Titulo']) ?></h2>
        <p class="animated-text"><strong>Autor:</strong> <?= htmlspecialchars($livro['Autor']) ?></p>
        <p class="animated-text"><strong>Editora:</strong> <?= htmlspecialchars($livro['editora']) ?></p>
        <p class="animated-text"><strong>ISBN:</strong> <?= htmlspecialchars($livro['ISBN']) ?></p>
        <p class="animated-text"><strong>Data de Lançamento:</strong> <?= htmlspecialchars($livro['Data_lançamento']) ?></p>
        <a href="editar_livro.php?id=<?= htmlspecialchars($livro['ISBN']) ?>">Editar</a>


    </div>
    <?php endwhile; ?>  
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



