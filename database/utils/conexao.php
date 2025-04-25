<?php

$conexao = new mysqli("127.0.0.1", "root", "root", "taskmaker");

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}
