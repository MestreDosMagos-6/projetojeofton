<?php
session_start();

// Verifica se existe login e senha no POST
if (isset($_POST['username']) && isset($_POST['password'])) {

    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Validação simples (Hardcoded) para esta etapa
    if ($user == 'admin' && $pass == 'admin') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $user;

        header('Location: sistema.php');
    } else {
        // Redireciona de volta em caso de erro
        header('Location: tela-de-login.html');
    }
} else {
    // Acesso direto não permitido
    header('Location: tela-de-login.html');
}
