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

// Verificação para conferir se o método do formulário é POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verificação do token CSRF
    if (!isset($_POST["_csrf"]) || ($_POST["_csrf"] !== $_SESSION["_csrf"])) {
        $_SESSION['resposta'] = "CSRF Token ínvalido!";
        $_SESSION['_csrf'] = hash('sha256', random_bytes(32));
        header("Location: ../signin.php");
        exit;
    }

    // código de 6 dígitos
    $codigo_confirmacao_email = rand(100000, 999999);
    $email = $_SESSION["email"];

    // Verificar se contém apenas números
    if (preg_match('/^\d+$/', $codigo_confirmacao_email)) {

        // Criando objeto para trabalhar com o PHPMailer
        $mail = new PHPMailer(true);

        // Usando try e catch para capturar os erros possiveis

        try {
            // Habilitar o modo debug
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            // Habilitar o SMTP
            $mail->isSMTP(true);
            // Configurar o Host
            $mail->Host = 'smtp.gmail.com';
            // Falar para a biblioteca que eu vou trabalhar com SMTP Ativo
            $mail->SMTPAuth = true;
            // Configurar email que vai mandar a mensagem
            $mail->Username = "taskmaker.suporte@gmail.com";
            // Configurar Senha???
            $mail->Password = "oxxi luqu mlsg buej";
            // Configurar Porta que o gmail usa
            $mail->Port = "587";

            // Parte de configurar servidor configurada, agora é a mensagem
            // Coloco o email que vai mandar
            $mail->setFrom("taskmaker.suporte@gmail.com");
            // Email que vai receber
            $mail->addAddress($email);
            // Habilitar html
            $mail->isHTML(true);
            // Adcionar Assunto
            $mail->Subject = "Assunto";
            // Adicionar corpo com hmtl ativo
            $mail->Body = "O seu código de acesso é <strong>{$codigo_confirmacao_email}</strong>";
            // Adcionar uma versão alternativa para algum cliente que não lê html
            $mail->AltBody = "O seu código de acesso é {$codigo_confirmacao_email}";
        } catch (Exception $e) {
            $_SESSION['resposta'] = "Erro ao enviar mensagem: {$mail->ErrorInfo}";
            header("Location: ../admin/profile.php");
            exit;
        }


        $update = "UPDATE usuarios SET codigo_confirmacao = ? WHERE email = ?";
        $stmt = $conexao->prepare($update);
        $stmt->bind_param("ss", $codigo_confirmacao_email, $email);

        // Se funcionar a inserção no banco ele retorna para a tela do profile falando que funcionou, se não ele retornaerro
        if ($stmt->execute() and $mail->send()) {
            $_SESSION['resposta'] = "Código enviado para o email";
            header("Location: ../admin/confirm_email.php");
            exit;
        } else {
            $_SESSION['resposta'] = "Código não foi gerado com sucesso!";
            header("Location: ../admin/profile.php");
            exit;
        }
    } else {
        $_SESSION['resposta'] = "Código não foi gerado com sucesso!";
        header("Location: ../admin/profile.php");
        exit;
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../admin/profile.php");
$conexao->close();
$stmt = null;
exit;
