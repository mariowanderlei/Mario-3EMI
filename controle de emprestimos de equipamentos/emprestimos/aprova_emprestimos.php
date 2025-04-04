<?php
session_start();
include '../processos/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

// Busca os empréstimos pendentes
$sql = "SELECT e.id, e.professor, eq.nome AS equipamento, e.data, e.status 
        FROM emprestimos e
        JOIN equipamentos eq ON e.equipamento_id = eq.id
        WHERE e.status = 'pendente'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprovar Empréstimos</title>
    <link rel="stylesheet" href="../css/eee.css">
    <link rel="icon" href="../img/ASN02.png">   
</head>
<body>

    <h2>Solicitações de Empréstimos</h2>

    <table border="10">
        <tr>
            <th>Professor</th>
            <th>Equipamento</th>
            <th>Data</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= htmlspecialchars($row["professor"]); ?></td>
            <td><?= htmlspecialchars($row["equipamento"]); ?></td>
            <td><?= $row["data"]; ?></td>
            <td><?= ucfirst($row["status"]); ?></td>
            <td>
                <form action="processa_aprovacao_admin.php" method="POST">
                    <input type="hidden" name="emprestimo_id" value="<?= $row['id']; ?>">
                    <button type="submit" name="aprovar" class="botao">Aprovar</button>
                    <button type="submit" name="rejeitar" class="botao botao-vermelho">Rejeitar</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="../admin/admin_painel.php"><button class="botao">Voltar ao Painel</button></a>

</body>
</html>
