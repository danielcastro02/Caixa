<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Modelo/Movimento.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Modelo/Movimento.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Movimento.php';
        }
    }
}


class MovimentoPDO{
    /*inserir*/
    function inserirMovimento() {
        $movimento = new movimento($_POST);
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('insert into Movimento values(default , :id_mes , :data , :valor , :operacao , :descricao);' );

        
        $stmt->bindValue(':id_mes', $movimento->getId_mes());    
        
        $stmt->bindValue(':data', $movimento->getData());    
        
        $stmt->bindValue(':valor', $movimento->getValor());    
        
        $stmt->bindValue(':operacao', $movimento->getOperacao());    
        
        $stmt->bindValue(':descricao', $movimento->getDescricao());    
        
        if($stmt->execute()){ 
            header('location: ../index.php?msg=movimentoInserido');
        }else{
            header('location: ../index.php?msg=movimentoErroInsert');
        }
    }
    /*inserir*/
    

            

    public function selectMovimento(){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from movimento ;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectMovimentoId($id){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from movimento where id = :id;');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectMovimentoId_mes($id_mes){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from movimento where id_mes = :id_mes;');
        $stmt->bindValue(':id_mes', $id_mes);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectMovimentoData($data){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from movimento where data = :data;');
        $stmt->bindValue(':data', $data);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectMovimentoValor($valor){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from movimento where valor = :valor;');
        $stmt->bindValue(':valor', $valor);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectMovimentoOperacao($operacao){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from movimento where operacao = :operacao;');
        $stmt->bindValue(':operacao', $operacao);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectMovimentoDescricao($descricao){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from movimento where descricao = :descricao;');
        $stmt->bindValue(':descricao', $descricao);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    
 
    public function updateMovimento(Movimento $Movimento){        
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('updatemovimentoset id_mes = :id_mes , data = :data , valor = :valor , operacao = :operacao , descricao = :descricao where id = :id;');
        $stmt->bindValue(':id_mes', $movimento->getId_mes());
        
        $stmt->bindValue(':data', $movimento->getData());
        
        $stmt->bindValue(':valor', $movimento->getValor());
        
        $stmt->bindValue(':operacao', $movimento->getOperacao());
        
        $stmt->bindValue(':descricao', $movimento->getDescricao());
        
        $stmt->bindValue(':id', $movimento->getId());
        $stmt->execute();
        return $stmt->rowCount();
    }            
    
    public function deleteMovimento($definir){
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from movimento where definir = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }
/*chave*/}
