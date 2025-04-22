<?php
include("../auth/validacoes.php");

if (isset($_GET["deletar"]) &&  $_GET["deletar"] == 1) {
    $id = trim(strip_tags($_GET["id"]));
    if (removerTarefa($id) == true) {
        $_SESSION['resposta'] = "Tarefa removida com sucesso!";
        header("Location: ../admin/dashboard.php");
        exit;
    } else {
        $_SESSION['resposta'] = "Tarefa não foi removida com sucesso!";
        header("Location: ../admin/dashboard.php");
        exit;
    }
} else if (isset($_GET["editar"]) && $_GET["editar"] == 1) {
    $id = trim(strip_tags($_GET["id"]));
    $titulo = trim(strip_tags($_GET["titulo"]));
    $descricao = trim(strip_tags($_GET["descricao"]));
    if (editarTarefa($id, $titulo, $descricao) == true) {
        $_SESSION['resposta'] = "Tarefa editada com sucesso!";
        header("Location: ../admin/dashboard.php");
        exit;
    } else {
        $_SESSION['resposta'] = "Tarefa não foi editada com sucesso!";
        header("Location: ../admin/dashboard.php");
        exit;
    }
} else if (isset($_GET["criar"]) && $_GET["criar"] == 1) {
    $id = trim(strip_tags($_GET["id"]));
    $status = trim(strip_tags($_GET["status"]));
    $titulo = trim(strip_tags($_GET["titulo"]));
    $descricao = trim(strip_tags($_GET["descricao"]));
    if (criarTarefa($id, $status, $titulo, $descricao) == true) {
        $_SESSION['resposta'] = "Tarefa criada com sucesso!";
        header("Location: ../admin/dashboard.php");
        exit;
    } else {
        $_SESSION['resposta'] = "Tarefa não foi criada com sucesso!";
        header("Location: ../admin/dashboard.php");
        exit;
    }
}
header("Location: ../admin/dashboard.php");
exit;
