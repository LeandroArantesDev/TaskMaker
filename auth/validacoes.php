<?php
// Importando PHPmail
require_once("../src/Exception.php");
require_once("../src/SMTP.php");
require_once("../src/PHPMailer.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Incluindo o conexão para conseguir mexer no banco de dados
require_once("../database/utils/conexao.php");

function validarSenha($senha)
{
    if (strlen($senha) < 8) {
        return "A senha deve ter pelo menos 8 caracteres.";
    }
    if (!preg_match("/[a-z]/", $senha)) {
        return "A senha deve conter pelo menos uma letra minúscula.";
    }
    if (!preg_match("/[A-Z]/", $senha)) {
        return "A senha deve conter pelo menos uma letra maiúscula.";
    }
    if (!preg_match("/[0-9]/", $senha)) {
        return "A senha deve conter pelo menos um número.";
    }
    if (!preg_match("/[\W_]/", $senha)) {
        return "A senha deve conter pelo menos um caractere especial (ex: @, #, $, %, &).";
    }

    return true;
}


function validarNome($nome, $min = 3, $max = 50)
{
    // Remove espaços extras no começo e fim
    $nome = trim($nome);

    // Verifica se está vazio
    if (empty($nome)) {
        return "O nome não pode estar vazio.";
    }

    // Verifica tamanho mínimo e máximo
    $tamanho = strlen($nome);
    if ($tamanho < $min || $tamanho > $max) {
        return "O nome deve ter entre $min e $max caracteres.";
    }

    // Verifica se o nome contém apenas letras, espaços e acentos
    if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $nome)) {
        return "O nome deve conter apenas letras e espaços.";
    }

    // Se passou por tudo, está válido
    return true;
}

function gerarCodigo($email, $retorno)
{
    global $conexao; //
    $email_sanitizado = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (!filter_var($email_sanitizado, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['resposta'] = "Email inválido!";
        header("Location: ../cadastrar.php");
        exit;
    }

    // código de 6 dígitos
    $codigo_confirmacao_email = rand(100000, 999999);

    if (preg_match('/^\d+$/', $codigo_confirmacao_email)) {
        $mail = new PHPMailer(true);

        //mandar e-mail
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
            $mail->Subject = "Assunto";
            // Adicionar corpo com hmtl ativo
            $mail->Body = "O seu código de acesso é <strong>{$codigo_confirmacao_email}</strong>";
            // Adcionar uma versão alternativa para algum cliente que não lê html
            $mail->AltBody = "O seu código de acesso é {$codigo_confirmacao_email}";
        } catch (Exception $e) {
            $_SESSION['resposta'] = "Erro ao enviar mensagem: {$mail->ErrorInfo}";
            header("Location: {$retorno}");
            exit;
        }

        $codigo_confirmacao_email_hash = password_hash($codigo_confirmacao_email, PASSWORD_BCRYPT);

        $update = "UPDATE usuarios SET codigo_confirmacao = ? WHERE email = ?";
        $stmt = $conexao->prepare($update);
        $stmt->bind_param("ss", $codigo_confirmacao_email_hash, $email);

        // Se funcionar a inserção no banco ele retorna para a tela do profile falando que funcionou, se não ele retornaerro
        if ($stmt->execute() and $mail->send()) {
            $_SESSION['resposta'] = "Código enviado para o email";
            header("Location: {$retorno}");
            exit;
        } else {
            $_SESSION['resposta'] = "Código não foi gerado com sucesso!";
            header("Location: {$retorno}");
            exit;
        }
    }
}
