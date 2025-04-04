<?php

$conexao = mysqli_connect("localhost", "root", "", "taskmaker");

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}
