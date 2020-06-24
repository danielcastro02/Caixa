<?php

if (!isset($_SESSION)){
    session_start();
}
include_once '../Modelo/Usuario.php';
if(isset($_SESSION['logado'])){
    $logado = new usuario(unserialize($_SESSION['logado']));
}else{
    header('location: ../Tela/login.php');
}