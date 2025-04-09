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
        header("Location: ../signin.php");
        exit;
    }

    // Recebendo os dados do formulários de criar usuário
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $senha = trim(strip_tags($_POST["senha"]));


    // Verificar o email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['resposta'] = "Email inválido!";
        header("Location: ../signin.php");
        exit;
    }

    // Verifica se a senha não está fraca
    $validarSenha = validarSenha($senha);

    if ($validarSenha !== true) {
        $_SESSION['resposta'] = $validarSenha;
        header("Location: ../signin.php");
        exit;
    }

    // Verificar se os dados chegaram com sucesso para continuar
    if (!empty($email) && !empty($senha)) {
        try {

            // Faz a verificação no banco de dados
            $select = "SELECT id, nome, email, senha FROM usuarios WHERE email = ? AND status = 1";

            $stmt = $conexao->prepare($select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($id, $nome, $email, $senha_db);
            $stmt->fetch();

            // Se verificar que email e senha existe e batem no banco de dados ele loga o usuário;
            if (!empty($nome) && !empty($senha) && password_verify($senha, $senha_db)) {
                $_SESSION["id"] = $id;
                $_SESSION["nome"] = $nome;
                $_SESSION["email"] = $email;
                header("Location: ../admin/dashboard.php");
                exit;
            } else {
                $_SESSION['resposta'] = "E-mail ou senha inválidos!";
                header("Location: ../signin.php");
                exit;
            }
        } catch (Exception $erro_email) {

            // Caso houver erro ele retorna
            switch ($erro_email->getCode()) {
                // erro de quantidade de paramêtros erro
                case 1136:
                    $_SESSION['resposta'] = "Quantidade de dados inseridos inválida!";
                    header("Location: ../signin.php");
                    exit;

                default:
                    $_SESSION['resposta'] = "error" . $erro_email->getCode();
                    header("Location: ../signin.php");
                    exit;
            }
        }
    }
} else {
    $_SESSION['resposta'] = "Método de solicitação ínvalido!";
}

header("Location: ../signin.php");
$conexao->close();
$stmt = null;
exit;
