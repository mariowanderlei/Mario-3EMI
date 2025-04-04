<?php
include '../processos/db.php';

// Buscar todas as solicitações que estão aguardando devolução
$sql = "SELECT * FROM solicitacoes WHERE status = 'Aguardando Devolução' ORDER BY data DESC";
$result = $conn->query($sql);

// Verificar se há resultados
if (!$result) {
    die("Erro na consulta: " . $conn->error);
}


// Processar devolução
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['acao'], $_POST['estado'])) {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $status = ($_POST['acao'] == 'aceitar') ? 'Devolvido' : 'Problema na Devolução';

    // Atualizar status da solicitação e registrar o estado do equipamento
    $sql = "UPDATE solicitacoes SET status = ?, estado_equipamento = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $status, $estado, $id);
    $stmt->execute();

    

    // Se aceito, tornar o equipamento disponível novamente
    if ($status == 'Devolvido') {
        $sqlEquipamento = "
            UPDATE equipamentos 
            SET status = 'Disponível' 
            WHERE nome = (SELECT equipamento FROM solicitacoes WHERE id = ?)
        ";
        $stmt = $conn->prepare($sqlEquipamento);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    echo "<script>alert('Devolução $status com sucesso!'); window.location.href='../devolucoes/devolucao.php';</script>";
}

// Buscar todas as devoluções pendentes (corrigido)
$sql = "SELECT * FROM solicitacoes WHERE status = 'Aguardando Devolução' ORDER BY data DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <link rel="stylesheet" href="../css/aaaa.css">
    <link rel="icon" href="../img/ASN02.png">   
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Devoluções</title>
</head>
<body>

    <h2>Gerenciar Devoluções</h2>

    <table border="10">
    <tr>
        <th>Professor</th>
        <th>Equipamento</th>
        <th>Data Empréstimo</th>
        <th>Data Devolução</th>
        <th>Status</th>
        <th>Estado do Equipamento</th>
        <th>Ação</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($solicitacao = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($solicitacao['professor']); ?></td>
                <td><?php echo htmlspecialchars($solicitacao['equipamento']); ?></td>
                <td><?php echo date("d/m/Y", strtotime($solicitacao['data'])); ?></td>
                <td><?php echo date("d/m/Y", strtotime($solicitacao['data_devolucao'])); ?></td>
                <td><?php echo htmlspecialchars($solicitacao['status']); ?></td>
                <td>
                    <form method="post" action="processar_devolucao.php">
                        <input type="hidden" name="id" value="<?php echo $solicitacao['id']; ?>">
                        <input type="text" name="estado" placeholder="Ex: Em bom estado, com defeito..." required>
                        <button type="submit" name="acao" value="aceitar">Aceitar</button>
                        <button type="submit" name="acao" value="rejeitar">Rejeitar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="7">Nenhuma devolução pendente encontrada.</td>
        </tr>
    <?php endif; ?>
</table>


</body>
</html>
<a href="../admin/admin_painel.php"><button class="botao">Voltar</button></a>
