<?php
session_start();

if (!isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}
