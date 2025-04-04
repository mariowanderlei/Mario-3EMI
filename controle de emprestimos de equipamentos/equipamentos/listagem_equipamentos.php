<?php
session_start();
include '../processos/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

// Consulta as solicitações de equipamentos feitas pelos professores
$query = "SELECT * FROM solicitacoes";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações de Equipamentos</title>
    <link rel="stylesheet" href="../css/eee.css">
    <link rel="icon" href="../img/ASN02.png">   
</head>
<body>
    <h1>Solicitações de Equipamentos</h1>
    <table border="10">
        <tr>
            <th>Professor</th>
            <th>Equipamento</th>
            <th>Data</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['professor']; ?></td>
            <td><?php echo $row['equipamento']; ?></td>
            <td><?php echo $row['data']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <a href="aprovar_solicitacao.php?id=<?php echo $row['id']; ?>"><button class="botao">Aprovar</button></a>
                <a href="rejeitar_solicitacao.php?id=<?php echo $row['id']; ?>"><button class="botao botao-vermelho">Rejeitar</button></a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br>
    <a href="../admin/admin_painel.php"><button class="botao">Voltar ao Painel</button></a>
</body>
</html>
