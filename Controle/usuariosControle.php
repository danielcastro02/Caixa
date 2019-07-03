<?php

if (!isset($_SESSION)) {
    session_start();
}

if (realpath('./index.php')) {
    include_once './Controle/usuariosPDO.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/usuariosPDO.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/usuariosPDO.php';
        }
    }
}

$classe = new usuariosPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

