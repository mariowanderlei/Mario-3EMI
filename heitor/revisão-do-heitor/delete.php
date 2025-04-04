<?php include 'conexao.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt =  $conn -> prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt -> execute()) {
        if ($stmt->execute()) {
            echo json_encode(["message" => "Deletado com sucesso!"]);
            } else {
                echo json_encode(["error" => "Erro ao deletar dados!"]);
        }


        $stmt -> close();
        $conn -> close();
    }
}
?>
