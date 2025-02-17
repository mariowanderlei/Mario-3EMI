<!-- <--! http://localhost/meusite/BibliotecaVirtual/index.php -->

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Biblioteca Virutal</title>
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="img/ASN02.png">   
    </head>
    
    <body>
        <nav>
            <div class="navbar">
                <div class="logo-container">
                    <a href=""> <img src="img/ASN02.png" alt="" class="logo"></a>
                
                </div>
                
                <ul>

                    <strong><li><a href="cadastro.php">Cadastrar</a></li></strong> 
                    
                    <strong><li><a href="listar_livros.php">Livros Cadastrados</a></li></strong> 
                    
                    <strong><li class="divisor" role="separator"> | </li></strong> 
                    
                    <strong><li><a href="editar.php">Editar</a></li></strong> 
                    
                    <strong><li><a href="excluir.php">Excluir</a></li></strong> 

                    <strong><li class="divisor" role="separator"> | </li></strong>

                    <strong><li><a href="acesso.php">Voltar</a></li></strong> 

                </ul>
            </div>
        </nav>
        
        <!-- Capa, Textos e Botões -->
        <div class="capa">
            <div class="texto-capa">
                <br><br>
                <br><br>
                <strong><h1>Biblioteca Virtual - Espanca Ruim</h1></strong>
                </div>
        </div>
        <div id="textoInicio">
        <p class="saida"></p>
        </div>
        <script>
        const saida = document.querySelector(".saida");

        function digitacao(texto, contador) {
            if (contador < texto.length) {
                setTimeout(() => {
                    saida.textContent += texto.charAt(contador);
                    contador++;
                    digitacao(texto, contador);
                }, 20);
            }
        }

        // Chamando a função com o texto a ser "digitado"
        digitacao("Espanca Ruim é um espaço dedicado à disseminação de saberes, à exploração crítica e à construção de diálogos que desafiam convenções. Nossa proposta é oferecer um acervo diversificado, com obras que abordam temas profundos e provocativos, estimulando a reflexão e o pensamento crítico sobre as diversas complexidades do mundo contemporâneo. Aqui, cada obra é uma oportunidade de transformação, um convite à desconstrução de velhos paradigmas e à construção de novos entendimentos. Acreditamos que o conhecimento, quando compartilhado e questionado, tem o poder de expandir horizontes e de transformar realidades. Explore, desafie-se e descubra novos caminhos para o pensamento.", 0);
         </script>

                <script src="script.js"></script>  
            </body>
            </html>

            <!-- <strong><li><a href="login.php">Login</a></li></strong> -->