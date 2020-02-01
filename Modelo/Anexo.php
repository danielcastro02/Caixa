<?php


class Anexo
{
    private $id_anexo;
    private $id_movimento;
    private $caminho;

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

    public function getIdAnexo()
    {
        return $this->id_anexo;
    }

    public function setIdAnexo($id_anexo): void
    {
        $this->id_anexo = $id_anexo;
    }

    public function getIdMovimento()
    {
        return $this->id_movimento;
    }

    public function setIdMovimento($id_movimento): void
    {
        $this->id_movimento = $id_movimento;
    }

    public function getCaminho()
    {
        return $this->caminho;
    }

    public function setCaminho($caminho): void
    {
        $this->caminho = $caminho;
    }


}