<?php
include_once '../Base/requerLogin.php';

if (!isset($_SESSION)) {
    session_start();
}

if (realpath('./index.php')) {
    include_once './Controle/relatorio_mensalPDO.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/relatorio_mensalPDO.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/relatorio_mensalPDO.php';
        }
    }
}

$classe = new relatorio_mensalPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

