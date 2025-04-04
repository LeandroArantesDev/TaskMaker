<?php
// Incluindo o conexão para conseguir mexer no banco de dados
require_once("../database/utils/conexao.php");

// Verificação para conferir se o método do formulário é POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verificação do token CSRF
    if (!isset($_POST["_csrf"]) || ($_POST["_csrf"] !== $_SESSION["_csrf"])) {
        $_SESSION['resposta'] = "CSRF Token ínvalido!";
        $_SESSION['_csrf'] = hash('sha256', random_bytes(32));
        header("Location: ../signup.php");
        exit;
    }

    // Recebendo os dados do formulários de criar usuário
    $nome = trim(strip_tags($_POST["nome"]));
    $sobrenome = trim(strip_tags($_POST["sobrenome"]));
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $senha = trim(strip_tags($_POST["senha"]));
    $confirmarsenha = trim(strip_tags($_POST["confirmarsenha"]));

    // Verificar o email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['resposta'] = "Email inválido!";
        header("Location: ../signup.php");
        exit;
    }

    // Verificar se os dados chegaram com sucesso para continuar
    if (empty($nome) || empty($sobrenome) || empty($email) || empty($senha) || empty($confirmarsenha)) {

        // Verificar se as senhas são iguais e criptografa-la
        if ($senha === $confirmarsenha) {
            $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
        } else {
            $_SESSION['resposta'] = "As senhas não estão iguais!";
            header("Location: ../signup.php");
            exit;
        }
    } else {
        $_SESSION['resposta'] = "Variável POST ínvalida!";
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../signup.php");
exit;
