<?php
include 'conexao.php'; // Inclui o arquivo de conexão

$sql = "SELECT nome, salario FROM funcionarios WHERE salario > 3000 ORDER BY salario DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<link rel="stylesheet" href="styles.css">
<head>
    <meta charset="UTF-8">
    <title>Funcionários com salário > 3000</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Funcionários com salário superior a R$ 3000</h1>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Salário (R$)</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo number_format($row['salario'], 2, ',', '.'); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nenhum funcionário encontrado com salário superior a R$ 3000.</p>
    <?php endif; ?>
    
    <a href="index.php" class="btn-voltar">Voltar</a>
    
    <?php mysqli_close($conn); ?>
</body>
</html>