<?php
//Inicia ou recupera a sessão anterior
session_start();

// Importando PHPmail
require_once("../src/Exception.php");
require_once("../src/SMTP.php");
require_once("../src/PHPMailer.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Incluindo o conexão para conseguir mexer no banco de dados
require_once("../database/utils/conexao.php");
include("validacoes.php");

// Verificação para ver se está vindo por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verificação do token CSRF
    if (!isset($_POST["_csrf"]) || ($_POST["_csrf"] !== $_SESSION["_csrf"])) {
        $_SESSION['resposta'] = "CSRF Token ínvalido!";
        $_SESSION['_csrf'] = hash('sha256', random_bytes(32));
        header("Location: ../recuperar_senha.php");
        exit;
    }

    $email = isset($_POST["email"]) ? $_POST["email"] : $_SESSION["email_recuperar_senha"];
    $etapa = $_POST["etapa"];

    switch ($etapa) {
        case 1:
            if (gerarCodigo($email) == true) {
                $_SESSION["email_recuperar_senha"] = $email;
                $_SESSION["etapa"] = 2;
                $_SESSION['resposta'] = "Codigo enviado com sucesso";
                header("Location: ../recuperar_senha.php");
                exit;
            } else {
                $_SESSION["etapa"] = 1;
                $_SESSION['resposta'] = "Erro ao gerar o código";
                header("Location: ../recuperar_senha.php");
                exit;
            }
        case 2:
            $codigo = $_POST["codigo"];
            if (validarCodigo($email, $codigo) == true) {
                $_SESSION["etapa"] = 3;
                $_SESSION['resposta'] = "Codigo enviado com sucesso";
                header("Location: ../recuperar_senha.php");
                exit;
            } else {
                $_SESSION["etapa"] = 1;
                $_SESSION['resposta'] = "ERRO";
                header("Location: ../recuperar_senha.php");
                exit;
            }
        case 3:
            $senha = $_POST["senha"];
            $novasenha = $_POST["confirmarsenha"];
            if (trocarSenha($senha, $novasenha, $email)) {
                unset($_SESSION["email_recuperar_senha"]);
                unset($_SESSION["etapa"]);
                $_SESSION['resposta'] = "Senha alterada com sucesso";
                header("Location: ../entrar.php");
                exit;
            }
        default:
            $_SESSION["etapa"] = 1;
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../recuperar_senha.php");
$conexao->close();
$stmt = null;
exit;
