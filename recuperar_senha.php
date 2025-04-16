<?php
session_start();
$_SESSION['_csrf'] = (isset($_SESSION['_csrf'])) ? $_SESSION['_csrf'] : hash('sha256', random_bytes(32));
$_SESSION["etapa"] = isset($_SESSION["etapa"]) ? $_SESSION["etapa"] : 1;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=account_circle" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/recuperar_senha.css">
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/png">
    <link rel="stylesheet" href="#">
    <title>TaskMaker | Recuperar Senha</title>
</head>

<body>
    <?php switch ($_SESSION["etapa"]):
        case 1: ?>
            <form action="auth/recuperar_senha.php" method="post">
                <p>Formulário de recuperação de senha</p>
                <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">
                <input type="hidden" name="etapa" value="1">

                <div class="form-group">
                    <label for="email">Digite seu e-mail</label>
                    <input type="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                </div>

                <button type="submit">Enviar</button>
            </form>
            <?php break; ?>
        <?php
        case 2: ?>
            <form action="auth/recuperar_senha.php" method="post">
                <p>Formulário de recuperação de senha</p>
                <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">
                <input type="hidden" name="etapa" value="2">

                <p>Um código foi enviado para seu e-mail</p>
                <div class="form-group">
                    <label for="codigo">Digite o código</label>
                    <input type="text" name="codigo" id="codigo" pattern="\d{6}" inputmode="numeric" maxlength="6" required>
                </div>
                <button type="submit">Enviar</button>
            </form>
            <?php break; ?>
        <?php
        case 3: ?>
            <form action="auth/recuperar_senha.php" method="post" id="form-redefinir">
                <p>Formulário de recuperação de senha</p>
                <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">
                <input type="hidden" name="etapa" value="3">

                <div class="form-group">
                    <label for="senha">Digite sua nova senha</label>
                    <input type="password" name="senha" id="senha" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$"
                        title="A senha deve ter no mínimo 8 caracteres, incluindo letras e números" required>
                </div>

                <div class="form-group">
                    <label for="confirmarsenha">Digite a senha novamente</label>
                    <input type="password" name="confirmarsenha" id="confirmarsenha">
                </div>

                <button type="submit">Trocar senha</button>
            </form>
            <?php break; ?>
    <?php endswitch; ?>

    <?php include("include/response_message.php"); ?>
    <script src="assets/js/validacoes.js"></script>
</body>

</html>