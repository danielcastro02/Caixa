<?php

class movimento
{

    private $id;
    private $id_mes;
    private $data;
    private $valor;
    private $operacao;
    private $descricao;
    private $id_usuario;
    private $data_registro;
    const SAIDA = -1;
    const ENTRADA = 1;



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

    public function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    public function getId_mes()
    {
        return $this->id_mes;
    }

    function setId_mes($id_mes)
    {
        $this->id_mes = $id_mes;
    }

    public function getData()
    {
        return $this->data;
    }

    function setData($data)
    {
        $this->data = $data;
    }

    public function getValor()
    {
        return $this->valor;
    }

    function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getOperacao()
    {
        return $this->operacao;
    }

    function setOperacao($operacao)
    {
        $this->operacao = $operacao;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    private function getOperacaoText(): string
    {
        switch ($this->operacao) {
            case -3:
                return "Retirada Francisco";
                break;
            case -2:
                return "Retirada Daniel";
                break;
            case -1:
                return "Saída";
                break;
            case 1:
                return "Entrada";
                break;
            case 2:
                return "Formatação";
                break;
            case 3:
                return "Ebook";
                break;
            case 4:
                return "Impressões";
                break;
            case 5:
                return "Manutenção de Software";
                break;
            case 6:
                return "Manutenção de Hardware";
                break;
        }
    }

}