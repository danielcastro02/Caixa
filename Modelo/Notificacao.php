<?php

$pontos = "";
if (realpath("./index.php")) {
    $pontos = './';
} else {
    if (realpath("../index.php")) {
        $pontos = '../';
    } else {
        if (realpath("../../index.php")) {
            $pontos = '../../';
        }
    }
}

include_once $pontos . 'Modelo/Parametros.php';
include_once $pontos . 'Modelo/Usuario.php';
include_once $pontos . 'Controle/conexao.php';
include_once $pontos . 'Controle/usuarioPDO.php';

class Notificacao {

    private $id_notificacao = "";
    private $app_token;
    private $destinatario = "/topics/dispositivos";
    private $multicasArray = "undefined";
    private $idDestinatarios = [];
    private $title = 'Errei';
    private $body = "Algum estagiario mandou isso aqui errado!";
    private $imageUrl = "";
    private $prioridade = 1;
    private $id_agendamento = "";
    private $urlDestino = "/index.php";
    private $enviado = 0;

    public function __construct() {
        if (func_num_args() != 0) {
            $atributos = func_get_args()[0];
            foreach ($atributos as $atributo => $valor) {
                if (isset($valor)) {
                    $this->$atributo = $valor;
                }
            }
        }

        $parametros = new parametros();
        $this->app_token = $parametros->getAppToken();
    }

    function getApp_token() {
        return $this->app_token;
    }

    function getUrlDestino() {
        return $this->urlDestino;
    }

    function setUrlDestino($urlDestino) {
        $this->urlDestino = $urlDestino;
    }

    function stmt2MulticastArray($stmt) {
        if ($stmt) {
            $this->multicasArray = [];
            while ($linha = $stmt->fetch()) {
                if ($linha['token'] != "" && $linha['token'] != null) {
                    $this->multicasArray[] = $linha['token'];
                }
                $this->idDestinatarios[] = $linha['id_usuario'];
            }
        } else {
            $this->multicasArray = "";
        }
    }

    function addToMulticasArray(string $destinatario, $id_usuario) {
        if ($this->multicasArray == 'undefined') {
            $this->multicasArray = [];
        }
        $this->multicasArray[] = $destinatario;
        $this->idDestinatarios[] = $id_usuario;
    }

    function getMulticasArray() {
        return $this->multicasArray;
    }

    function getIdDestinatarios() {
        return $this->idDestinatarios;
    }

    function setIdDestinatarios($idDestinatarios) {
        $this->idDestinatarios = $idDestinatarios;
    }

    function getPrioridade() {
        return $this->prioridade;
    }

    function setPrioridade($prioridade) {
        $this->prioridade = $prioridade;
    }

    function setMulticasArray($multicasArray) {
        $this->multicasArray = $multicasArray;
    }

    function getDestinatario() {
        return $this->destinatario;
    }

    function getTitle() {
        return $this->title;
    }

    function getBody() {
        return $this->body;
    }

    function setApp_token($app_token) {
        $this->app_token = $app_token;
    }

    function getImageUrl() {
        return $this->imageUrl;
    }

    function setImageUrl($imageUrl) {
        $this->imageUrl = $imageUrl;
    }

    function setDestinatario($destinatario, $id_usuario = null) {
        if ($id_usuario != null) {
            $this->idDestinatarios[] = $id_usuario;
        }
        $this->destinatario = $destinatario;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setBody($body) {
        $this->body = $body;
    }

    function getId_agendamento() {
        return $this->id_agendamento;
    }

    function setId_agendamento($id_agendamento) {
        $this->id_agendamento = $id_agendamento;
    }

    function getId_notificacao() {
        return $this->id_notificacao;
    }

    function getEnviado() {
        return $this->enviado;
    }

    function setId_notificacao($id_notificacao) {
        $this->id_notificacao = $id_notificacao;
    }

    function setEnviado($enviado) {
        $this->enviado = $enviado;
    }

    function send($enviado = true) {
        $parametros = new parametros();
        if ($parametros->getEnviarNotificacao() == 0) {
            return false;
        }

        $this->enviado = $enviado == false ? 0 : 1;
        $usuarioPDO = new UsuarioPDO();

        $pdo = conexao::getConexao();
        if ($this->id_notificacao == "") {
            $stmt = $pdo->prepare("insert into notificacao values (default , :title , :body , :imageUrl , :id_agendamento ,:urlDestino, :prioridade , :mensagemGeral , :dataHora , :enviado)");
            $hora = new DateTime();
            $stmt->bindValue(":title", $this->getTitle());
            $stmt->bindValue(":body", $this->getBody());
            $stmt->bindValue(":imageUrl", $this->getImageUrl());
            $stmt->bindValue(":urlDestino", $this->getUrlDestino());
            $stmt->bindValue(":id_agendamento", $this->getId_agendamento());
            $stmt->bindValue(":prioridade", $this->getPrioridade());
            $stmt->bindValue(":dataHora", $hora->format("Y-m-d H:i:s"));
            $stmt->bindValue(":enviado", ($this->enviado == 0 ? 0 : 1));
            $stmt->bindValue(":mensagemGeral", ($this->getDestinatario() == '/topics/dispositivos' && $this->multicasArray != 'undefined' ? 1 : 0));
            $stmt->execute();
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select * from notificacao where data = :dataHora and :body = body order by id_notificacao desc");
            $stmt->bindValue(":dataHora", $hora->format("Y-m-d H:i:s"));
            $stmt->bindValue(":body", $this->getBody());
            $stmt->execute();
            $linha = $stmt->fetch();
            $id_not = $linha['id_notificacao'];
        }

        $data = array('title' => $this->title,
            'body' => $this->body,
            'img_url' => $this->getImageUrl(),
            "url_destino" => $this->urlDestino,
            'id_agendamento' => $this->id_agendamento);

        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array('Authorization: key=' . $this->app_token, 'Content-Type: application/json');
        if ($this->multicasArray != "undefined") {
            $fields = array(
                'registration_ids' => $this->multicasArray,
                'data' => $data,
            );
            if ($this->id_notificacao == "") {
                foreach ($this->idDestinatarios as $arr) {
                    if ($arr != '') {
                        $pdo = conexao::getConexao();
                        $stmt = $pdo->prepare("insert into destinatarionotificacao values (default ," . $id_not . " , :id_usuario)");
                        $stmt->bindValue(":id_usuario", $arr);
                        $stmt->execute();
                    }
                }
            }
        } else {
            $fields = array(
                'to' => $this->destinatario,
                'data' => $data,
            );
            if ($this->id_notificacao == "") {
                if ($this->destinatario != ('/topics/dispositivos') && $this->destinatario != "") {
                    $usuario = new usuario($usuarioPDO->selectUsuarioToken($this->destinatario));
                    $pdo = conexao::getConexao();
                    $stmt = $pdo->prepare("insert into destinatarionotificacao values (default ," . $id_not . " , :id_usuario)");
                    $stmt->bindValue(":id_usuario", $usuario->getId_usuario());
                    $stmt->execute();
                }
            }
        }
        if ($this->enviado == 1) {
            $temp = json_encode($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $temp);
            curl_exec($ch);
            curl_close($ch);
        }
    }

}
