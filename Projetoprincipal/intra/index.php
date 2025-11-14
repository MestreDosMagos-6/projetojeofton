<?php
session_start();


if ($_POST) {
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $_POST['username'];
}

// Redirecionar para o menu se estiver logado
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header('Location: ../core/menu.php');
    exit;
} else {
    header('Location: ../core/tela-de-login.html');
    exit;
}
?>