<?php
    session_start();
    // Verifica se está logado
    if((!isset($_SESSION['logged_in']) == true) and (!isset($_SESSION['username']) == true)){
        header('Location: tela-de-login.html');
    }
    $logado = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistema</title>
    <style>
        body { font-family: Arial; background: #eee; padding: 20px; } 
    </style>
</head>
<body>
    <h1>Bem vindo ao Sistema, <?php echo $logado; ?></h1>
    <p>Login efetuado com sucesso.</p>
    <a href="tela-de-login.html">Sair</a>
</body>
</html>