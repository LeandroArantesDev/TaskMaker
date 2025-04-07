<?php
session_start();
// Incluindo o conexão para conseguir mexer no banco de dados
require_once("../database/utils/conexao.php");

// Incluindo o arquivo que contém as validações
include_once("validation.php");

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
    $nome = mb_convert_case(trim(strip_tags($_POST["nome"])), MB_CASE_TITLE, "UTF-8");
    $sobrenome = mb_convert_case(trim(strip_tags($_POST["sobrenome"])), MB_CASE_TITLE, "UTF-8");
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $senha = trim(strip_tags($_POST["senha"]));
    $confirmarsenha = trim(strip_tags($_POST["confirmarsenha"]));

    // Verificar o email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['resposta'] = "Email inválido!";
        header("Location: ../signup.php");
        exit;
    }

    // Verifica se a senha não está fraca
    $validarSenha = validarSenha($senha);

    if ($validarSenha !== true) {
        $_SESSION['resposta'] = $validarSenha;
        header("Location: ../signup.php");
        exit;
    }

    // Verificar se os dados chegaram com sucesso para continuar
    if (!empty($nome) && !empty($sobrenome) && !empty($email) && !empty($senha) && !empty($confirmarsenha)) {

        // Verificar se as senhas são iguais e criptografa-la
        if ($senha === $confirmarsenha) {
            $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
        } else {
            $_SESSION['resposta'] = "As senhas não estão iguais!";
            header("Location: ../signup.php");
            exit;
        }


        try {

            // Faz a inserção no banco de dados
            $insert = $insert = "INSERT INTO usuarios (nome, sobrenome, email, senha) VALUES (?,?,?,?)";;

            $stmt = $conexao->prepare($insert);
            $stmt->bind_param("ssss", $nome, $sobrenome, $email, $senha_hash);

            // Se funcionar a inserção no banco ele retorna para a tela do index falando que funcionou, se não ele retorna erro
            if ($stmt->execute()) {
                $_SESSION['resposta'] = "Usuário cadastrado com sucesso!";
                header("Location: ../signup.php");
                exit;
            } else {
                $_SESSION['resposta'] = "Usuário deu erro!";
                header("Location: ../signup.php");
                exit;
            }
        } catch (Exception $erro_email) {

            // Caso houver erro de email duplicado código 1062 ele retorna erro
            if ($erro_email->getCode() == 1062) {
                $_SESSION['resposta'] = "Email já cadastrado!";
                header("Location: ../signup.php");
                exit;
            } else {
                $_SESSION['resposta'] = "Erro ao cadastrar usuário!";
                header("Location: ../signup.php");
                exit;
            }
        }
    } else {
        $_SESSION['resposta'] = "Variável POST ínvalida!";
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../signup.php");
$conexao->close();
exit;
