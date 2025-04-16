<?php
session_start();
$_SESSION['_csrf'] = (isset($_SESSION['_csrf'])) ? $_SESSION['_csrf'] : hash('sha256', random_bytes(32));
$_SESSION["etapa"] = (isset($_SESSION["etapa"])) ? $_SESSION["etapa"] : 1;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=account_circle" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/png">
    <link rel="stylesheet" href="#">
    <title>TaskMaker | Recuperar Senha</title>
</head>

<body>
    <?php if ($_SESSION["etapa"] == 1): ?>
        <form action="auth/recuperar_senha.php" method="post">
            <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">
            <input type="hidden" name="etapa" value="1">
            <label for="email">Digite seu e-mail</label>
            <input type="email" name="email" id="email">
            <button type="submit">Enviar</button>
        </form>
    <?php elseif ($_SESSION["etapa"] == 2): ?>
        <form action="auth/recuperar_senha.php" method="post">
            <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">
            <input type="hidden" name="etapa" value="2">
            <p>Um código foi enviado para seu e-mail</p>
            <label for="codigo">Digite o código</label>
            <input type="number" name="codigo" id="codigo">
            <button type="submit">Enviar</button>
        </form>
    <?php elseif ($_SESSION["etapa"] == 3): ?>
        <form action="auth/recuperar_senha.php" method="post">
            <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">
            <input type="hidden" name="etapa" value="3">
            <label for="senha">Digite sua nova senha</label>
            <input type="password" name="senha" id="senha">
            <label for="confirmarsenha">Digite a senha novamente</label>
            <input type="password" name="confirmarsenha" id="confirmarsenha">
            <button type="submit">Trocar senha</button>
        </form>
    <?php endif;
    include("include/response_message.php"); ?>
</body>

</html>