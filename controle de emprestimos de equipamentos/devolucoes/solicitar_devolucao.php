<?php
include '../processos/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['solicitacoes'])) {
    $solicitacoes = $_POST['solicitacoes'];

    $sql = "UPDATE solicitacoes SET status = 'Devolução Solicitada' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $solicitacoes);
    $stmt->execute();

    echo "<script>alert('Devolução feita com sucesso! .'); window.location.href='../emprestimos/minhas_solicitacoes.php';</script>";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['acao'])) {
    if ($_POST['acao'] == 'confirmar_devolucao') {
        $id = $_POST['id'];
        
        // Atualizar a solicitação para devolvida
        $sql = "UPDATE solicitacoes SET status = 'Devolvido' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Tornar o equipamento disponível novamente
        $sqlUpdate = "UPDATE equipamentos SET status = 'Disponível', data_emprestimo = NULL, data_devolucao = NULL WHERE id = (SELECT equipamento_id FROM solicitacoes WHERE id = ?)";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo "<script>alert('Equipamento devolvido com sucesso!'); window.location.href='../admin/admin_painel.php';</script>";
    }
}

?>
