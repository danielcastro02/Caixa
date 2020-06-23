<?php


class TipoServico
{
    private $id_tipo;
    private $operacao;
    private $nome;

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

    public function getIdTipo()
    {
        return $this->id_tipo;
    }

    public function setIdTipo($id_tipo): void
    {
        $this->id_tipo = $id_tipo;
    }

    public function getOperacao()
    {
        return $this->operacao;
    }

    public function setOperacao($operacao): void
    {
        $this->operacao = $operacao;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome): void
    {
        $this->nome = $nome;
    }



}