<?php

if (!isset($_SESSION)) {
    session_start();
}

if (realpath('./index.php')) {
    include_once './Controle/parametrosPDO.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/parametrosPDO.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/parametrosPDO.php';
        }
    }
}

$classe = new parametrosPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

