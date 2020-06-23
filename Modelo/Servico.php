<?php


class Servico
{

    private $id_servico;
    private $id_cliente;
    private $equipamento;
    private $descricao;
    private $valor;
    private $id_tipo;
    private $status;
    const ST_FILA = 0;
    const ST_REALIZANDO = 1;
    const ST_FEITO = 2;
    const ST_PAGO = 4;
    const ST_IMPOSSIVEL = 5;
    const ST_ATRASADO = 6;
    const ST_DEVENDO = 7;

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

    public function getIdServico()
    {
        return $this->id_servico;
    }

    public function setIdServico($id_servico): void
    {
        $this->id_servico = $id_servico;
    }

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente): void
    {
        $this->id_cliente = $id_cliente;
    }

    public function getEquipamento()
    {
        return $this->equipamento;
    }

    public function setEquipamento($equipamento): void
    {
        $this->equipamento = $equipamento;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor): void
    {
        $this->valor = $valor;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }


}