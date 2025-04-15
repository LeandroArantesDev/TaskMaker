<?php
session_start();
$_SESSION['_csrf'] = (isset($_SESSION['_csrf'])) ? $_SESSION['_csrf'] : hash('sha256', random_bytes(32));
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/entrar.css">
    <title>TaskMaker | Entrar</title>
</head>

<body>
    <form action="auth/login.php" method="post">
        <p>Formulário de login</p>
        <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" required placeholder="Digite seu email">
        </div>
        <div class="form-group">
            <div class="esqueceusenha">
                <label for="senha">Senha</label>
                <p><a href="recuperar_senha.php">Esqueceu a senha?</a></p>
            </div>
            <input type="password" name="senha" id="senha" required
                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}"
                title="A senha deve ter no mínimo 8 caracteres, com letras maiúsculas, minúsculas, números e símbolos."
                placeholder="Digite sua Senha">
        </div>
        <button type="submit">Entrar</button>
        <nav class="links-group">
            <p>Não possui conta? <a href="cadastrar.php">Cadastrar-se</a></p>
        </nav>
    </form>

    <?php include("include/response_message.php"); ?>
</body>

</html>