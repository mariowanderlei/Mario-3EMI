<?php
session_start();
include '../processos/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "UPDATE emprestimos SET status = 'aprovado' WHERE id = '$id'";
    
    if ($conn->query($query)) {
        echo "<script>alert('Solicitação aprovada!'); window.location.href='../admin/admin_solicitacoes.php';</script>";
    } else {
        echo "<script>alert('Erro ao aprovar!'); window.location.href='../admin/admin_solicitacoes.php';</script>";
    }
}
?>
