<?php
session_start();
include '../processos/db.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $professor_id = $_POST['professor_id'];
    $dispositivo_id = $_POST['dispositivo_id'];
    $data_retirada = $_POST['data_retirada'];
    $data_devolucao = $_POST['data_devolucao'];

    $sql = "INSERT INTO emprestimos (professor_id, dispositivo_id, data_retirada, data_devolucao, status)
            VALUES ('$professor_id', '$dispositivo_id', '$data_retirada', '$data_devolucao', 'pendente')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Solicitação enviada!";
    } else {
        echo "Erro: " . $conn->error;
    }
}

$dispositivo_id = $_GET['id'];
$professores = $conn->query("SELECT * FROM professores");
?>

<!DOCTYPE html>
<html lang="pt">
    <link rel="stylesheet" href="../css/eeee.css">
    <link rel="icon" href="../img/ASN02.png">   
<head>
    <meta charset="UTF-8">
    <title>Solicitar Empréstimo</title>
</head>
<body>
    <h2>Solicitar Empréstimo</h2>
    <form method="POST">
        <input type="hidden" name="dispositivo_id" value="<?php echo $dispositivo_id; ?>">
        
        <label>Professor:</label>
        <select name="professor_id">
            <?php while ($row = $professores->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['nome']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label>Data de Retirada:</label>
        <input type="date" name="data_retirada" required><br>

        <label>Data de Devolução:</label>
        <input type="date" name="data_devolucao" required><br>

        <button type="submit">Solicitar</button>
    </form>
</body>
</html>







<!-- // // Verifica se o usuário está logado
// if (!isset($_SESSION['professores_id'])) { // Corrigido para verificar se o usuário está logado
//     echo "<script>alert('Você precisa estar logado para agendar um equipamento!'); window.location.href='index.php';</script>";
//     exit(); -->


<!-- // Verifica se algum equipamento foi selecionado
// if (!empty($_POST['equipamentos_id'])) {
//     echo "<script>alert('Nenhum equipamento selecionado!'); window.location.href='lista_equipamentos.php';</script>";
//     exit();
// }

// $usuario_id = $_SESSION['professores_id'];
// $equipamentos = $_POST['equipamentos_id'];
// $data_retirada = date('Y-m-d'); // Data de hoje
// $data_prevista_devolucao = date('Y-m-d', strtotime('+7 days')); // 7 dias depois

// foreach ($equipamentos as $equipamento_id) {
//     // Insere um pedido de empréstimo para cada equipamento
//     $sql = "INSERT INTO emprestimos (professores_id, equipamento_id, data_retirada, data_prevista_devolucao, status)
//             VALUES (?, ?, ?, ?, 'pendente')";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("iiss", $usuario_id, $equipamento_id, $data_retirada, $data_prevista_devolucao);
//     $stmt->execute();

//     // Atualiza o status do equipamento para "emprestado"
//     $sql_update = "UPDATE equipamentos_id SET status = 'emprestado' WHERE id = ?";
//     $stmt_update = $conn->prepare($sql_update);
//     $stmt_update->bind_param("i", $equipamento_id);
//     $stmt_update->execute();
// }

// // Redireciona com mensagem de sucesso
// echo "<script>alert('Agendamento realizado com sucesso!'); window.location.href='lista_equipamentos.php';</script>";
// ?> -->
