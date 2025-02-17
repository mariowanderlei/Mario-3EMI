<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livro cadastrado</title>
    <link rel="stylesheet" href="estilinho.css">
    <link rel="icon" href="img/ASN02.png">
</head>
<body>

<div class="container">
    
<?php
require "config.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Titulo = $_POST['Titulo']; 
    $ISBN = $_POST['ISBN'];
    $categoria = $_POST['Categoria'];
    $Autor = $_POST['Autor']; 
    $editora = $_POST['Editora'];
    $data_lançamento = $_POST['Data_lançamento']; 
    $img = "img/" . $_POST['arquivo_img'];

    
    // Verificação de dados de entrada
    if (empty($Titulo) || empty($ISBN) || empty($categoria) || empty($Autor) || empty($editora) || empty($data_lançamento)) {
        echo "<h1>Todos os campos são obrigatórios!</h1>";
        exit;
    }

    // Verificar se o ISBN já existe
    $stmt = $conn->prepare("SELECT * FROM cadastrolivro WHERE ISBN = ?");
    $stmt->bind_param("s", $ISBN); // Use "s" para string, se ISBN for um número use "i"
    $stmt->execute();
    $result = $stmt->get_result();

     // Verificação de dados de entrada
     if (empty($Titulo) || empty($ISBN) || empty($categoria) || empty($Autor) || empty($editora) || empty($data_lançamento)) {
        echo "<h1>Todos os campos são obrigatórios!</h1>";
        exit;
    }
          // Validação do ISBN
    if (!preg_match('/^[0-9]{1,13}$/', $ISBN)) {
        echo "<h1>O ISBN deve conter entre 1 e 13 dígitos e deve ser numérico</h1>";

        exit; // Para se certificar que o livro não é cadastrado se a validação falhar
    }
    }

    $stmt = $conn->prepare("INSERT INTO cadastrolivro (Titulo, autor, editora, data_lançamento, ISBN, categoria, imagem) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
        $stmt->bind_param("sssssss", $Titulo, $Autor, $editora, $data_lançamento, $ISBN, $categoria, $img);

        if ($stmt->execute()) {
        echo "<h1>Livro cadastrado com sucesso!</h1>";
        } else {
            echo "Erro: " . $stmt->error;
                }

$stmt->close();
} else {
echo "Erro na preparação da consulta: " . $conn->error;
}


    $conn->close();

?>
<br><br>
<button type="button" class="botao" onclick="window.location.href='index.php';">Voltar para a Página Inicial</button>
</div>

<script src="script.js"></script>
</body>
</html>