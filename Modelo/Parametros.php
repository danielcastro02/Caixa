<?php

class Parametros
{

    private $id_parametro = 0;
    private $nome_empresa = "markey";
    private $is_foto = 0;
    private $tema = "default.css";
    private $emailContato = "contato@markeyvip.com";
    private $hasAdm = 1;
    private $telefones = "(55) 99959-8414";
    private $logo = "";
    private $ruaNumero = "";
    private $cidade = "";
    private $estado = "";
    private $mp_token = "APP_USR-3350858051691068-091000-e5bb8aa8f4fc71b7e9003204396963c3-468060725";
    private $ativa_pagamento = 0;
    private $app_token = "AAAAW9yWcpU:APA91bGu9PcQ6iBvtNR0YUSOmLW2V6l0aYb-_uDyA36sgILxOrx0IOiGTzm2bE-KjzREdzu46vWbrMml5dlBBsbOylDxDdNqZo4glUn88_6HFdXbuXfeF7_Zto-32TcpfzdgTLGEy9up";
    private $envia_notificacao = 0;
    private $server;
    private $face_app_id = "923573528013985";
    private $face_app_secret = "7e74dd0ff62cb33ac67ce15cebd47438";
    private $link_app = "https://play.google.com/store/apps/details?id=markey.hotel";
    private $qr_app = "";
    private $active_chat = 0;
    private $confirma_email = 0;
    private $firebase_topic = "dispositivos";
    private $nome_db = "caixa";
    private $metodo_autenticacao = 1;
    private $index_img = "/Img/bg1.jpg";
    private $contas_publicas = 0;
    private $sms = 0;
    private $enviarNotificacao = 0;


