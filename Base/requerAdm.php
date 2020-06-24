<?php

    if (!isset($_SESSION)){
        session_start();
    }
    include_once '../Modelo/Usuario.php';
    if(isset($_SESSION['logado'])){
        $usuario = new usuario(unserialize($_SESSION['logado']));
        if ($usuario->getAdministrador() == 0) {
            header('location: ' . $pontos . "Tela/acessoNegado.php");
        } else {
            $logado = $usuario;
        }
    }else{
        header('location: ../Tela/login.php');
    }