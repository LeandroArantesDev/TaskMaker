<?php
session_start();
$_SESSION['_csrf'] = (isset($_SESSION['_csrf'])) ? $_SESSION['_csrf'] : hash('sha256', random_bytes(32));
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskMaker | Registre-se</title>
</head>

<body>
    <form action="auth/register.php" method="post">
        <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">

        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" required pattern="[A-Za-zÀ-ÿ\s]{2,}"
            title="Digite um nome válido (apenas letras e espaços)">

        <label for="sobrenome">Sobrenome</label>
        <input type="text" name="sobrenome" id="sobrenome" required pattern="[A-Za-zÀ-ÿ\s]{2,}"
            title="Digite um sobrenome válido (apenas letras e espaços)">

        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" required>

        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" required pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}"
            title="A senha deve ter no mínimo 8 caracteres, com letras maiúsculas, minúsculas, números e símbolos.">

        <label for="confirmarsenha">Confirme a senha</label>
        <input type="password" name="confirmarsenha" id="confirmarsenha" required>

        <button type="submit">Registrar-se</button>
    </form>

    <?php
    if (isset($_SESSION["resposta"])) {
    ?>
    <script>
    window.alert("<?= $_SESSION["resposta"] ?>");
    </script>
    <?php
    }
    ?>


</body>

</html>