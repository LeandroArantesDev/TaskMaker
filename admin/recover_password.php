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
    <div class="formulario-email" id="formulario-email">
        <label for="email">Digite seu e-mail</label>
        <input type="email" name="email" id="email">
        <button type="submit" id="enviar_email">Enviar</button>
    </div>

    <form action="#" method="post">
        <p>Um código foi enviado para seu e-mail</p>
        <label for="codigo">Digite o código</label>
        <input type="number" name="codigo" id="codigo">
        <button type="submit">Enviar</button>
    </form>

    <form action="#">
        <label for="senha">Digite sua nova senha</label>
        <input type="text" name="senha" id="senha">
        <label for="confirmarsenha">Digite a senha novamente</label>
        <input type="text" name="confirmarsenha" id="confirmarsenha">
        <button type="submit">Trocar senha</button>
    </form>


    <script>
        document.getElementById("enviar_email").addEventListener("click", function() {
            let email = document.getElementById("email").value;

            jQuery.ajax({
                url: ''
            });

        });
    </script>

    <?php
    function gerarCodigo($email) {}


    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>