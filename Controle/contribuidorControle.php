<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once __DIR__.'/../Controle/ContribuidorPDO.php';
$classe = new ContribuidorPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

