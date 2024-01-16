<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=cadastro;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['login']) && isset($_POST['senha'])) {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

   
    $stmt_comum = $pdo->prepare("SELECT * FROM usuarios_comuns WHERE login = ? AND senha = ?");
    $stmt_comum->execute([$login, $senha]);
    $user_comum = $stmt_comum->fetch(PDO::FETCH_ASSOC);

    $stmt_master = $pdo->prepare("SELECT * FROM usuarios_master WHERE login = ? AND senha = ?");
    $stmt_master->execute([$login, $senha]);
    $user_master = $stmt_master->fetch(PDO::FETCH_ASSOC);

    if ($user_comum) {
        // Usuário comum, redirecione para a página 2FA
        $_SESSION['login'] = $user_comum['login'];
        $_SESSION['senha'] = $user_comum['senha'];

        header('Location: tela2fa.php');
        exit;
    } elseif ($user_master) {
        // Usuário mestre, redirecione para a página principal
        $_SESSION['login'] = $user_master['login'];
        $_SESSION['senha'] = $user_master['senha'];

        header('Location: telaprincipal.php');
        exit;
    } else {
        // Login inválido, redirecione para a página de erro
        header('Location: erro3.html');
        exit;
    }
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
.





