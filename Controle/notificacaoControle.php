<?php

if (!isset($_SESSION)) {
    session_start();
}

include_once __DIR__ . '/../Controle/notificacaoPDO.php';

$classe = new notificacaoPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

