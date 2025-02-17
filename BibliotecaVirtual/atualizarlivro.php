<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_de_livro";

$conn = new mysqli($servername, $username, $password, $dbname);


// Verifica se o ID do livro foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Captura os dados do formulário
    $titulo = $_POST['Titulo'];
    $isbn = $_POST['ISBN'];
    $categoria = $_POST['Categoria'];
    $autor = $_POST['Autor'];
    $editora = $_POST['Editora'];
    $data_lancamento = $_POST['Data_lancamento'];

    // Atualiza os dados do livro no banco de dados
    $sql = "UPDATE livros SET Titulo=?, ISBN=?, Categoria=?, Autor=?, Editora=?, Data_lancamento=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $titulo, $isbn, $categoria, $autor, $editora, $data_lancamento, $id);
    
    if ($stmt->execute()) {
        echo "Livro atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar o livro: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "ID do livro não fornecido.";
}
$conn->close();
?>