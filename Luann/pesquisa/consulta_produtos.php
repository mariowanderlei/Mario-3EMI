<?php
include 'conexao.php';

$sql = "SELECT nome, estoque FROM produtos WHERE estoque < 10 ORDER BY estoque ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<link rel="stylesheet" href="styles.css">
<head>
    <meta charset="UTF-8">
    <title>Produtos com estoque < 10</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Produtos com estoque inferior a 10 unidades</h1>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Produto</th>
                <th>Estoque</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['estoque']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Todos os produtos têm estoque suficiente (10 ou mais unidades).</p>
    <?php endif; ?>
    
    <a href="index.php" class="btn-voltar">Voltar</a>
    
    <?php mysqli_close($conn); ?>
</body>
</html>