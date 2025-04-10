<?php
include '../processos/db.php';

if (!isset($_SESSION['professor_id'])) {
    echo "<script>alert('Você precisa estar logado!'); window.location.href='../usuarios/login.php';</script>";
    exit();
}

if (isset($_POST['equipamentos']) && !empty($_POST['equipamentos'])) {
    $professor_id = $_SESSION['professor_id'];
    $data_solicitacao = date("Y-m-d");

    foreach ($_POST['equipamentos'] as $equipamento_id) {
        $query = "INSERT INTO emprestimos (professor_id, equipamento_id, data_solicitacao, status)
                  VALUES ('$professor_id', '$equipamento_id', '$data_solicitacao', 'pendente')";
        $conn->query($query);
    }

    echo "<script>alert('Solicitação enviada com sucesso!'); window.location.href='../equipamenots/listar_equipamentos.php';</script>";
} else {
    echo "<script>alert('Nenhum equipamento foi selecionado!'); window.location.href='../equipamenots/listar_equipamentos.php';</script>";
}
?>
