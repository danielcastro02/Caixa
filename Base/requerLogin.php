<?php

if (isset($_SESSION)){
    session_start();
}
include_once '../Modelo/Usuarios.php';
if(isset($_SESSION['logado'])){
    $logado = new usuarios(unserialize($_SESSION['logado']));
}else{
    header('location: ../Tela/login.php');
}