    public function __construct()
    {
        try {
            error_reporting(0);
            $atributos = json_decode(file_get_contents(__DIR__ . "/parametros.json"));
            foreach ($atributos as $atributo => $valor) {
                if (isset($valor)) {
                    $this->$atributo = $valor;
                }
            }
            error_reporting(E_ALL);
        }catch (Exception $e){
            $this->save();
        }
        if ($_SERVER["HTTP_HOST"] == 'localhost') {
            $this->server = "https://" . gethostbyname(gethostbyaddr($_SERVER['REMOTE_ADDR']));
            $requestURI = $_SERVER['REQUEST_URI'];
            $arrRequest = explode("/", $requestURI);
            $this->server = $this->server . "/".strtolower($arrRequest[1]);
        } else {
            $this->server = "https://" . $_SERVER["HTTP_HOST"];
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


    public function getEnviarNotificacao(): int
    {
        return $this->enviarNotificacao;
    }

    public function setEnviarNitoficacao(int $enviarNotoficacao): void
    {
        $this->enviarNotificacao = $enviarNotoficacao;
    }

    public function getIndexImg(): string
    {
        return $this->index_img;
    }

    public function setIndexImg(string $index_img): void
    {
        $this->index_img = $index_img;
    }

    public function isContasPublicas(): bool
    {
        return $this->contas_publicas;
    }

    public function setContasPublicas(bool $contas_publicas): void
    {
        $this->contas_publicas = $contas_publicas;
    }



    public function save()
    {
        file_put_contents(__DIR__ . '/parametros.json', json_encode(get_object_vars($this)));
        file_put_contents(__DIR__ . '/../../adm.markeyvip.com/Parametros/'.$_SERVER["HTTP_HOST"].".json", json_encode(get_object_vars($this)));
    }

    public function getIdParametro(): int
    {
        return $this->id_parametro;
    }

    public function setIdParametro(int $id_parametro): void
    {
        $this->id_parametro = $id_parametro;
    }

    public function getNomeEmpresa(): string
    {
        return $this->nome_empresa;
    }

    public function setNomeEmpresa(string $nome_empresa): void
    {
        $this->nome_empresa = $nome_empresa;
    }

    public function getIsFoto(): int
    {
        return $this->is_foto;
    }

    public function setIsFoto(int $is_foto): void
    {
        $this->is_foto = $is_foto;
    }

    public function getTema(): string
    {
        return $this->tema;
    }

    public function setTema(string $tema): void
    {
        $this->tema = $tema;
    }

    public function getEmailContato(): string
    {
        return $this->emailContato;
    }

    public function setEmailContato(string $emailContato): void
    {
        $this->emailContato = $emailContato;
    }

    public function getHasAdm(): int
    {
        return $this->hasAdm;
    }

    public function setHasAdm(int $hasAdm): void
    {
        $this->hasAdm = $hasAdm;
    }

    public function getTelefones(): string
    {
        return $this->telefones;
    }

    public function setTelefones(string $telefones): void
    {
        $this->telefones = $telefones;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): void
    {
        $this->logo = $logo;
    }

    public function getRuaNumero(): string
    {
        return $this->ruaNumero;
    }

    public function setRuaNumero(string $ruaNumero): void
    {
        $this->ruaNumero = $ruaNumero;
    }

    public function getCidade(): string
    {
        return $this->cidade;
    }

    public function setCidade(string $cidade): void
    {
        $this->cidade = $cidade;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getMpToken(): string
    {
        return $this->mp_token;
    }

    public function setMpToken(string $mp_token): void
    {
        $this->mp_token = $mp_token;
    }

    public function getAtivaPagamento(): int
    {
        return $this->ativa_pagamento;
    }

    public function setAtivaPagamento(int $ativa_pagamento): void
    {
        $this->ativa_pagamento = $ativa_pagamento;
    }

    public function getAppToken(): string
    {
        return $this->app_token;
    }

    public function setAppToken(string $app_token): void
    {
        $this->app_token = $app_token;
    }

    public function getEnviaNotificacao(): int
    {
        return $this->envia_notificacao;
    }

    public function setEnviaNotificacao(int $envia_notificacao): void
    {
        $this->envia_notificacao = $envia_notificacao;
    }

    public function getServer(): string
    {
        return $this->server;
    }

    public function setServer(string $server): void
    {
        $this->server = $server;
    }

    public function getFaceAppId(): string
    {
        return $this->face_app_id;
    }

    public function setFaceAppId(string $face_app_id): void
    {
        $this->face_app_id = $face_app_id;
    }

    public function getFaceAppSecret(): string
    {
        return $this->face_app_secret;
    }

    public function setFaceAppSecret(string $face_app_secret): void
    {
        $this->face_app_secret = $face_app_secret;
    }

    public function getLinkApp(): string
    {
        return $this->link_app;
    }

    public function setLinkApp(string $link_app): void
    {
        $this->link_app = $link_app;
    }

    public function getQrApp(): string
    {
        return $this->qr_app;
    }

    public function setQrApp(string $qr_app): void
    {
        $this->qr_app = $qr_app;
    }

    public function getActiveChat(): int
    {
        return $this->active_chat;
    }

    public function setActiveChat(int $active_chat): void
    {
        $this->active_chat = $active_chat;
    }

    public function getConfirmaEmail(): int
    {
        return $this->confirma_email;
    }

    public function setConfirmaEmail(int $confirma_email): void
    {
        $this->confirma_email = $confirma_email;
    }

    public function getFirebaseTopic(): string
    {
        return $this->firebase_topic;
    }

    public function setFirebaseTopic(string $firebase_topic): void
    {
        $this->firebase_topic = $firebase_topic;
    }

    public function getNomeDb(): string
    {
        return $this->nome_db;
    }

    public function setNomeDb(string $nome_db): void
    {
        $this->nome_db = $nome_db;
    }

    public function getMetodoAutenticacao(): int
    {
        return $this->metodo_autenticacao;
    }

    public function setMetodoAutenticacao(int $metodo_autenticacao): void
    {
        $this->metodo_autenticacao = $metodo_autenticacao;
    }

    public function getSms(): int
    {
        return $this->sms;
    }

    public function setSms(int $sms): void
    {
        $this->sms = $sms;
    }

}
