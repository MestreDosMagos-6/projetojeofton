<?php
    include_once('conexao.php');

    $id = $_GET['id'] ?? null;

    if ($id) {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if($stmt->execute()){
             header('Location: sistema.php');
        } else {
             die("Erro ao excluir: " . $conexao->error);
        }
    }
?>