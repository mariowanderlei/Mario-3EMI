# Mario-3EMI
"Pasta do 3°EMI. [Ano -> 2025]"

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Livro</title>
    <link rel="stylesheet" href="estilinho.css">
    <link rel="icon" href="img/ASN02.png">
</head>
<body>
<div class="container">
    <h2>Cadastro De Livros</h2>
    <form id="bookForm" action="cadastrolivro.php" method="post" onsubmit="return validateInput(event);">
        <strong><label for="Titulo">Título:</label></strong>
        <input type="text" id="Titulo" name="Titulo" placeholder="Insira o Titulo do livro" maxlength="100"pattern="[a-zA-Z0-9\s]+$" title="O título não pode conter caracteres especiais" required>

        <strong><label for="ISBN">ISBN:</label></strong>
        <input type="number" id="ISBN" name="ISBN" placeholder="Insira um ISBN único."title="O número da ISBN já existe, tente outro número!" pattern="^(978|979)?\d{9}(\d|)?$" required>

        <strong><label for="Categoria">Categoria:</label></strong>
        <input type="text" id="Categoria" name="Categoria" placeholder="Insira o gênero ou categoria literária" maxlength="250"pattern="[a-zA-Z\s]+$" title="A Categoria não pode conter caracteres especiais e números" required>

        <strong><label for="Autor">Autor do Livro:</label></strong>
        <input type="text" id="Autor" name="Autor" placeholder="Insira o nome do Autor" maxlength="100"pattern="[a-zA-Z\s]+$" title="O nome do Autor não pode conter caracteres especiais" required>

        <strong><label for="Editora">Editora:</label></strong>
        <input type="text" id="Editora" name="Editora" placeholder="Insira o nome da editora" maxlength="100"pattern="[a-zA-Z\s]+$" title="O nome da editora não pode conter caracteres especiais" required>

        <strong><label for="imagem.">Imagem:</label></strong>
        <input type="file" name="arquivo_img" class="bnt bnt-success" required title="Insira uma imagem refente ao seu livro" accept="image/png, image/jpeg" multiple />

        <strong><label for="Data_lançamento">Data de Publicação:</label></strong>
        <input type="date" id="Data_lançamento" name="Data_lançamento" required>

        <br><br>

        <button class="botao" id="button" type="submit">Cadastrar livro</button>
        
        <br><br>
        <button class="botaum" onclick="window.location.href='index.php';">Voltar para a Página Inicial</button>
    </form>  
</div>
<script src="script.js"></script>
</body>
</html>

