<?php
include 'conexao.php';

$sql = "SELECT nome, cidade, idade FROM clientes WHERE cidade = 'São Paulo' AND idade > 30 ORDER BY idade DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<link rel="stylesheet" href="styles.css">
<head>
    <meta charset="UTF-8">
    <title>Clientes de SP acima de 30 anos</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Clientes de São Paulo com mais de 30 anos</h1>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Cidade</th>
                <th>Idade</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['cidade']; ?></td>
                    <td><?php echo $row['idade']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nenhum cliente encontrado em São Paulo com mais de 30 anos.</p>
    <?php endif; ?>
    
    <a href="index.php" class="btn-voltar">Voltar</a>
    
    <?php mysqli_close($conn); ?>
</body>
</html>