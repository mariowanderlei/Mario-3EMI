<?php
// Insere os dados na tabela
$sql = "INSERT INTO livros (titulo, autor, editora, data_lancamento, ISBN, categoria) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $titulo, $autor, $editora, $data_lancamento, $ISBN, $categoria);

if ($stmt->execute()) {
    echo "Livro cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar o livro: " . $conn->error;
}
$conn->set_charset("utf8");

$stmt->close();
$conn->close();
?>