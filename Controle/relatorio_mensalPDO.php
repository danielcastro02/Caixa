<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Modelo/Relatorio_mensal.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Modelo/Relatorio_mensal.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Relatorio_mensal.php';
        }
    }
}


class Relatorio_mensalPDO{
    /*inserir*/
    function inserirRelatorio_mensal() {
        $relatorio_mensal = new relatorio_mensal($_POST);
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('insert into Relatorio_mensal values(:id , :mes , :ano , :status , :saldo_inicial , :saldofinal);' );

        $stmt->bindValue(':id', $relatorio_mensal->getId());    
        
        $stmt->bindValue(':mes', $relatorio_mensal->getMes());    
        
        $stmt->bindValue(':ano', $relatorio_mensal->getAno());    
        
        $stmt->bindValue(':status', $relatorio_mensal->getStatus());    
        
        $stmt->bindValue(':saldo_inicial', $relatorio_mensal->getSaldo_inicial());    
        
        $stmt->bindValue(':saldofinal', $relatorio_mensal->getSaldofinal());    
        
        if($stmt->execute()){ 
            header('location: ../index.php?msg=relatorio_mensalInserido');
        }else{
            header('location: ../index.php?msg=relatorio_mensalErroInsert');
        }
    }
    /*inserir*/
    

            

    public function selectRelatorio_mensal(){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from relatorio_mensal ;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectRelatorio_mensalId($id){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from relatorio_mensal where id = :id;');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectRelatorio_mensalMes($mes){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from relatorio_mensal where mes = :mes;');
        $stmt->bindValue(':mes', $mes);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectRelatorio_mensalAno($ano){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from relatorio_mensal where ano = :ano;');
        $stmt->bindValue(':ano', $ano);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectRelatorio_mensalStatus($status){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from relatorio_mensal where status = :status;');
        $stmt->bindValue(':status', $status);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectRelatorio_mensalSaldo_inicial($saldo_inicial){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from relatorio_mensal where saldo_inicial = :saldo_inicial;');
        $stmt->bindValue(':saldo_inicial', $saldo_inicial);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectRelatorio_mensalSaldofinal($saldofinal){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from relatorio_mensal where saldofinal = :saldofinal;');
        $stmt->bindValue(':saldofinal', $saldofinal);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    
 
    public function updateRelatorio_mensal(Relatorio_mensal $Relatorio_mensal){        
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('updaterelatorio_mensalset mes = :mes , ano = :ano , status = :status , saldo_inicial = :saldo_inicial , saldofinal = :saldofinal where id = :id;');
        $stmt->bindValue(':mes', $relatorio_mensal->getMes());
        
        $stmt->bindValue(':ano', $relatorio_mensal->getAno());
        
        $stmt->bindValue(':status', $relatorio_mensal->getStatus());
        
        $stmt->bindValue(':saldo_inicial', $relatorio_mensal->getSaldo_inicial());
        
        $stmt->bindValue(':saldofinal', $relatorio_mensal->getSaldofinal());
        
        $stmt->bindValue(':id', $relatorio_mensal->getId());
        $stmt->execute();
        return $stmt->rowCount();
    }            
    
    public function deleteRelatorio_mensal($definir){
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from relatorio_mensal where definir = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }
/*chave*/}
