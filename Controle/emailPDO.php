<?php

// Load Composer's autoloader

include_once __DIR__ . '/../Controle/conexao.php';
include_once __DIR__ . '/../Controle/usuarioPDO.php';
include_once __DIR__ . '/../Controle/PDOBase.php';
include_once __DIR__ . '/../Modelo/Usuario.php';
include_once __DIR__ . '/../Modelo/Email.php';
include_once __DIR__ . '/../Modelo/Parametros.php';
require_once __DIR__ . '/../vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class emailPDO extends PDOBase
{

    private $parametros;

    public function __construct()
    {
        $this->parametros = new parametros();
    }

    function usuarioDeletado()
    {
        $usuarioPDO = new UsuarioPDO();
        $remetente = $_POST['remetente'];
        $mensagem = $_POST['mensagem'];
        $id_usuario = $_POST['id_usuario'];
        $stmtUs = $usuarioPDO->selectUsuarioId_usuario($id_usuario);
        $userDeletado = new usuario($stmtUs->fetch());
        $conteudoHTML = "<p>O usuário " . $userDeletado->getNome() . ", CPF: " . $userDeletado->getCpfPontuado() . " Telefone: " . $userDeletado->getTelefoneMascarado() . " entrou em contato sobre seu usuário estar deletado, com a segunte mensagem:</p>"
            . "<p>" . $mensagem . "</p>";
        $email = new Email();
        $stmtUsusario = $usuarioPDO->selectUsuarioAdministrador('1');
        while ($linha = $stmtUsusario->fetch()) {
            $usuario = new usuario($linha);
            if ($usuario->getEmail() != "") {
                $email->addDestinatario($usuario->getEmail());
            }
        }
        $email->setAssunto("Usuário deletado!");
        $email->setMensagemHTML($conteudoHTML);
        $email->setEmailResposta($remetente);
        $email->enviar(true);
        $_SESSION['toast'][] = "Sua mensagem foi enviada, o administrador entrara em contato em breve!";
        header('location: ../index.php?msg=enviado');
    }

    function confirmaEmail($destinatario, $codigo = null, $id_usuario = null)
    {
        if (is_null($codigo)) {
            $codigo = mt_rand(1000, 99999);
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("insert into codigoconfirmacao values (default, :id_usuario , :codigo, 'email');");
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->bindValue(':codigo', $codigo);
            $stmt->execute();
        }
        $email = new Email();
        $server = $_SERVER['HTTP_HOST'];
        $server == 'localhost' ? $server = $server . '/MarkeyVip' : $server = $server;
        $conteudoHTML = htmlentities("Link de verificação:") . "<a href='http://" . $server . "/Controle/usuarioControle.php?function=confirmaEmail&codigo=" . $codigo . "'>CLIQUE AQUI!</a>";
        $conteudonaoHTML = "Link de verificação: http://" . $server . "/Controle/usuarioControle.php?function=confirmaEmail&codigo=" . $codigo;
        $email->setAssunto(("Confirmação de Email"));
        $email->setTituloModeP(htmlentities("Seu código de confirmação!"));
        $email->setMensagemModeP($conteudoHTML);
        $email->setMensagemNaoHTML($conteudonaoHTML);
        $email->setEmailResposta($this->parametros->getEmailContato());
        try {
            $email->addDestinatario($destinatario);
        } catch (Exception $e) {
            $this->addToast("E-mail Inválido!");
            header("location: ../Tela/perfil.php");
            exit(0);
        }
        return $email->enviar(true, true);
    }

    function recuperaSenha(usuario $usuario)
    {

        $codigo = mt_rand(1000, 99999);
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into codigoconfirmacao values (default, :id_usuario , :codigo, 'recuperaSenha');");
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        $stmt->bindValue(':codigo', $codigo);
        $stmt->execute();

        $email = new Email();
        $server = $_SERVER['HTTP_HOST'];
        $server == 'localhost' ? $server = $server . '/MarkeyVip' : $server = $server;
        $conteudoHTML = "<head><metacharset='UTF-8'></head>"
            . "Link de recuperação: <a href='https://" . $server . "/Tela/redefineSenha.php?codigo=" . $codigo . "&email=".$usuario->getEmail()."'>CLIQUE AQUI!</a>";
        $email->setMensagemModeP($conteudoHTML);
        $email->setTituloModeP("Olá");
        $email->addDestinatario($usuario->getEmail());
        $email->setAssunto("Recuperação de Conta");
        $email->enviar(true, true);
    }

    function completaCadastro(usuario $usuario)
    {

        $codigo = mt_rand(1000, 99999);
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into codigoconfirmacao values (default, :id_usuario , :codigo, 'completa');");
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        $stmt->bindValue(':codigo', $codigo);
        $stmt->execute();

        $server = $_SERVER['HTTP_HOST'];
        $server == 'localhost' ? $server = $server . '/MarkeyVip' : $server = $server;
        $email = new Email();
        $email->setAssunto("Completar cadastro");
        $email->addDestinatario($usuario->getEmail());
        $conteudoHTML = "
            <p>Olá, esse e-mail foi cadastrado em nosso sistema.</p>
            <p>Se você autorizou esse cadastro, por favor ".htmlentities("Link para completar cadastro:") . ".<a href='http://". $server ."/Tela/completaCadastro.php?codigo=".$codigo."'>clique aqui</a> para completar seu cadastro</p>
        ";
        $email->setTituloModeP("Olá");
        $email->setMensagemModeP($conteudoHTML);
        $email->enviar(false, true);
    }
}
