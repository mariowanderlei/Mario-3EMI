<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/aaaa.css">
    <link rel="icon" href="../img/ASN02.png">   
    <title>Document</title>
</head>
<body>
    


<?php
include '../processos/db.php';

// Simulação de login (troque pelo sistema real)
$professor_logado = 'Professor Exemplo';
$admin_email = 'admin@example.com'; // Substitua pelo e-mail do administrador

// Buscar equipamentos disponíveis
$sql = "SELECT * FROM equipamentos WHERE status = 'Disponível'";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Atualiza o status para "Aguardando Devolução"
    $sql = "UPDATE solicitacoes SET status = 'Aguardando Devolução' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Devolução solicitada com sucesso!'); window.location.href='painel_professor.php';</script>";
    } else {
        echo "<script>alert('Erro ao solicitar devolução.'); window.history.back();</script>";
    }
}



// Inserir solicitação no banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['equipamento_id'], $_POST['data_emprestimo'], $_POST['data_devolucao'])) {
        // Solicitação de empréstimo
        $equipamento_id = $_POST['equipamento_id'];
        $data_emprestimo = $_POST['data_emprestimo'];
        $data_devolucao = $_POST['data_devolucao'];

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

            echo "<script>alert('Equipamento devolvido com sucesso! O administrador foi informado.'); window.location.href='../emprestimos/minhas_solicitacoes.php';</script>";
        } else {
            echo "<script>alert('Erro ao devolver equipamento');</script>";
        }
    }
}
?>

    <h2>Meus Empréstimos</h2>
    <table class="container" border="10">
        <tr>
            <th>Equipamento</th>
            <th>Data Empréstimo</th>
            <th>Data Devolução</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>
        <?php
        $sqlMeusEmprestimos = "SELECT s.id, s.equipamento, e.nome, s.data, s.data_devolucao, s.status 
                               FROM solicitacoes s 
                               JOIN equipamentos e ON s.equipamento = e.id 
                               WHERE s.professor = ? AND s.status IN ('Pendente', 'Aprovado')";
        $stmt = $conn->prepare($sqlMeusEmprestimos);
        $stmt->bind_param("s", $professor_logado);
        $stmt->execute();
        $resultEmprestimos = $stmt->get_result();

        while ($row = $resultEmprestimos->fetch_assoc()):
        ?>
        <tr>
            <td><?php echo $row['nome']; ?></td>
            <td><?php echo $row['data']; ?></td>
            <td><?php echo $row['data_devolucao']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <?php if ($row['status'] == 'Aprovado'): ?>
                    <form method="post">
                        <input type="hidden" name="devolver_id" value="<?php echo $row['equipamento']; ?>">
                        <a href="../devolucoes/solicitar_devolucao.php"><button class="botao">devolver</button></a>
                    </form>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<a href="../usuarios/index.php"><button class="butao">Voltar</button></a>
</body>
</html>
