function carregarMensagem() {
    var requisicaoAJAX = new XMLHttpRequest();

    requisicaoAJAX.onreadystatechange = function() {
        if (requisicaoAJAX.readyState === 4 && requisicaoAJAX.status === 200) {        
           document.getElementById("mensagem").innerText = requisicaoAJAX.responseText;
        }
    };
    
    requisicaoAJAX.open("GET", "mensagem.txt", true);
    requisicaoAJAX.send();
}