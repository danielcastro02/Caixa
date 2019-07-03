<?php 

class relatorio_mensal{

private $id;
private $mes;
private $ano;
private $status;
private $anterior;
private $saldofinal;


public function __construct() {
    if (func_num_args() != 0) {
        $atributos = func_get_args()[0];
        foreach ($atributos as $atributo => $valor) {
                if (isset($valor)) {
                    $this->$atributo = $valor;
                }
            }
        }
    }

    function atualizar($vetor) {
        foreach ($vetor as $atributo => $valor) {
            if (isset($valor)) {
                $this->$atributo = $valor;
            }
        }
    }

     public function getId(){
         return $this->id;
     }

     function setId($id){
          $this->id = $id;
     }

     public function getMes(){
         return $this->mes;
     }

     function setMes($mes){
          $this->mes = $mes;
     }

     public function getAno(){
         return $this->ano;
     }

     function setAno($ano){
          $this->ano = $ano;
     }

     public function getStatus(){
         return $this->status;
     }

     function setStatus($status){
          $this->status = $status;
     }

     public function getAnterior(){
         return $this->anterior;
     }

     function setAnterior($saldo_inicial){
          $this->anterior = $saldo_inicial;
     }

     public function getSaldofinal(){
         return $this->saldofinal;
     }

     function setSaldofinal($saldofinal){
          $this->saldofinal = $saldofinal;
     }

}