<?php

    $pokemonData = null;
    $erro = '';

    if(isset($_POST['nome'])) {
        $nome = strtolower(trim($_POST['nome']));
        $url = "https://pokeapi.co/api/v2/pokemon/{$nome}/";
        $response = @file_get_contents($url);
        
        if ($response !== false) {
            $pokemonData = json_decode($response, true);
        } else {
            $erro = 'Erro ao buscar dados do Pokémon';
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pokedex com PHP</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <div class="container">
        <h1>Pokedéx em PHP</h1>
        <form method="post">
            <input type="text" name="nome" placeholder="Digite o nome ou número do Pokémon" required>
            <br>
            <button type="submit">Buscar</button>
        </form>
<?php if($pokemonData): ?>
    <div class="info">
        <h2><?=ucfirst($pokemonData['name']) ?> (#<?= $pokemonData['id']?>)</h2>
        <img src="<?= $pokemonData['sprites']['front_default']?>" alt="spride de <?= $pokemonData['name']?>">
        <strong><p>Tipo: </strong>
        <?php
            foreach ($pokemonData['types'] as $type) {
                echo ucfirst($type['type']['name']) . ' ';
            }
        ?>
        </p>
        <p><strong>Altura: </strong> <?= $pokemonData['height'] / 10 ?> M</p>
        <p><strong>Peso: </strong> <?= $pokemonData['weight'] / 10 ?> Kg</p>
    </div>
        <?php elseif(!empty($erro)): ?>
            <p class="erro"><?= $erro ?></p>
            <?php endif; ?>
    </div>
</body>
</html>