<?php

class Cliente{

    private $id_cliente;
    private $nome;
    private $telefone;


    public function __construct()
    {
        if (func_num_args() != 0) {
            $atributos = func_get_args()[0];
            foreach ($atributos as $atributo => $valor) {
                if (isset($valor)) {
                    $this->$atributo = $valor;
                }
            }
        }
    }

    function atualizar($vetor)
    {
        foreach ($vetor as $atributo => $valor) {
            if (isset($valor)) {
                $this->$atributo = $valor;
            }
        }
    }


    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente): void
    {
        $this->id_cliente = $id_cliente;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome): void
    {
        $this->nome = $nome;
    }
    public function getTelefone()
    {
        return $this->telefone;
    }
    public function setTelefone($telefone): void
    {
        $this->telefone = $telefone;
    }

}