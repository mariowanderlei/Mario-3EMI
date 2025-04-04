<?php
include 'conexao.php';

$sql = "SELECT c.nome, c.cidade, p.data_pedido, p.valor 
        FROM clientes c 
        JOIN pedidos p ON c.id = p.id_cliente 
        ORDER BY p.data_pedido DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <link rel="stylesheet" href="styles.css">
<head>
    <meta charset="UTF-8">
    <title>Clientes e seus Pedidos</title>
    <style>
        table { border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Clientes e seus Pedidos</h1>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Cliente</th>
                <th>Cidade</th>
                <th>Data do Pedido</th>
                <th>Valor (R$)</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['cidade']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['data_pedido'])); ?></td>
                    <td><?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nenhum pedido encontrado.</p>
    <?php endif; ?>
    
    <a href="index.php" class="btn-voltar">Voltar</a>
    
    <?php mysqli_close($conn); ?>
</body>
</html>