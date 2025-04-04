<?php
include '../processos/db.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de login do usuário</title>
    <link rel="stylesheet" href="../css/eee.css">
    <link rel="icon" href="../img/ASN02.png">   
</head>

<body>
    
    
  <br><br>
  <br><br>
  <br><br>
            </html> 
            
            
            <?php
include '../processos/db.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Área de login do usuário</title>
        <link rel="stylesheet" href="../css/eeee.css">
        <link rel="icon" href="../img/ASN02.png">   
    </head>
    
    
    <body>


        
        <Formulário para Login e Cadastro -->
            <form action="../processos/processa.php" method="POST">
                <strong><h1 class="texto">Área do Professor</h1></strong>
                <input type="text" name="nome" placeholder="Nome Completo" required> <br>
                
                <input type="email" name="email" placeholder="Email" required> <br>
                
                <input type="password" name="senha" placeholder="Senha" required> <br><br>
                
                <button type="submit" name="login" class="botao">Login</button>
                <br><br>
                <button type="submit" name="cadastrar" class="botao">Cadastrar</button>
                <br><br>
                 
            
       
        
        <div class="capa">
            <?php
session_start();
include '../processos/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);
    
    // Consulta para verificar o professor
    $query = "SELECT * FROM professores WHERE email='$email' AND senha='$senha'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Define a sessão do professor
        $_SESSION['professor'] = $row['nome'];
        
        echo "<script>alert('Login realizado com sucesso!'); window.location.href='../equipamentos/listar_equipamentos.php';</script>";
    } else {
        echo "<script>alert('Email ou senha incorretos!'); window.location.href='../equipamentos/login_professor.php';</script>";
    }
}
?>

    
<!-- Botão para a página de login do administrador -->
<h2>Login Admin</h2>
<a href="../admin/admin_login.php"><button class="butao">Entrar como Admin</button></a>
</form>
</body>
</html>