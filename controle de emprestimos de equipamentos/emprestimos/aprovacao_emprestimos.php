<?php
session_start();
include '../processos/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emprestimo_id'])) {
    $emprestimo_id = $_POST['emprestimo_id'];

    if (isset($_POST['aprovar'])) {
        $sql = "UPDATE emprestimos SET status = 'aprovado' WHERE id = ?";
    } else {
        $sql = "UPDATE emprestimos SET status = 'rejeitado' WHERE id = ?";
        // Se rejeitado, torna o equipamento disponível novamente
        $updateEquipamento = "UPDATE equipamentos SET status='disponível' WHERE id=(SELECT equipamento_id FROM emprestimos WHERE id='$emprestimo_id')";
        mysqli_query($conn, $updateEquipamento);
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $emprestimo_id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Empréstimo atualizado com sucesso!'); window.location.href='../emprestimos/aprova_emprestimo.php';</script>";
}
?>
