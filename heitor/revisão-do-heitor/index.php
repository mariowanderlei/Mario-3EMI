<?php 
    include 'conexao.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CRUD</title>

</head>
<body>
    <h1>Gerenciamento de Usuário</h1>
    <form action="create.php" method="POST"></form>
    <form action="">
        <input type="hidden" id="userID">
        <input type="text" id="nome" placeholder="Nome" required>
        <input type="email" id="email" placeholder="Email" required>
        <input type="number" id="idade" placeholder="Idade" required>
        <button type="submit">Salvar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Idade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <?php
            $sql_read = "SELECT * FROM users";
            $result = $conn->query($sql_read);
            
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['nome']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['idade']."</td>";
                echo '<td> class="actions">';
                echo '<button class="edit" onclick="editUser('.$row['id'] . ', \'' . $row['nome'] . '\', \'' .  $row['email'] . '\', ' . $row['idade'] . ')">Editar</button>';
                echo '<button class="delete" onclick="deleteUser('.$row['id'] . ')">Excluir</button';
                echo "</td>";
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>