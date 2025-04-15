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

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verificação do token CSRF
    if (!isset($_POST["_csrf"]) || ($_POST["_csrf"] !== $_SESSION["_csrf"])) {
        $_SESSION['resposta'] = "CSRF Token ínvalido!";
        $_SESSION['_csrf'] = hash('sha256', random_bytes(32));
        header("Location: ../recuperar_senha.php");
        exit;
    }

    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $etapa = trim(strip_tags($_POST["etapa"]));

    // Verificar o email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['resposta'] = "Email inválido!";
        header("Location: ../recuperar_senha.php");
        exit;
    }

    // Verifica as variaveis
    if (!empty($email) && !empty($etapa)) {
        // Verificação de qual etapa do código está
        switch ($etapa) {
            case 1:
                // código de 6 dígitos
                $codigo_confirmacao_email = rand(100000, 999999);

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
                        $mail->Password = "xrmc twkh idoy yddg";
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
                        $mail->Subject = "Código de confirmação TaskMaker";
                        // Adicionar corpo com hmtl ativo
                        $mail->Body = "O seu código de acesso é <strong>{$codigo_confirmacao_email}</strong>";
                        // Adcionar uma versão alternativa para algum cliente que não lê html
                        $mail->AltBody = "O seu código de acesso é {$codigo_confirmacao_email}";
                    } catch (Exception $e) {
                        $_SESSION['resposta'] = "Erro ao enviar mensagem: {$mail->ErrorInfo}";
                        header("Location: ../recuperar_senha.php");
                        exit;
                    }

                    $update = "UPDATE usuarios SET codigo_confirmacao = ? WHERE email = ?";
                    $stmt = $conexao->prepare($update);
                    $stmt->bind_param("ss", $codigo_confirmacao_email, $email);

                    // Se funcionar a inserção no banco ele retorna para a tela do profile falando que funcionou, se não ele retornaerro
                    if ($stmt->execute() and $mail->send()) {
                        $_SESSION["etapa"] = 2;
                        $_SESSION['resposta'] = "Código enviado para o email";
                        header("Location: ../recuperar_senha.php");
                        exit;
                    } else {
                        $_SESSION['resposta'] = "Código não foi gerado com sucesso!";
                        header("Location: ../recuperar_senha.php");
                        exit;
                    }
                } else {
                    $_SESSION['resposta'] = "Código não foi gerado com sucesso!";
                    header("Location: ../recuperar_senha.php");
                    exit;
                }
            case 2:
                // Faz a verificação do banco de dados para ver se código está certo
                $select = "SELECT codigo_confirmacao FROM usuarios WHERE email = ?";
                $stmt = $conexao->prepare($select);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($codigo_confirmacao_email_db);
                $stmt->fetch();
                $stmt = null;

                if ($codigo_confirmacao_email == $codigo_confirmacao_email_db) {
                    // Se funcionar a inserção no banco ele retorna para a tela do index falando que funcionou, se não ele retorna erro
                    $_SESSION["etapa"] = 2;
                    $_SESSION['resposta'] = "Código está certo!";
                    header("Location: ../recuperar_senha.php");
                    exit;
                } else {
                    $_SESSION["etapa"] = 1;
                    $_SESSION['resposta'] = "Código está errado!";
                    header("Location: ../recuperar_senha.php");
                    exit;
                }
            case 3:

            default:
        }
    } else {
        $_SESSION['resposta'] = "Variável POST ínvalida!";
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../recuperar_senha.php");
$conexao->close();
$stmt = null;
exit;
