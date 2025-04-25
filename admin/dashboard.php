<?php
include("../auth/validar_sessao.php");
require_once("../database/utils/conexao.php");
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
    <title>TaskMaker | Dashboard</title>
</head>

<body>
    <header>
        <div class="interface">
            <div class="logo">
                <img src="../assets/images/img-logo.png" alt="Imagem da Logo do site">
            </div>
            <nav class="links">
                <a href="entrar.php">Entrar</a>
                <a href="cadastrar.php" class="btn-cadastro">Cadastrar-se</a>
            </nav>
        </div>
    </header>
    <div class="container-lg">
        <p>Tarefas não iniciadas</p>
        <a href="?criar=1&status=1"><i class="fa-solid fa-plus"></i></a>
        <?php
        // Preparar a consulta
        $stmt = $conexao->prepare("SELECT id, titulo, descricao, data_criacao FROM tarefas WHERE status = 1");
        $stmt->execute();

        // Obter resultado
        $resultado = $stmt->get_result();

        // Percorrer todas as linhas com foreach
        while ($tarefa = $resultado->fetch_assoc()) {
            $id = htmlspecialchars($tarefa["id"]);
            $titulo = htmlspecialchars($tarefa["titulo"]);
            $descricao = htmlspecialchars($tarefa["descricao"]);
            $data_criacao = htmlspecialchars($tarefa["data_criacao"]);
            echo "
                <div class='tarefa'>
                    <div class='conteudo'>
                        <p>{$titulo}</p>
                        <p>{$descricao}</p>
                        <p>{$data_criacao}</p>
                    </div>
                    <div class='opcoes'>
                        <a href='?id={$id}&editar=1'><i class='fa-solid fa-pencil'></i></a>
                        <a href='../database/processar_tarefa.php?id={$id}&deletar=1'><i class='fa-solid fa-x'></i></a>
                    </div>
                </div>";
        }
        ?>
    </div>
    <div class="emprogresso">
        <p>Tarefas em progresso</p>
        <a href="?criar=1&status=2"><i class="fa-solid fa-plus"></i></a>
        <?php
        // Preparar a consulta
        $stmt = $conexao->prepare("SELECT id, titulo, descricao, data_criacao FROM tarefas WHERE status = 2");
        $stmt->execute();

        // Obter resultado
        $resultado = $stmt->get_result();

        // Percorrer todas as linhas com foreach
        while ($tarefa = $resultado->fetch_assoc()) {
            $id = htmlspecialchars($tarefa["id"]);
            $titulo = htmlspecialchars($tarefa["titulo"]);
            $descricao = htmlspecialchars($tarefa["descricao"]);
            $data_criacao = htmlspecialchars($tarefa["data_criacao"]);
            echo "
                <div class='tarefa'>
                    <div class='conteudo'>
                        <p>{$titulo}</p>
                        <p>{$descricao}</p>
                        <p>{$data_criacao}</p>
                    </div>
                    <div class='opcoes'>
                        <a href='?id={$id}&editar=1'><i class='fa-solid fa-pencil'></i></a>
                        <a href='../database/processar_tarefa.php?id={$id}&deletar=1'><i class='fa-solid fa-x'></i></a>
                    </div>
                </div>";
        }
        ?>
    </div>
    <div class="concluido">
        <p>Tarefas concluídas</p>
        <a href="?criar=1&status=3"><i class="fa-solid fa-plus"></i></a>
        <?php
        // Preparar a consulta
        $stmt = $conexao->prepare("SELECT id, titulo, descricao, data_criacao FROM tarefas WHERE status = 3");
        $stmt->execute();

        // Obter resultado
        $resultado = $stmt->get_result();

        // Percorrer todas as linhas com foreach
        while ($tarefa = $resultado->fetch_assoc()) {
            $id = htmlspecialchars($tarefa["id"]);
            $titulo = htmlspecialchars($tarefa["titulo"]);
            $descricao = htmlspecialchars($tarefa["descricao"]);
            $data_criacao = htmlspecialchars($tarefa["data_criacao"]);
            echo "
                <div class='tarefa'>
                    <div class='conteudo'>
                        <p>{$titulo}</p>
                        <p>{$descricao}</p>
                        <p>{$data_criacao}</p>
                    </div>
                    <div class='opcoes'>
                        <a href='?id={$id}&editar=1'><i class='fa-solid fa-pencil'></i></a>
                        <a href='../database/processar_tarefa.php?id={$id}&deletar=1'><i class='fa-solid fa-x'></i></a>
                    </div>
                </div>";
        }
        ?>
    </div>
    <?php
    if (isset($_GET["editar"]) && $_GET["editar"] == 1):
        $stmt = $conexao->prepare("SELECT titulo, descricao FROM tarefas WHERE id = ?");
        $stmt->bind_param("s", $_GET["id"]);
        $stmt->execute();
        $stmt->bind_result($titulo, $descricao);
        $stmt->fetch();

        $conexao->close();
        $stmt = null;
    ?>
        <div class="editartarefa">
            <a href='../database/processar_tarefa.php'><i class='fa-solid fa-x'></i></a>
            <form action="../database/processar_tarefa.php" method="get">
                <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
                <input type="hidden" name="editar" value="<?= $_GET["editar"] ?>">
                <label for="titulo">titulo</label>
                <input type="text" name="titulo" id="titulo" value="<?= $titulo ?>">
                <label for="">descricao</label>
                <input type="text" name="descricao" id="descricao" value="<?= $descricao ?>">
                <button type="submit">Salvar</button>
            </form>
        </div>
    <?php endif; ?>

    <?php
    if (isset($_GET["criar"]) && $_GET["criar"] == 1):
        $select = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conexao->prepare($select);
        $stmt->bind_param("s", $_SESSION["email"]);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();

        $conexao->close();
        $stmt = null;
    ?>
        <div class="criartarefa">
            <a href='../database/processar_tarefa.php'><i class='fa-solid fa-x'></i></a>
            <form action="../database/processar_tarefa.php" method="get">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="criar" value="<?= $_GET["criar"] ?>">
                <input type="hidden" name="status" value="<?= $_GET["status"] ?>">
                <label for="titulo">titulo</label>
                <input type="text" name="titulo" id="titulo">
                <label for="descricao">descricao</label>
                <input type="text" name="descricao" id="descricao">
                <button type="submit">Salvar</button>
            </form>
        </div>
    <?php endif; ?>
    <a href="../auth/sair.php">Sair</a>
    <a href="usuario/perfil.php">Perfil</a>
    <?php include("../include/response_message.php"); ?>
</body>

</html>