<?php 

class codigoconfirmacao{

private $id_codigo;
private $id_usuario;
private $codigo;


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

     public function getId_codigo(){
         return $this->id_codigo;
     }

     function setId_codigo($id_codigo){
          $this->id_codigo = $id_codigo;
     }

     public function getId_usuario(){
         return $this->id_usuario;
     }

     function setId_usuario($id_usuario){
          $this->id_usuario = $id_usuario;
     }

     public function getCodigo(){
         return $this->codigo;
     }

     function setCodigo($codigo){
          $this->codigo = $codigo;
     }

}