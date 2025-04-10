<?php
//Inicia ou recupera a sessão anterior
session_start();

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
    $codigo_confirmacao_email = trim(strip_tags($_POST["codigo_confirmacao"]));
    $email = $_SESSION["email"];

    // Verificar se contém apenas números
    if (preg_match('/^\d+$/', $codigo_confirmacao_email)) {

        $select = "SELECT codigo_confirmacao FROM usuarios WHERE email = ?";
        $stmt = $conexao->prepare($select);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($codigo_confirmacao_email_db);
        $stmt->fetch();
        $stmt = null;

        if ($codigo_confirmacao_email == $codigo_confirmacao_email_db) {
            $update = "UPDATE usuarios SET email_confirmado = 1, codigo_confirmacao = null WHERE email = ?";
            $stmt = $conexao->prepare($update);
            $stmt->bind_param("s", $email);

            // Se funcionar a inserção no banco ele retorna para a tela do index falando que funcionou, se não ele retorna erro
            if ($stmt->execute()) {
                $_SESSION['resposta'] = "E-mail validado com sucesso!";
                header("Location: ../admin/profile.php");
                exit;
            } else {
                $_SESSION['resposta'] = "Não foi possível validar o E-mail!";
                header("Location: ../admin/profile.php");
                exit;
            }
        } else {
            $codigo_confirmacao_email = rand(100000, 999999);
            $update = "UPDATE usuarios SET codigo_confirmacao = ? WHERE email = ?";
            $stmt = $conexao->prepare($update);
            $stmt->bind_param("ss", $codigo_confirmacao_email, $email);
            if ($stmt->execute()) {
                $_SESSION['resposta'] = "Código inválido! Tente novamente!";
                header("Location: ../admin/confirm_email.php");
                exit;
            } else {
                $_SESSION['resposta'] = "Não foi possível gerar um novo código!";
                header("Location: ../admin/confirm_email.php");
                exit;
            }
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
