<?php

include_once __DIR__."/PDOBase.php";
include_once __DIR__."/../Modelo/TipoServico.php";

class TipoServicoPDO extends PDOBase
{
    public function inserir(){
        $tipo = new TipoServico($_POST);
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into tipo_servico values(default , :operacao , :nome)");
        $stmt->bindValue(":operacao" , $tipo->getOperacao());
        $stmt->bindValue(":nome" , $tipo->getNome());
        try {
            $stmt->execute();
            $this->addToast("Inserido com sucesso!");
            header("location: ../Tela/registroTiposervico.php");
        }catch (Exception $e){
            $this->addToast("Erro!");
            header("location: ../Tela/registroTiposervico.php");
        }

    }
}