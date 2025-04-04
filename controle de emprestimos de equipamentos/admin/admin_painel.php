<?php
include '../processos/db.php';

// Aprovar ou rejeitar solicitação
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['acao'], $_POST['equipamento'])) {
    $id = $_POST['id'];
    $equipamento = $_POST['equipamento'];
    $status = ($_POST['acao'] == 'aprovar') ? 'Aprovado' : 'Rejeitado';

    // Atualizar a solicitação
    $sql = "UPDATE solicitacoes SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    // Se aprovado, atualizar status do equipamento
    if ($status == 'Aprovado') {
        $sqlData = "SELECT data, data_devolucao FROM solicitacoes WHERE id = ?";
        $stmt = $conn->prepare($sqlData);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultData = $stmt->get_result();
        $solicitacao = $resultData->fetch_assoc();

        $sqlUpdate = "UPDATE solicitacoes SET status = 'Indisponível', data_emprestimo = ?, data_devolucao = ? WHERE professor = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("sss", $solicitacao['data'], $solicitacao['data_devolucao'], $equipamento);
        $stmt->execute();
    }

    // Se rejeitado, tornar o equipamento disponível novamente
    if ($status == 'Rejeitado') {
        $sqlUpdate = "UPDATE equipamentos SET status = 'Disponível' WHERE nome = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("s", $equipamento);
        $stmt->execute();
    }
    // Simulação de login (troque pelo sistema real)
$professor_logado = 'Professor ';
$admin_email = 'admin@example.com'; // Substitua pelo e-mail do administrador

// Buscar todas as solicitações que aguardam devolução
$sql = "SELECT * FROM solicitacoes WHERE status = 'Aguardando Devolução' ORDER BY data DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta: " . $conn->error);
}


    echo "<script>alert('Solicitação $status com sucesso!'); window.location.href='../admin/admin_painel.php';</script>";
}

// Buscar todas as solicitações
$sql = "SELECT * FROM solicitacoes ORDER BY data DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="../css/aaaa.css">
    <link rel="icon" href="../img/ASN02.png">   
</head>
<body>

    <h2>Painel do Administrador</h2>

    <table class="container" border="10">
        <tr>
            <th>Professor</th>
            <th>Equipamento</th>
            <th>Data Empréstimo</th>
            <th>Data Devolução</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>
        <?php while ($solicitacoes = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $solicitacoes['professor']; ?></td>
                <td><?php echo $solicitacoes['equipamento']; ?></td>
                <td><?php echo date("d/m/Y", strtotime($solicitacoes['data'])); ?></td>
                <td><?php echo date("d/m/Y", strtotime($solicitacoes['data_devolucao'])); ?></td>
                <td><?php echo $solicitacoes['status']; ?></td>
                <td>
                    <?php if ($solicitacoes['status'] == 'Pendente'): ?>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $solicitacoes['id']; ?>">
                            <input type="hidden" name="equipamento" value="<?php echo $solicitacao['equipamento']; ?>">
                            <button type="submit" name="acao" value="aprovar">Aprovar</button>
                            <button type="submit" name="acao" value="rejeitar">Rejeitar</button>
                        </form>
                    <?php else: ?>
                        (Sem ação)
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>



 <!-- Botão para acessar a página de adição de novos equipamentos -->
 <a href="adicionar_equipamento.php"><button class="butao">Adicionar Novo Equipamento</button></a>
 <br>
 <a href="acesso.php"><button class="butao">Sair</button></a>
 


