<?php


class Contribuicao
{
    private $id_constribuicao;
    private $id_contribuidor;
    private $data;
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

    public function getIdConstribuicao()
    {
        return $this->id_constribuicao;
    }

    public function setIdConstribuicao($id_constribuicao): void
    {
        $this->id_constribuicao = $id_constribuicao;
    }

    public function getIdContribuidor()
    {
        return $this->id_contribuidor;
    }

    public function setIdContribuidor($id_contribuidor): void
    {
        $this->id_contribuidor = $id_contribuidor;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): void
    {
        $this->data = $data;
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