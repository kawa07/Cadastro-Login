<?php
$pdo = new PDO('mysql:host=localhost;dbname=cadastro;charset=utf8', 'root', '');

// insert.
if(isset($_POST['nome'])) {
    $sql = $pdo->prepare("INSERT INTO usuarios_comuns (nome, dt_nasc, sexo, nome_materno, cpf, telecell, telefixo, cep, login, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $success = $sql->execute(array(
        $_POST['nome'],
        $_POST['dt_nasc'],
        $_POST['sexo'],
        $_POST['nome_materno'],
        $_POST['cpf'],
        $_POST['telecell'],
        $_POST['telefixo'],
        $_POST['cep'],
        $_POST['login'],
        $_POST['senha']
    ));

    if ($success) {
        header('Location: index.php?success=true');
        exit();
    }
}
?>
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





