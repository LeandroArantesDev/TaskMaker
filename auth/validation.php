<?php
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
