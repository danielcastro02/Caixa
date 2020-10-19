<?php

include_once __DIR__."/conexao.php";
include_once __DIR__."/../Modelo/Contribuidor.php";

class ContribuidorPDO
{

    function inserir(){
        $pdo = conexao::getConexao();
        $contribuidor = new Contribuidor();
        $stmt = $pdo->prepare("insert into contribuidor values(default , :numero , :nome, :valor);");
        $stmt->bindValue(":numero" , $contribuidor->getNumero());
        $stmt->bindValue(":nome" , $contribuidor->getNome());
        $stmt->bindValue(":valor" , $contribuidor->getValor());
        $stmt->execute();
        header("location: ../index.php");
    }

}