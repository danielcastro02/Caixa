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
        $stmt = $pdo->prepare('insert into descricao values(default , :texto);' );

        $stmt->bindValue(':texto', $descricao->getTexto());    
        
        if($stmt->execute()){ 
            header('location: ../Tela/home.php?msg=descricaoInserido');
        }else{
            header('location: ../Tela/home.php?msg=descricaoErroInsert');
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
    
 
    public function updateDescricao(Descricao $descricao){        
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update descricao set texto = :texto where id = :id;');
        $stmt->bindValue(':texto', $descricao->getTexto());
        
        $stmt->bindValue(':id', $descricao->getId());
        $stmt->execute();
        return $stmt->rowCount();
    }            
    public function update(){
        $desc = new descricao($_POST);
        $this->updateDescricao($desc);
        header('location: ../Tela/listarDescricao.php');
    }


    public function deleteDescricao($definir){
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from descricao where id = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    public function deletar(){
        $this->deleteDescricao($_GET['id']);
        header('location: ../Tela/listarDescricao.php');
    }
    
/*chave*/}
