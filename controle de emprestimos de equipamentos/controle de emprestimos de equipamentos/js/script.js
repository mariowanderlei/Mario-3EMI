document.addEventListener('keydown', function(event) {
    // Verifica se a tecla Ctrl está pressionada e uma tecla numérica foi pressionada
    if (event.ctrlKey && (event.key >= '1' && event.key <= '5')) {
        switch (event.key) {
            case '1':
                window.location.href = 'cadastro.php';
                break;
            case '2':
                window.location.href = 'listar_livros.php';
                break;
            case '3':
                window.location.href = 'editar.php';
                break;
            case '4':
                window.location.href = 'excluir.php';
                break;
            case '5':
                window.location.href = 'index.php';
                break;
            default:
                break;
        }
    }
});

