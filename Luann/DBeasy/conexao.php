<?php

    // conexão com o banco de dados
    $host = 'localhost';
    $usuario = 'root';
    $senha = '';
    $banco = 'exemplo_db';

    // conexão
    $conexao = new mysqli($host, $usuario, $senha, $banco);
    
    // verificar conxão
    if ($conexao->connect_error) {
        die("Conexão falhou: " . $conexao->connect_error);
        }

?>