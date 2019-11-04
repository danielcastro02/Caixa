<?php
include_once __DIR__ . "/../Controle/movimentoPDO.php";
include_once __DIR__ . "/../Modelo/Movimento.php";
include_once __DIR__ . "/../Controle/relatorio_mensalPDO.php";
include_once __DIR__ . "/../Modelo/Relatorio_mensal.php";

class graphPDO
{

    function getLineData($id)
    {
        $relatorioMensalPDO = new Relatorio_mensalPDO();
        $stmtRelatorio = $relatorioMensalPDO->selectRelatorio_mensalId($id);
        $relatorio = new relatorio_mensal($stmtRelatorio->fetch());
        $anterior = $relatorioMensalPDO->selectRelatorio_mensalId($relatorio->getAnterior());
        $anterior = new relatorio_mensal($anterior->fetch());
        $saldo = $anterior->getSaldofinal();
        $movimentoPDO = new MovimentoPDO();

        $stmtMovimentos = $movimentoPDO->selectMovimentoId_mes($id);
        $data = '{ labels: [';
        for ($i = 1 ; $i<31 ;$i++){
            $data = $data."'$i',";
        }
        $data = $data."'31'],datasets: [{
label: '".$relatorio->getMes()."',
backgroundColor: 'rgb(255, 99, 132)',
borderColor: 'rgb(255, 99, 132)',data: [";
        $movimentosArray = [];
        while($linha = $stmtMovimentos->fetch()){
            $movimentosArray[] = $linha;
        }
        for ($i = 1 ; $i<31; $i++){
            foreach ($movimentosArray as $linha){
                $movimento = new movimento($linha);
                if($movimento->getData() == $i){
                    if($movimento->getOperacao()=="entrada"){
                        $saldo = $saldo+$movimento->getValor();
                    }
                    if($movimento->getOperacao()=="saida"){
                        $saldo = $saldo-$movimento->getValor();
                    }
                }
            }
            $data = $data.$saldo.',';
        }
        foreach ($movimentosArray as $linha){
            $movimento = new movimento($linha);
            if($movimento->getData() == $i){
                if($movimento->getOperacao()=="entrada"){
                    $saldo = $saldo+$movimento->getValor();
                }
                if($movimento->getOperacao()=="saida"){
                    $saldo = $saldo-$movimento->getValor();
                }
            }
        }
        $data = $data.$saldo.']}]
}';
        echo $data;
    }


//{
//labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//datasets: [{
//label: 'My First dataset',
//backgroundColor: 'rgb(255, 99, 132)',
//borderColor: 'rgb(255, 99, 132)',
//data: [0, 10, 5, 2, 20, 30, 45]
//}]
//}
}