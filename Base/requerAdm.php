<?php

    if (!isset($_SESSION)){
        session_start();
    }
    include_once '../Modelo/Usuarios.php';
    if(isset($_SESSION['logado'])){
        $usuario = new usuarios(unserialize($_SESSION['logado']));
        if ($usuario->getAdmin() == 0) {
            header('location: ' . $pontos . "Tela/acessoNegado.php");
        } else {
            $logado = $usuario;
        }
    }else{
        header('location: ../Tela/login.php');
    }