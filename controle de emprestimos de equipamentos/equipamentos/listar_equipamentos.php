<?php
include '../processos/db.php';

// Simulação de login (troque pelo sistema real)
$professor_logado = 'Professor Exemplo';
$admin_email = 'admin@example.com'; // Substitua pelo e-mail do administrador

// Buscar equipamentos disponíveis
$sql = "SELECT * FROM equipamentos WHERE status = 'Disponível'";
$result = $conn->query($sql);

// Inserir solicitação no banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['equipamento_id'], $_POST['data_emprestimo'], $_POST['data_devolucao'])) {
        // Solicitação de empréstimo
        $equipamento_id = $_POST['equipamento_id'];
        $data_emprestimo = $_POST['data_emprestimo'];
        $data_devolucao = $_POST['data_devolucao'];
        $descricao = $_POST['descricao'];

        // Buscar nome do equipamento
        $sqlEquip = "SELECT nome FROM equipamentos WHERE id = ?";
        $stmt = $conn->prepare($sqlEquip);
        $stmt->bind_param("i", $equipamento_id);
        $stmt->execute();
        $resultEquip = $stmt->get_result();
        $equipamento = $resultEquip->fetch_assoc()['nome'];

        // Inserir na tabela de solicitações
        $sqlInsert = "INSERT INTO solicitacoes (professor, equipamento, data, data_devolucao, status) VALUES (?, ?, ?, ?, 'Pendente')";
        $stmt = $conn->prepare($sqlInsert);
        $stmt->bind_param("siss", $professor_logado, $equipamento_id, $data_emprestimo, $data_devolucao);
        
        if ($stmt->execute()) {
            // Atualizar o status do equipamento para "Indisponível"
            $sqlUpdate = "UPDATE equipamentos SET status = 'Indisponível' WHERE id = ?";
            $stmt = $conn->prepare($sqlUpdate);
            $stmt->bind_param("i", $equipamento_id);
            $stmt->execute();

            echo "<script>alert('Solicitação enviada!'); window.location.href='../emprestimos/minhas_solicitacoes.php';</script>";
        } else {
            echo "<script>alert('Erro ao enviar solicitação');</script>";
        }
    } elseif (isset($_POST['devolver_id'])) {
        // Processo de devolução do equipamento
        $devolver_id = $_POST['devolver_id'];

        // Atualizar o status do equipamento para "Disponível"
        $sqlUpdate = "UPDATE equipamentos SET status = 'Disponível' WHERE id = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("i", $devolver_id);

        if ($stmt->execute()) {
            // Atualizar a solicitação para "Devolvido"
            $sqlUpdateSolicitacao = "UPDATE solicitacoes SET status = 'Devolvido' WHERE equipamento = ? AND professor = ?";
            $stmt = $conn->prepare($sqlUpdateSolicitacao);
            $stmt->bind_param("is", $devolver_id, $professor_logado);
            $stmt->execute();

            // Enviar e-mail para o administrador
            $assunto = "Equipamento Devolvido";
            $mensagem = "O professor $professor_logado devolveu o equipamento de ID: $devolver_id.";
            $cabecalho = "From: sistema@exemplo.com\r\n";
            mail($admin_email, $assunto, $mensagem, $cabecalho);
        } else {
           
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Empréstimo de Dispositivos</title>
    <link rel="stylesheet" href="../css/listas.css">
    <link rel="icon" href="../img/ASN02.png">   
</head>
<body>
    <form clas="sla">
    <h2>Lista de Dispositivos Disponíveis</h2>
    <table class="container1" border="10">
        <tr>
            <th>Nome</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="equipamento_id" value="<?php echo $row['id']; ?>">
                        <label>Data Empréstimo:</label>
                        <input type="date" name="data_emprestimo" required>
                        <label>Data Devolução:</label>
                        <input type="date" name="data_devolucao" required>
                        <button class="botao" type="submit">Solicitar Empréstimo</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </form>
</table>
<a href="../usuarios/index.php"><button class="butao">Voltar</button></a>
</body>
</html>
