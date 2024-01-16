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


