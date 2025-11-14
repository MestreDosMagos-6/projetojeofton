<?php

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        header('Location: formulario.php?deleted=true');
        exit;
    } catch(PDOException $e) {
        die("Erro ao excluir usuário: " . $e->getMessage());
    }
} else {
    header('Location: formulario.php');
    exit;
}
?>