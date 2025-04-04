<?php
session_start(); // Inicia a sessão
include '../processos/db.php';

// Teste se a sessão está funcionando
if (!isset($_SESSION['usuario_id'])) {
    die("Erro: A sessão não foi encontrada. Faça login novamente.");
} else {
    echo "Sessão ativa! Usuário ID: " . $_SESSION['usuario_id'];
}
// Verifica se o usuário está logado corretamente
if (empty($_SESSION['usuario_id'])) {
    echo "<script>alert('Você precisa estar logado para acessar esta página!'); window.location.href='../usuarios/index.php';</script>";
    exit();
}

// Busca equipamentos disponíveis e emprestados
$sql_disponiveis = "SELECT * FROM equipamentos WHERE status = 'disponível'";
$sql_emprestados = "SELECT e.id, eq.nome, p.nome AS professor, e.data_retirada, e.data_prevista_devolucao 
                    FROM emprestimos e
                    JOIN equipamentos eq ON e.equipamento_id = eq.id
                    JOIN professores p ON e.professor_id = p.id
                    WHERE e.status = 'aprovado'";

$result_disponiveis = $conn->query($sql_disponiveis);
$result_emprestados = $conn->query($sql_emprestados);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipamentos Disponíveis</title>
    <link rel="stylesheet" href="../css/aaaa.css">
    <link rel="icon" href="../img/ASN02.png">   
</head>
<body>

<h2>Equipamentos Disponíveis</h2>
<table border="10">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Status</th>
    </tr>
    <?php while ($row = $result_disponiveis->fetch_assoc()) : ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= htmlspecialchars($row['nome']); ?></td>
            <td>Disponível</td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Equipamentos Emprestados</h2>
<table border="10">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Emprestado para</th>
        <th>Data Retirada</th>
        <th>Data Prevista Devolução</th>
    </tr>
    <?php while ($row = $result_emprestados->fetch_assoc()) : ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= htmlspecialchars($row['nome']); ?></td>
            <td><?= htmlspecialchars($row['professor']); ?></td>
            <td><?= $row['data_retirada']; ?></td>
            <td><?= $row['data_prevista_devolucao']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<br>
<button onclick="window.location.href='../usurios/index.php';">Voltar</button>

</body>
</html>
