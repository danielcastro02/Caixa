<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Controle/movimentoPDO.php';
    include_once './Modelo/Relatorio_mensal.php';
    include_once './Modelo/Movimento.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Controle/movimentoPDO.php';
        include_once '../Modelo/Relatorio_mensal.php';
        include_once '../Modelo/Movimento.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Relatorio_mensal.php';
            include_once '../../Modelo/Movimento.php';
            include_once '../../Controle/movimentoPDO.php';
        }
    }
}

class Relatorio_mensalPDO {
    /* inserir */

    function inserirRelatorio_mensal() {
        $relatorio_mensal = new relatorio_mensal($_POST);
        $con = new conexao();
        $pdo = $con->getConexao();
        if($_POST['id_anterior'] ==0){
            $pdo->exec("insert into relatorio_mensal values(default , 'Primeiro' , '0000' , 'fechado' , 0 , 0)");
            $anterior = $this->selectRelatorio_mensalId($pdo->lastInsertId('id'));
        }else {
            $anterior = $this->selectRelatorio_mensalId($_POST['id_anterior']);
        }
        $anterior = new relatorio_mensal($anterior->fetch());
        $anterior->setStatus("lincado");
        $this->updateRelatorio_mensal($anterior);
        $stmt = $pdo->prepare('insert into relatorio_mensal values(default , :mes , :ano , :status , :anterior , 0);');

        $stmt->bindValue(':mes', $relatorio_mensal->getMes());

        $stmt->bindValue(':ano', $relatorio_mensal->getAno());

        $stmt->bindValue(':status', $relatorio_mensal->getStatus());

        $stmt->bindValue(':anterior', $anterior->getId());


        if ($stmt->execute()) {
            header('location: ../Tela/home.php?msg=relatorio_mensalInserido');
        } else {
            //header('location: ../Tela/home.php?msg=relatorio_mensalErroInsert');
        }
    }

    /* inserir */

    public function abrir() {
        $relatorio = $this->selectRelatorio_mensalId($_GET['id']);
        $relatorio = new relatorio_mensal($relatorio->fetch());
        if ($relatorio->getStatus() == "lincado" || $relatorio->getStatus() == "fechadolincado") {
            $relatorio->setStatus("abertolincado");
        } else {
            $relatorio->setStatus("aberto");
        }
        $this->updateRelatorio_mensal($relatorio);
        header('location: ../Tela/listarRelatorio.php');
    }

    public function fechar() {
        echo 'entrou';
        $relatorio = $this->selectRelatorio_mensalId($_GET['id']);
        $relatorio = new relatorio_mensal($relatorio->fetch());
        if ($relatorio->getStatus() == "abertolincado" || $relatorio->getStatus() == "lincado") {
            $relatorio->setStatus("fechadolincado");
        } else {
            $relatorio->setStatus("fechado");
        }
        $anterior = $this->selectRelatorio_mensalId($relatorio->getAnterior());
        $anterior = new relatorio_mensal($anterior->fetch());
        $saldo = $anterior->getSaldofinal();
        $movimentoPDO = new MovimentoPDO();
        $movimentos = $movimentoPDO->selectMovimentoId_mes($relatorio->getId());
        if ($movimentos) {
            while ($movimento = $movimentos->fetch()) {
                $movimento = new movimento($movimento);
                if ($movimento->getOperacao() == 'entrada') {
                    $saldo = $saldo + $movimento->getValor();
                }
                if ($movimento->getOperacao() == 'saida') {
                    $saldo = $saldo - $movimento->getValor();
                }
            }
        }
        $relatorio->setSaldofinal($saldo);
        $this->updateRelatorio_mensal($relatorio);
        header('location: ../Tela/listarRelatorio.php');
    }

    public function selectRelatorio_mensal() {

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

    public function selectRelatorio_mensalId($id) {

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

    public function selectRelatorio_mensalMes($mes) {

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

    public function selectRelatorio_mensalAno($ano) {

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

    public function selectRelatorio_mensalStatus($status) {

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

    public function selectRelatorio_mensalSaldo_inicial($saldo_inicial) {

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

    public function selectRelatorio_mensalSaldofinal($saldofinal) {

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

    public function updateRelatorio_mensal(Relatorio_mensal $relatorio_mensal) {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update relatorio_mensal set mes = :mes , ano = :ano , status = :status , anterior = :saldo_inicial , saldofinal = :saldofinal where id = :id;');
        $stmt->bindValue(':mes', $relatorio_mensal->getMes());

        $stmt->bindValue(':ano', $relatorio_mensal->getAno());

        $stmt->bindValue(':status', $relatorio_mensal->getStatus());

        $stmt->bindValue(':saldo_inicial', $relatorio_mensal->getAnterior());

        $stmt->bindValue(':saldofinal', $relatorio_mensal->getSaldofinal());

        $stmt->bindValue(':id', $relatorio_mensal->getId());
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteRelatorio_mensal($definir) {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from relatorio_mensal where id = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }

    /* chave */}
