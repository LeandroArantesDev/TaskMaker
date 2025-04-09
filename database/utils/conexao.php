<?php

$conexao = new mysqli("localhost", "root", "", "taskmaker");

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}
