<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/index.css">
    <title>TaskMaker | Bem-vindo</title>
</head>

<body>
    <header>
        <div class="interface">
            <div class="logo">
                <img src="assets/images/img-logo.png" alt="Imagem da Logo do site">
            </div>
            <nav class="links">
                <a href="signin.php">Entrar</a>
                <a href="signup.php" class="btn-cadastro">Cadastrar-se</a>
            </nav>
        </div>
    </header>
    <main>
        <section class="home">
            <div class="interface">
                <div class="conteudo">
                    <h1>Capture, organize e enfrente suas tarefas em qualquer lugar.</h1>
                    <p>Escape da desordem e aumente sua produtividade com Taskmaker.</p>
                    <form action="pages/cadastro.php" method="post">
                        <input type="email" name="email" id="email" placeholder="E-mail">
                        <button type="submit">Cadastre-se - É gratís!</button>
                    </form>
                </div>
                <div class="imagem">
                    <img src="assets/images/img-home.png" alt="">
                </div>
            </div>
        </section>
    </main>
    <footer>
    </footer>
</body>