<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Modelo/Descricao.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Modelo/Descricao.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Descricao.php';
        }
    }
}


class DescricaoPDO{
    /*inserir*/
    function inserirDescricao() {
        $descricao = new descricao($_POST);
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('insert into Descricao values(:id , :texto);' );

        $stmt->bindValue(':id', $descricao->getId());    
        
        $stmt->bindValue(':texto', $descricao->getTexto());    
        
        if($stmt->execute()){ 
            header('location: ../index.php?msg=descricaoInserido');
        }else{
            header('location: ../index.php?msg=descricaoErroInsert');
        }
    }
    /*inserir*/
    

            

    public function selectDescricao(){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from descricao ;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectDescricaoId($id){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from descricao where id = :id;');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectDescricaoTexto($texto){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from descricao where texto = :texto;');
        $stmt->bindValue(':texto', $texto);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    
 
    public function updateDescricao(Descricao $Descricao){        
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('updatedescricaoset texto = :texto where id = :id;');
        $stmt->bindValue(':texto', $descricao->getTexto());
        
        $stmt->bindValue(':id', $descricao->getId());
        $stmt->execute();
        return $stmt->rowCount();
    }            
    
    public function deleteDescricao($definir){
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from descricao where definir = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }
/*chave*/}
