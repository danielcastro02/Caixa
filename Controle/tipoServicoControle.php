<?php

if (!isset($_SESSION)) {
    session_start();
}

include_once __DIR__.'/parametrosPDO.php';

$classe = new parametrosPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

