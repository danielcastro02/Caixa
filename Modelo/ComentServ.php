<?php


class ComentServ
{

    private $id_coment;
    private $id_servico;
    private $comentario;
    private $time_coment;

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

    public function getIdComent()
    {
        return $this->id_coment;
    }

    public function setIdComent($id_coment): void
    {
        $this->id_coment = $id_coment;
    }

    public function getIdServico()
    {
        return $this->id_servico;
    }

    public function setIdServico($id_servico): void
    {
        $this->id_servico = $id_servico;
    }
    public function getComentario()
    {
        return $this->comentario;
    }

    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
    }

    public function getTimeComent()
    {
        return $this->time_coment;
    }

    public function setTimeComent($time_coment): void
    {
        $this->time_coment = $time_coment;
    }



}