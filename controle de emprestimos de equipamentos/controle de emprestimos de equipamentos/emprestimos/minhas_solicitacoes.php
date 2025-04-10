<?php
include '../processos/db.php';

// Simulação do login do professor
$professor_logado = 'Professor Exemplo';

// Buscar solicitações do professor
$sql = "SELECT * FROM solicitacoes WHERE professor = ? ORDER BY data DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $professor_logado);
$stmt->execute();
$solicitacoes = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
    <link rel="stylesheet" href="../css/estilos.css">
<head>
    <meta charset="UTF-8">
    <title>Minhas Solicitações</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .pendente { color: orange; font-weight: bold; }
        .aprovado { color: green; font-weight: bold; }
        .rejeitado { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Minhas Solicitações</h2>

    <table>
        <tr>
            <th>Equipamento</th>
            <th>Data</th>
            <th>Status</th>
        </tr>
        <?php while ($solicitacao = $solicitacoes->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($solicitacao['equipamento']); ?></td>
                <td><?php echo date("d/m/Y", strtotime($solicitacao['data'])); ?></td>
                <td class="<?php echo strtolower($solicitacao['status']); ?>">
                    <?php echo $solicitacao['status']; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
<a href="../usuarios/index.php"><button class="botao">Voltar</button></a>