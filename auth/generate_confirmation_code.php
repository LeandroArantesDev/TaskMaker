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
    $codigo_confirmacao_email = rand(100000, 999999);
    $email = $_SESSION["email"];

    // Verificar se contém apenas números
    if (preg_match('/^\d+$/', $codigo_confirmacao_email)) {

        $update = "UPDATE usuarios SET codigo_confirmacao = ? WHERE email = ?";
        $stmt = $conexao->prepare($update);
        $stmt->bind_param("ss", $codigo_confirmacao_email, $email);

        // Se funcionar a inserção no banco ele retorna para a tela do index falando que funcionou, se não ele retorna erro
        if ($stmt->execute()) {
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
