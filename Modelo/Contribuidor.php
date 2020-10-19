<?php


class Contribuidor
{
    private $id_contribuidor;
    private $numero;
    private $nome;
    private $valor;

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

    public function getIdContribuidor()
    {
        return $this->id_contribuidor;
    }

    public function setIdContribuidor($id_contribuidor): void
    {
        $this->id_contribuidor = $id_contribuidor;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }



    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    public function getValor()
    {
        return $this->valor;
    }
    public function setValor($valor): void
    {
        $this->valor = $valor;
    }



}