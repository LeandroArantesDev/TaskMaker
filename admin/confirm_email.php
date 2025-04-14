<?php
include("../auth/protect.php");
include("../database/utils/conexao.php");
$_SESSION['_csrf'] = (isset($_SESSION['_csrf'])) ? $_SESSION['_csrf'] : hash('sha256', random_bytes(32));
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskMaker | Confirmar Email</title>
</head>

<body>
    <main>
        <div class="interface">
            <form action="../auth/confirm_email.php" method="post">
                <input type="hidden" name="_csrf" value="<?php echo htmlentities($_SESSION['_csrf']) ?>">
                <h1>Informe o código que enviamos</h1>
                <p>Informe o código enviado no seu email para nos ajudar a proteger sua conta. O
                    código será válido por 10 minutos após o envio.</p>
                <input type="text" name="codigo_confirmacao" id="codigo_confirmacao">
                <button type="submit">Enviar</button>
            </form>
        </div>
    </main>
    <?php include("../include/response_message.php"); ?>
</body>

</html>