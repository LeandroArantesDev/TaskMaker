<?php
session_start();
$_SESSION['_csrf'] = (isset($_SESSION['_csrf'])) ? $_SESSION['_csrf'] : hash('sha256', random_bytes(32));
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/cadastrar.css">
    <title>TaskMaker | Cadastrar-se</title>
</head>

<body>
    <form action="auth/register.php" method="post">
        <p>Formulário de cadastro</p>
        <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">

        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" required pattern="[A-Za-zÀ-ÿ\s]{2,}"
                title="Digite um nome válido (apenas letras e espaços)" placeholder="Digite seu nome">
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" required placeholder="Digite seu email"
                value="<?= isset($_POST["email"]) ? $_POST["email"] : "" ?>">
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" required
                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}"
                title="A senha deve ter no mínimo 8 caracteres, com letras maiúsculas, minúsculas, números e símbolos."
                placeholder="Digite sua Senha">
        </div>

        <div class="form-group">
            <label for="confirmarsenha">Confirme sua senha</label>
            <input type="password" name="confirmarsenha" id="confirmarsenha" required
                placeholder="Digite a senha novamente">
        </div>
        <button type="submit">Registrar-se</button>
        <nav class="links-group">
            <p>Já possui uma conta?<a href="entrar.php"> Entrar</a></p>
        </nav>
    </form>

    <?php include("include/response_message.php"); ?>
</body>

</html>