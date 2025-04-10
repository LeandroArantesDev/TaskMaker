<?php
include("../auth/protect.php");
include("../database/utils/conexao.php");
$_SESSION['_csrf'] = (isset($_SESSION['_csrf'])) ? $_SESSION['_csrf'] : hash('sha256', random_bytes(32));

$select = "SELECT email_confirmado FROM usuarios WHERE email = ?";
$stmt = $conexao->prepare($select);
$stmt->bind_param("s", $_SESSION["email"]);
$stmt->execute();
$stmt->bind_result($emailconfirmado);
$stmt->fetch();

$conexao->close();
$stmt = null;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=account_circle" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <title>TaskMaker | Perfil</title>
</head>

<body>
    <header>
        <div class="interface">
            <div class="logo">
                <img src="../assets/images/img-logo.png" alt="Imagem da Logo do site">
            </div>
            <div class="profile">
                <i class="fa-solid fa-circle-user"> </i>
            </div>
            <nav class="profile-menu">
                <a href="../auth/logout.php">Sair</a>
            </nav>
        </div>
    </header>
    <main>
        <form action="#" method="post">
            <p>Editar Perfil</p>
            <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" required pattern="[A-Za-zÀ-ÿ\s]{2,}"
                    title="Digite um nome válido (apenas letras e espaços)" placeholder="Digite seu nome"
                    value="<?= $_SESSION["nome"] ?>">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required placeholder="Digite seu email"
                    value="<?= $_SESSION["email"] ?>">
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
        </form>
        <div>
            <?php if ($emailconfirmado == 0) { ?>
                <span>Email não verificado!</span>
                <form action="../auth/generate_confirmation_code.php" method="post">
                    <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">
                    <button type="submit">Verificar E-mail</button>
                </form>
            <?php } else { ?>
                <span>Email verificado!</span>
            <?php } ?>
        </div>
    </main>
    <?php include("../include/response_message.php"); ?>
</body>

</html>