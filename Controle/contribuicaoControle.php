<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once __DIR__.'/../Controle/ContribuicaoPDO.php';
$classe = new ContribuicaoPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

