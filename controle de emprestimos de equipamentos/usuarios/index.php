<!-- <--! http://localhost/meusite/BibliotecaVirtual/index.php -->

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Biblioteca Virutal</title>
        <link rel="stylesheet" href="../css/stylee.css">
        <link rel="icon" href="../img/ASN02.png">   
    </head>
    
    <body>
        <nav>
            <div class="navbar">
                <div class="logo-container">
                    <a href=""> <img src="../img/ASN02.png" alt="" class="logo"></a>
                
                </div>
                
                <ul>

                    <!-- <strong><li><a href="cadastro.php">Cadastrar Dispositivo</a></li></strong>  -->

                    <strong><li><a href="../equipamentos/listar_equipamentos.php">Agendar Dispositivos</a></li></strong> 
                    
                    <strong><li><a href="../equipamentos/devolver_equipamentos.php">Devolução de dispositivos</a></li></strong> 
                    
                    <strong><li class="divisor" role="separator"> | </li></strong>

                    <strong><li><a href="../usuarios/acesso.php">Voltar</a></li></strong> 

                </ul>
            </div>
        </nav>
        
        <!-- Capa, Textos e Botões -->
        <div class="capa">
            <div class="texto-capa">
                <br><br>
                <br><br>
                <strong><h1>Agendamento<br>Equipamentos Escolares</h1></strong>
                <strong><h2>E.E.E.F.M Antonio Dos Santos Neves</h2></strong>
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
         </script>

                <script src="../js/script.js"></script>  
            </body>
            </html>

            <!-- <strong><li><a href="login.php">Login</a></li></strong> -->

      
