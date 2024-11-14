<?php
session_start();
require 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];


    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);


    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $erro = "Este email já está registrado!";
    } else {

        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        if ($stmt->execute([$nome, $email, $senha_hash])) {
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] = $email;
            $_SESSION['logged_in'] = true;
            header("Location: index.php");
            exit();
        } else {
            $erro = "Erro ao cadastrar. Tente novamente!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="css/cadastrar.css">
</head>
<body class="fade-in">
<div class="background">
        <div class="polygon" style="top: 5%; left: 10%;"></div>
        <div class="spolygon" style="top: 7%; left: 12%;"></div>
        <div class="polygon" style="top: 15%; left: 40%;"></div>
        <div class="spolygon" style="top: 15%; left: 39%;"></div>
        <div class="polygon" style="top: 40%; left: 30%;"></div>
        <div class="spolygon" style="top: 40%; left: 29%;"></div>
        <div class="polygon" style="top: 35%; left: 55%;"></div>
        <div class="spolygon" style="top: 35%; left: 55%;"></div>
        <div class="polygon" style="top: 45%; left: 70%;"></div>
        <div class="spolygon" style="top: 45%; left: 70%;"></div>
        <div class="polygon" style="top: 55%; left: 85%;"></div>
        <div class="spolygon" style="top: 55%; left: 85%;"></div>
        <div class="polygon" style="top: 15%; left: 80%;"></div>
        <div class="spolygon" style="top: 15%; left: 81%;"></div>
        <div class="polygon" style="top: 75%; left: 50%;"></div>
        <div class="spolygon" style="top: 75%; left: 50%;"></div>
        <div class="polygon" style="top: 85%; left: 15%;"></div>
        <div class="spolygon" style="top: 85%; left: 15%;"></div>
        <div class="polygon" style="top: 90%; left: 70%;"></div>
        <div class="spolygon" style="top: 91%; left: 71%;"></div>
    </div>
    <div class="form-container">
        <h2>Cadastrar-se</h2>
        <?php if (isset($erro)): ?>
            <p style="color: red; text-align: center;"><?php echo $erro; ?></p>
        <?php endif; ?>
        <form method="POST" action="cadastrar.php">
            <input type="text" name="nome" placeholder="Nome completo" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
