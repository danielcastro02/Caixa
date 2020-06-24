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

include_once __DIR__ . '/../Modelo/Notificacao.php';
include_once __DIR__ . '/../Controle/conexao.php';
include_once __DIR__ . '/../Controle/usuarioPDO.php';
include_once __DIR__ . '/../Modelo/Usuario.php';
include_once __DIR__ . '/../Modelo/Parametros.php';

class notificacaoPDO
{

    function novoUsuario(usuario $usuario)
    {
        $usuarioPDO = new UsuarioPDO();
        $notificacao = new Notificacao();
        $notificacao->setTitle("Novo usuário!");
        $notificacao->setBody("Novo usuário " . $usuario->getNome());
        $notificacao->setUrlDestino("/Tela/listagemUsuario.php");
        $notificacao->stmt2MulticastArray($usuarioPDO->selectUsuarioAdministrador('1'));
        $notificacao->send();
    }


    function notificaPersonalizada()
    {
        $notificacao = new Notificacao($_POST);
        if (isset($_POST['destinatarios'])) {

            foreach ($_POST['destinatarios'] as $destinatario) {
                echo $destinatario . "<br>";
                $usuarioPDO = new UsuarioPDO();
                $usuario = $usuarioPDO->selectUsuarioToken($destinatario);
                $notificacao->addToMulticasArray($destinatario, $usuario->getId_usuario());
            }
        }
        $notificacao->send();
        header('location: ../Tela/enviarNotificacao.php');
    }


    function selectNotificacaoUsuario($id_usuario)
    {
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select n.* from notificacao as n left outer join destinatarionotificacao as dn on dn.id_notificacao = n.id_notificacao where dn.id_usuario = :id_usuario or n.mensagemGeral = 1 order by data desc;");
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt;
    }

    function drowNotification(Notificacao $notificacao , $exibido = 0)
    {
        echo "
                <div class='row'>
                <div class='col s10 offset-s1 card'>
                <p class='bold'>" . $notificacao->getTitle() . "</p>
                <span>" . $notificacao->getBody() . "</span>
                <input name='last_notification' hidden class='last_notification' value='" . $notificacao->getId_notificacao() . "'>
                <div class='forToast' exibido = '".$exibido."'><span>" . $notificacao->getTitle() . "
                " . $notificacao->getBody() . "</span></div>
</div>
</div>
            ";
    }

    function getStorageNotifications()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $logado = new usuario(unserialize($_SESSION['logado']));
        session_write_close();
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from notificacao as n inner join destinatarionotificacao d on n.id_notificacao = d.id_notificacao where d.id_usuario = :id_usuario order by n.data desc limit 20");
        $stmt->bindValue(":id_usuario", $logado->getId_usuario());
        $stmt->execute();
        while ($linha = $stmt->fetch()) {
            $notificacao = new Notificacao($linha);
            $this->drowNotification($notificacao , 1);
        }
    }

    function getNotification(){
        set_time_limit(100);
        if (!isset($_SESSION)) {
            session_start();
        }
        $logado = new usuario(unserialize($_SESSION['logado']));
        session_write_close();
        $last_notification = $_GET['lastNotification'];
        $pdo = conexao::getConexao();
        $x = 0;
        while($x<60) {
            $stmt = $pdo->prepare("select * from notificacao as n inner join destinatarionotificacao d on n.id_notificacao = d.id_notificacao where d.id_usuario = :id_usuario and n.id_notificacao > :id_notificacao order by n.data desc limit 20");
            $stmt->bindValue(":id_usuario", $logado->getId_usuario());
            $stmt->bindValue(":id_notificacao", $last_notification);
            $stmt->execute();
            if($stmt->rowCount()>0) {
                while ($linha = $stmt->fetch()) {
                    $notificacao = new Notificacao($linha);
                    $this->drowNotification($notificacao);
                }
                break;
            }
            $x++;
            sleep(1);
        }
    }

}
