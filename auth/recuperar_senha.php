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

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"];

    gerarCodigo($email, "../recuperar_senha.php");
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../recuperar_senha.php");
$conexao->close();
$stmt = null;
exit;
