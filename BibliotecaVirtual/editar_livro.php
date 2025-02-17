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

// Buscando o livro específico
if ($id_livro) {
    $stmt = $conn->prepare("SELECT * FROM Cadastrolivro WHERE ISBN = ?");
    $stmt->bind_param("s", $id_livro);
    $stmt->execute();
    $result = $stmt->get_result();
    $livro = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualiza o livro
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $editora = $_POST['editora'] ?? '';
    $data_lancamento = $_POST['data_lancamento'] ?? '';

    $stmt = $conn->prepare("UPDATE Cadastrolivro SET titulo=?, autor=?, editora=?, data_lançamento=? WHERE ISBN=?");
    $stmt->bind_param("sssss", $titulo, $autor, $editora, $data_lancamento, $id_livro);

    if ($stmt->execute()) {
        // Redireciona após a atualização
        header("Location: listar_livros.php");
        exit;
    } else {
        echo "Erro ao atualizar o livro: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <link rel="stylesheet" href="estilinho.css">
    <link rel="icon" href="img/ASN02.png">
</head>
<body>
<div class="container">
    <h2>Editar Livro</h2>
    <?php if ($livro): ?>
        <form method="post">
            <strong><label for="titulo">Título:</label></strong>
            <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($livro['Titulo']) ?>"pattern="[a-zA-Z0-9\s]+$" title="O título não pode conter caracteres especiais" required>
            <br>

            <strong><label for="autor">Autor:</label></strong>
            <input type="text" name="autor" id="autor" value="<?= htmlspecialchars($livro['Autor']) ?>"pattern="[a-zA-Z\s]+$" title="O nome do autor não pode conter caracteres especiais e números" required>
            <br>

            <strong><label for="ISBN">ISBN:</label></strong>
            <input type="number" name="ISBN" id="ISBN" value="<?= htmlspecialchars($livro['ISBN']) ?>" required>
            <br>

            <strong><label for="editora">Editora:</label></strong>
            <input type="text" name="editora" id="editora" value="<?= htmlspecialchars($livro['editora']) ?>" pattern="[a-zA-Z\s]+$" title="O nome da editora não pode conter caracteres especiais e números"required>
            <br>

            <strong><label for="data_lancamento">Data lançamento:</label></strong>
<input type="date" name="data_lancamento" id="data_lancamento" value="<?= isset($livro['data_lancamento']) ? htmlspecialchars($livro['data_lancamento']) : '' ?>">
<br>

            
            <button type="submit"> Salvar </button>
            <br> <br>
            <button type="button" class="botao" onclick="window.location.href='index.php';">Voltar para a Página Inicial</button>
        </form>
    <?php else: ?>
        <p>Livro não encontrado.</p>
    <?php endif; ?>
</div>
<script src="script.js"></script>
</body>
</html>

<?php $conn->close(); // Fecha a conexão ?>

