<?php

if (!isset($_SESSION)) {
    session_start();
}

include_once __DIR__ . '/../Controle/conexao.php';
include_once __DIR__ . '/../Controle/emailPDO.php';
include_once __DIR__ . '/../Controle/codigoConfirmacaoPDO.php';
include_once __DIR__ . '/../Controle/notificacaoPDO.php';
include_once __DIR__ . '/../Controle/PDOBase.php';
include_once __DIR__ . '/../Modelo/Usuario.php';
include_once __DIR__ . '/../Modelo/Parametros.php';
include_once __DIR__ . '/../Modelo/Notificacao.php';

class UsuarioPDO extends PDOBase
{
    /* inserir */

    function inserirUsuarioAdm()
    {
        $parametros = new parametros();
        $usuario = new usuario($_POST);
        $usuario->setSenha('');
        $usuario->setCpf("");
        if ($parametros->getMetodoAutenticacao() == 1) {
            $usuario->setTelefone("");
        } else {
            $usuario->setEmail("");
        }
        $usuario->setData_nasc('');
        $usuario->setPre_cadastro(1);
        if ($this->inserirUsuarioParametro($usuario)) {
            $_SESSION['toast'][] = "Novo usuário cadastrado";
            header('location: ../Tela/listagemUsuario.php');
        } else {
            header('location: ../Tela/erroInterno.php');
        }
    }

    function selectUsuarioTurma($id_turma){
        $pdo =conexao::getConexao();
        $stmt = $pdo->prepare("select * from usuario where id_usuario in (select id_usuario from matricula where id_turma = :id_turma)");
        $stmt->bindValue(":id_turma" , $id_turma);
        $stmt->execute();
        if($stmt->rowCount()>0){
            return $stmt;
        }else{
            return false;
        }
    }

    function inserirUsuarioCompletaCadastro()
    {
        $usuario = new usuario($_POST);

        if (filesize($_FILES['imagem']['tmp_name']) > 0) {
            if (filesize($_FILES['imagem']['tmp_name']) > 15000000) {
                $_SESSION['toast'][] = "O tamanho máximo de arquivo é de 15MB";
                header("location: ../Tela/completaCadastro.php?id_usuario=" . $usuario->getId_usuario());
            } else {
                $nome_imagem = hash_file('md5', $_FILES['imagem']['tmp_name']);
                $ext = explode('.', $_FILES['imagem']['name']);
                $extensao = "." . $ext[(count($ext) - 1)];
                $extensao = strtolower($extensao);
                file_put_contents('./logodotipodafoto', $extensao);
                switch ($extensao) {
                    case '.jfif':
                    case '.jpeg':
                    case '.jpg':
                        imagewebp(imagecreatefromjpeg($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', 45);
                        break;
                    case '.svg':
                        move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.svg');
                        break;
                    case '.png':
                        $img = imagecreatefrompng($_FILES['imagem']['tmp_name']);
                        imagepalettetotruecolor($img);
                        imagewebp($img, __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', 45);
                        break;
                    case '.webp':
                        imagewebp(imagecreatefromwebp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', 45);
                        break;
                    case '.bmp':
                        imagewebp(imagecreatefromwbmp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', 45);
                        break;
                }
                $usuario->setFoto('Img/Perfil/' . $nome_imagem . ($extensao == '.svg' ? ".svg" : ".webp"));
            }
        } else {
            $usuario->setFoto('Img/Perfil/default.png');
        }
        $parametros = new parametros();
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("update usuario set nome = :nome, senha = :senha, cpf = :cpf, email = :email, telefone = :telefone, data_nasc = :data_nasc, foto = :foto, email_confirmado = 1, telefone_confirmado = :telefone_confirmado, administrador = 0, ativo = 1, pre_cadastro = 0 where id_usuario = :id_usuario;");
        $stmt->bindValue(":nome", $usuario->getNome());
        $stmt->bindValue(":senha", md5($usuario->getSenha()));
        $stmt->bindValue(":cpf", $usuario->getCpf());
        $stmt->bindValue(":email", $usuario->getEmail());
        $stmt->bindValue(":telefone", $usuario->getTelefone());
        $stmt->bindValue(":data_nasc", $usuario->getData_nasc());
        $stmt->bindValue(":foto", $usuario->getFoto());
        $stmt->bindValue(":telefone_confirmado", $parametros->getSms() == 1 ? 0 : 1);
        $stmt->bindValue(":id_usuario", $usuario->getId_usuario());
        if ($stmt->execute()) {
            $_SESSION['toast'][] = "Seu cadastro foi completado com sucesso!";
            echo $parametros->getSms();
            if ($parametros->getSms() == 0) {
                $_SESSION['logado'] = serialize($usuario);
                header("Location: ../index.php");
            } else {
                $this->enviaSMS($usuario->getId_usuario(), $usuario->getTelefone());
                header("Location: ../Tela/codigoSMS.php");
            }
        }

    }

    function pesquisaMatricula($pesquisa){
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from usuario where ativo = 1 and deletado = 0 and (nome like :pesquisa or email like :pesquisa or telefone like :pesquisa)");
        $pesquisa = "%".$pesquisa."%";
        $stmt->bindValue(":pesquisa" , $pesquisa);
        $stmt->bindValue(":pesquisa" , $pesquisa);
        $stmt->bindValue(":pesquisa" , $pesquisa);
        $stmt->execute();
        if($stmt->rowCount()>0){
            return $stmt;
        }else{
            return false;
        }
    }

    function inserirUsuario()
    {
        $chave = "6LdSGcIUAAAAAGaul6g_0TN_7iBJ4dmHNh8Eul_D";
        $responseKey = $_POST['g-recaptcha-response'];
        $userIP = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$chave&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $json = json_decode($response);
        if ($json->success) {
            $usuario = new usuario($_POST);
            $parametros = new parametros();
            if ($usuario->getNome() == "" || $usuario->getNome() == null) {
                $this->addToast("Você precisa colocar seu nome!");
                header('location: ../Tela/registroUsuario.php');
                exit();
            }
            if($parametros->getMetodoAutenticacao()==1) {
                if ($usuario->getEmail() == "" || $usuario->getEmail() == null) {
                    $this->addToast("Você precisa colocar seu E-mail!");
                    header('location: ../Tela/registroUsuario.php');
                    exit();
                }
            }else{
                if ($usuario->getTelefone() == "" || $usuario->getTelefone() == null) {
                    $this->addToast("Você precisa colocar seu Telefone!");
                    header('location: ../Tela/registroUsuario.php');
                    exit();
                }
            }
            if ($_POST['senha1'] == $_POST['senha2']) {
                $senhamd5 = md5($_POST['senha1']);
                $con = new conexao();
                $pdo = $con->getConexao();

                //Caso o usuario ja tenha sido cadastrado ele vai ter que completar o cadastro
                if ($this->verificaPreCadastroRegistro($usuario)) {
                    header("Location: ../Tela/completaPorEmail.php");
                    exit();
                }

                $selectCpf = $this->selectUsuarioCpf($usuario->getCpf());
                if ($selectCpf && $usuario->getCpf() != '') {
                    if ($selectCpf->rowCount() > 0) {
                        header('location: ../Tela/dadosJaCadastrados.php?msg=cpf');
                        exit();
                    }
                }
                if ($parametros->getMetodoAutenticacao() == 1) {
                    $selectEmail = $this->selectUsuarioEmail($usuario->getEmail());
                    if ($selectEmail && $usuario->getEmail() != '') {
                        if ($selectEmail->rowCount() > 0) {
                            $usuario = new usuario($selectEmail->fetch());
                            $_SESSION['credencial'] = $usuario->getEmail();
                            header('location: ../Tela/dadosJaCadastrados.php?msg=email');
                            exit();
                        }
                    }
                } else {
                    $selectTelefone = $this->selectUsuarioTelefone($usuario->getTelefone());
                    if ($selectTelefone) {
                        if ($selectTelefone->rowCount() > 0 && $usuario->getTelefone() != '') {
                            $usuario = new usuario($selectTelefone->fetch());
                            $_SESSION['credencial'] = $usuario->getTelefone();
                            header('location: ../Tela/dadosJaCadastrados.php?msg=telefone');
                            exit();
                        }
                    }
                }
                $stmt = $pdo->prepare('insert into usuario values(default , :nome , :senha , :cpf , :email , :telefone , :data_nasc , "Img/Perfil/default.png" , :token,default, :email_confirmado, :telefone_confirmado , 0, :ativo , 0 , "", 0 , 0);');
                $stmt->bindValue(':nome', $usuario->getNome());
                $stmt->bindValue(':senha', $senhamd5);
                $stmt->bindValue(':cpf', $usuario->getCpf());
                $stmt->bindValue(':email', $usuario->getEmail());
                $stmt->bindValue(':telefone', "" . $usuario->getTelefone());

                if ($parametros->getConfirmaEmail() == 1) {
                    $stmt->bindValue(":ativo", 0);
                    $stmt->bindValue(":email_confirmado", 0);
                } else {
                    $stmt->bindValue(":ativo", 1);
                    $stmt->bindValue(":email_confirmado", 1);
                }

                if ($parametros->getSms() == 1) {
                    $stmt->bindValue(':ativo', 0);
                    $stmt->bindValue(':telefone_confirmado', 0);
                } else {
                    $stmt->bindValue(':ativo', 1);
                    $stmt->bindValue(':telefone_confirmado', 1);
                }


                if (isset($_POST['token'])) {
                    $stmt->bindValue(":token", $usuario->getToken());
                } else {
                    $stmt->bindValue(":token", "");
                }
                $stmt->bindValue(':data_nasc', $usuario->getData_banco());

                if ($stmt->execute()) {
                    //                $this->enviaWats($usuario);
                    $notificacaoPDO = new notificacaoPDO();
                    if ($parametros->getMetodoAutenticacao() == 1) {
                        $usuario = $this->selectUsuarioEmail($usuario->getEmail());
                    } else {
                        $usuario = $this->selectUsuarioTelefone($usuario->getTelefone());
                    }
                    $usuario = new usuario($usuario->fetch());
                    $notificacaoPDO->novoUsuario($usuario);
                    //                $_SESSION['id_usuario'] = $usuario->getId_usuario();
                    if ($parametros->getSms() == 1 && $parametros->getMetodoAutenticacao() == 2) {
                        $this->enviaSMS($usuario->getId_usuario(), $usuario->getTelefone());
                        header('location: ../Tela/codigoSMS.php', TRUE);
                    } else if ($parametros->getConfirmaEmail() == 1 && $parametros->getMetodoAutenticacao() == 1) {
                        $emailPDO = new emailPDO();
                        $emailPDO->confirmaEmail($usuario->getEmail(), null, $usuario->getId_usuario());
                        header('location: ../Tela/codigoEmail.php', TRUE);
                    } else {
                        $_SESSION['logado'] = serialize($usuario);
                        echo $parametros->getConfirmaEmail();
//                        header('location: ../index.php');
                    }
                } else {
                    header('location: ../index.php?msg=usuarioErroInsert');
                }
            } else {
                header('location: ../Tela/registroUsuario.php?msg=senhaerrada');
            }
        } else {
            header('location: ../Tela/registroUsuario.php');
            $_SESSION['toast'][] = "Marque a opção de não ser um robo";
        }
    }

    function verificaPreCadastroRegistro(usuario $usuario)
    {
        $pdo = conexao::getConexao();
        $parametros = new parametros();
        if ($parametros->getMetodoAutenticacao() == 1) {
            $stmt = $pdo->prepare("select * from usuario where email = :email and pre_cadastro = 1");
            $stmt->bindValue(":email", $usuario->getEmail());
        } else {
            $stmt = $pdo->prepare("select * from usuario where telefone = :telefone and pre_cadastro = 1");
            $stmt->bindValue(":telefone", $usuario->getTelefone());
        }
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function eliminaToken()
    {
        $pdo = conexao::getConexao();
        $logado = new usuario(unserialize($_SESSION['logado']));
        $stmt = $pdo->prepare("update usuario set token = '' where id_usuario = :id_usuario;");
        $stmt->bindValue(":id_usuario", $logado->getId_usuario());
        $stmt->execute();
        session_destroy();
        setcookie("user", '', time() + 1, '/');
        setcookie("hashValidade", '', time() + 1, '/');
    }

    function recuperaSenha()
    {
        $pesquisa = $_POST['usuario'];
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare("select id_usuario, email from usuario where email like :email");
        $stmt->bindValue(":email", $pesquisa);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $usuario = new usuario($stmt->fetch());
            $emailPDO = new emailPDO();
            $emailPDO->recuperaSenha($usuario);
            header("location: ../Tela/codigoEmail.php?motivo=recuperacao");
        } else {
            header("location: ../Tela/recuperaSenha.php?msg=erro");
        }
    }

    function recuperaSenhaAPI()
    {
        $pesquisa = $_POST['usuario'];
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare("select id_usuario, email from usuario where email like :email");
        $stmt->bindValue(":email", $pesquisa);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $usuario = new usuario($stmt->fetch());
            $emailPDO = new emailPDO();
            $emailPDO->recuperaSenha($usuario);
            echo('true');
        } else {
            echo('false');
        }
    }

    function getCpfId()
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select cpf, data_nasc, email from usuario where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $_GET['id_usuario']);
        $stmt->execute();
        $linha = $stmt->fetch();
        $usuario = new usuario($linha);
        echo $usuario->getCpfPontuado() . ";" . $usuario->getData_nascBarras() . ';' . $usuario->getEmail();
    }

    function redefineSenha()
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        if ($_POST['senha1'] == $_POST['senha2']) {
            $novaSenha = md5($_POST['senha1']);
            $codigoConfirmacao = new codigoConfirmacaoPDO();
            $id_usuario = $codigoConfirmacao->verificaCodigoRecuperaSenha($_POST['codigo'], $_POST['email']);
            if ($id_usuario) {
                $stmt = $pdo->prepare("update usuario set senha = :senha where id_usuario = :id_usuario;");
                $stmt->bindValue(":senha", $novaSenha);
                $stmt->bindValue(":id_usuario", $id_usuario);
                if ($stmt->execute()) {
                    $_SESSION['toast'][] = "Senha redefinida!";
                    $usuario = new usuario($this->selectUsuarioId_usuario($id_usuario)->fetch());
                    $_SESSION['logado'] = serialize($usuario);
                    header('location: ../Tela/login.php');
                } else {
                    $_SESSION['toast'][] = "Troca de senha negada!";
                    $_SESSION['toast'][] = "Tente recupera-la pelo email novamente";
                    header('location: ../Tela/login.php?msg=trocaNegada');
                }
            } else {
                $_SESSION['toast'][] = "Troca de senha negada!";
                $_SESSION['toast'][] = "Tente recupera-la pelo email novamente";
                header('location: ../Tela/login.php');
            }
        } else {
            $_SESSION['toast'][] = "Senhas não coincidem!!";
            header('location: ../Tela/perfil.php?msg=senhasErradas');
        }
    }

    function primeiraSenha()
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($_POST['senha1'] == $_POST['senha2']) {
            $novaSenha = md5($_POST['senha1']);
            $stmt = $pdo->prepare("update usuario set senha = :senha , pre_cadastro = 0 where id_usuario = :id_usuario;");
            $stmt->bindValue(":senha", $novaSenha);
            $stmt->bindValue(":id_usuario", $_SESSION['id_usuario_correcao']);
            if ($stmt->execute()) {
                include_once './trocasenhaPDO.php';
                $trocaSenhaPDO = new TrocasenhaPDO();
                $trocaSenhaPDO->deleteTrocasenha($_SESSION['id_usuario_correcao']);
                $_SESSION['toast'][] = "Senha definida!";
                header('location: ../Tela/login.php');
                unset($_SESSION['id_usuario_correcao']);
            } else {
                $_SESSION['toast'][] = "Troca de senha negada!";
                header('location: ../Tela/login.php?msg=trocaNegada');
            }
        } else {
            $_SESSION['toast'][] = "Senhas não coincidem!";
            header('location: ../Tela/perfil.php?msg=senhasErradas');
        }
    }

    function verificaTelefone()
    {
        $usuario = new usuario($_POST);
        $usuario->setTelefone(str_replace("(", "", $usuario->getTelefone()));
        $usuario->setTelefone(str_replace(" ", "", $usuario->getTelefone()));
        $usuario->setTelefone(str_replace(")", "", $usuario->getTelefone()));
        $usuario->setTelefone(str_replace("-", "", $usuario->getTelefone()));
        $selectTelefone = $this->selectUsuarioTelefone($usuario->getTelefone());
        if ($selectTelefone) {
            if ($selectTelefone->rowCount() > 0 && $usuario->getTelefone() != '') {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            echo 'erro';
        }
    }

    function verificaEmail()
    {
        $oCara = $this->selectUsuarioId_usuario($_SESSION['id_usuario']);
        $oCara = new usuario($oCara->fetch());
        $selectTelefone = $this->selectUsuarioEmail($_POST['email']);
        if ($selectTelefone) {
            if ($selectTelefone->rowCount() > 0 && $_POST['email'] != '' && $_POST['email'] != $oCara->getEmail()) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            echo 'erro';
        }
    }

    function inserirUsuarioParametro(usuario $usuario, $senha1 = '', $senha2 = '')
    {
        $notificacaoPDO = new notificacaoPDO();

        if ($usuario->getNome() == "" || $usuario->getNome() == null) {
            $this->addToast("Você precisa colocar o nome de seu cliente!");
            header('location: ../Tela/cadastroUsuarioAdm.php');
            exit();
        }

        $selectCpf = $this->selectUsuarioCpf($usuario->getCpf());
        if ($selectCpf && $usuario->getCpf() != '') {
            if ($selectCpf->rowCount() > 0) {
                header('location: ../Tela/dadosJaCadastrados.php?msg=cpf');
                exit();
            }
        }
        $parametros = new parametros();
        if ($parametros->getMetodoAutenticacao() == 1) {
            $selectEmail = $this->selectUsuarioEmail($usuario->getEmail());
            if ($selectEmail && $usuario->getEmail() != '') {
                if ($selectEmail->rowCount() > 0) {
                    $usuario = new usuario($selectEmail->fetch());
                    $_SESSION['credencial'] = $usuario->getEmail();
                    header('location: ../Tela/dadosJaCadastrados.php?msg=email');
                    exit();
                }
            }
        } else {
            $selectTelefone = $this->selectUsuarioTelefone($usuario->getTelefone());
            if ($selectTelefone) {
                if ($selectTelefone->rowCount() > 0 && $usuario->getTelefone() != '') {
                    $usuario = new usuario($selectTelefone->fetch());
                    $_SESSION['credencial'] = $usuario->getTelefone();
                    header('location: ../Tela/dadosJaCadastrados.php?msg=telefone');
                    exit();
                }
            }
        }
        if ($senha1 == $senha2) {
            $senhamd5 = md5($senha1);
            $pdo = conexao::getConexao();

            $stmt = $pdo->prepare('insert into usuario values(default , :nome , :senha , :cpf , :email , :telefone , :data_nasc , "Img/Perfil/default.png" , "" ,default ,:email_confirmado, 1, 0, 1, 0, "", 0, :preCadastro);');

            $stmt->bindValue(':nome', $usuario->getNome());

            $stmt->bindValue(':senha', $senhamd5);
            $stmt->bindValue(':preCadastro', 1);
//            $stmt->bindValue(':preCadastro', 0);

            $stmt->bindValue(':cpf', "" . $usuario->getCpf());

            $stmt->bindValue(':email', $usuario->getEmail());

            $stmt->bindValue(':telefone', "" . $usuario->getTelefone());

            $stmt->bindValue(':data_nasc', '2019-02-15');

            if ($parametros->getMetodoAutenticacao() == 1) {
                $stmt->bindValue(':email_confirmado', 0);
            } else {
                $stmt->bindValue(':email_confirmado', 1);
            }

            if ($stmt->execute()) {
//                $this->enviaSMS($usuario);
//                $this->enviaWats($usuario);
                $notificacaoPDO->novoUsuario($usuario);
                if ($parametros->getMetodoAutenticacao() == 1) {
                    $usuario = $this->selectUsuarioEmail($usuario->getEmail());
                } else {
                    $usuario = $this->selectUsuarioTelefone($usuario->getTelefone());
                }
                $usuario = new usuario($usuario->fetch());
                if ($parametros->getMetodoAutenticacao() == 1) {
                    $emailPDO = new emailPDO();
                    $emailPDO->completaCadastro($usuario);
                } else {
                    //TODO Colocar algo pro sms caso o sms esteja ativo
                }
                return $usuario->getId_usuario();
            } else {
                return false;
            }
        } else {
            return "senhas";
        }
    }

    public function reenviaSMS()
    {
        $usuario = $this->selectUsuarioId_usuario($_GET['id_usuario']);
        $usuario = new usuario($usuario->fetch());
        $this->enviaSMS($usuario->getId_usuario(), $usuario->getTelefone(), false);
        header('location: ../Tela/codigoSMS.php');
    }

    public function reenviaEmail()
    {
        $usuario = $this->selectUsuarioId_usuario($_SESSION['id_usuario']);
        unset($_SESSION['id_usuario']);
        $usuario = new usuario($usuario->fetch());
        $emailPDO = new emailPDO();
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select codigo from codigoconfirmacao where id_usuario = :id_usuario and tipo = 'email'");
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        $stmt->execute();
        $linha = $stmt->fetch();
        $codigo = $linha[0];
        $emailPDO->confirmaEmail($usuario->getEmail(), $codigo, $usuario->getId_usuario());
        header('location: ../Tela/codigoEmail.php');
    }

    function codigoConfirmaRecuperaSenha()
    {
        $codigo = $_POST['codigo'];
        $id_usuario = $_SESSION['id_usuario'];
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("Select id_usuario from codigoconfirmacao where codigo = :codigo and tipo = 'recuperaSenha' and id_usuario = :id_usuario;");
        $stmt->bindValue(":codigo", $codigo);
        $stmt->bindValue(":id_usuario", $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $usuario = $this->selectUsuarioId_usuario($id_usuario);
            $usuario = new usuario($usuario->fetch());
            header("location: ../Tela/redefineSenha.php?codigo=" . $codigo . "&email=" . $usuario->getEmail());
        }
    }

    function recuperaSenhaApp()
    {
        $pesquisa = $_POST['usuario'];
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare("select id_usuario, token from usuario where email like :email");
        $stmt->bindValue(":email", $pesquisa);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $usuario = new usuario($stmt->fetch());
            $codigo = mt_rand(1000, 99999);
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("insert into codigoconfirmacao values (default, :id_usuario , :codigo, 'recuperaSenha');");
            $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
            $stmt->bindValue(':codigo', $codigo);
            $stmt->execute();
            $notificacao = new Notificacao();
            $notificacao->setDestinatario($usuario->getToken(), $usuario->getId_usuario());
            $notificacao->setTitle("Seu códio!");
            $notificacao->setBody($codigo . " Se você não solicitou este código entre em contato com contato@markeyvip.com.");
            $notificacao->send(true);
            $_SESSION['id_usuario'] = $usuario->getId_usuario();
            $this->addToast("Verifique as notificações do seu app!");
            header("location: ../Tela/codigoApp.php");
        } else {
            $this->addToast("Nenhum aplicativo esta associado a esta conta!");
            header("location: ../Tela/recuperaSenha.php?msg=erro");
        }
    }


    public
    function enviaSMS($id_usuario, $telefone, bool $novoCodigo = true)
    {
        $user = new usuario($_POST);
        $usuario = $this->selectUsuarioId_usuario($id_usuario);
        $usuario = new usuario($usuario->fetch());
        $telefone = $usuario->getTelefone();
        $parametros = new parametros();
        if (strlen($telefone) != 11) {
            header("location: ../Tela/erroInterno.php?a");
            exit(0);
        }
        if ($novoCodigo) {
            $codigo = mt_rand(1000, 99999);
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("insert into codigoconfirmacao values (default, :id_usuario , :codigo, 'telefone');");
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->bindValue(':codigo', $codigo);
        } else {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select codigo from codigoconfirmacao where id_usuario = :id_usuario and tipo = 'telefone';");
            $stmt->bindValue(':id_usuario', $id_usuario);
        }
        if (!$stmt->execute()) {
            header("location: ../Tela/erroInterno.php?b");
            exit(0);
        } else {
            if (!$novoCodigo) {
                $codigo = $stmt->fetch();
                $codigo = $codigo[0];
            }
            $parametros = new parametros();
            $msgEncoded = urlencode("Olá, Seja bem vindo! " . $parametros->getNomeEmpresa() . " aqui, use o código: " . $codigo);
            $url = 'https://www.facilitamovel.com.br/api/simpleSend.ft?user=dcastro&password=Class.7ufo&destinatario=' . $telefone . '&msg=' . $msgEncoded;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            if ($parametros->getSms() == 1) {
                $data = curl_exec($ch);
            } else {

            }
            curl_close($ch);
        }
    }

    /* inserir */

    function selectUsuarioHasToken()
    {
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from usuario where token != '' and token != 'null' and deletado = 0");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function confirmaCadastro()
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set ativo = 1, telefone_confirmado = 1 where id_usuario in ('
            . 'select id_usuario '
            . 'from codigoconfirmacao '
            . 'where codigo = :codigo) ;');
        $stmt->bindValue(":codigo", $_POST['codigo']);
        $stmt->execute();
        $stmt = $pdo->prepare("select * from usuario where id_usuario in (select id_usuario from codigoconfirmacao where codigo = :codigo);");
        $stmt->bindValue(":codigo", $_POST['codigo']);
        $stmt->execute();
        $usuario = new usuario($stmt->fetch());
        $stmtDelete = $pdo->prepare('delete from codigoconfirmacao where codigo = :codigo;');
        $stmtDelete->bindValue(":codigo", $_POST['codigo']);
        if ($stmtDelete->execute()) {
            if (isset($_GET['semSenha'])) {
                $stmt = $pdo->prepare("update usuario set pre_cadastro = 0 where id_usuario = :id_usuario;");
                $stmtDelete->bindValue(":id_usuario", $usuario->getId_usuario());
                $stmt->execute();
                header("location: ../Tela/redefineSenha.php?primeiraSenha=1&codigo=" . $usuario->getId_usuario());
            } else {
                header('location: ../Tela/login.php');
            }
        } else {
            header("location: ../Tela/erroInterno.php?c");
        }
    }

    function insertFacebook($us)
    {
        $this->faceLogin($us);
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into usuario values (default , :nome , '' , '' , :email , '' , '' , :foto ,'' , default , 1 , 1 , 0 , 1 , 0, :faceId , 1 ,0)");
        $stmt->bindValue(':nome', $us['name']);
        $stmt->bindValue(":email", $us['email']);
        $stmt->bindValue(":foto", $us['picture']['url']);
        $stmt->bindValue(":faceId", $us['id']);
        $stmt->execute();
        $notificacaoPDO = new notificacaoPDO();
        $usuario = new usuario();
        $usuario->setNome($us['name']);
        $notificacaoPDO->novoUsuario($usuario);
        $this->faceLogin($us);
    }

    function faceLogin($us)
    {
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from usuario where facebook_id = :id");
        $stmt->bindValue(":id", $us['id']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $usuario = new usuario($stmt->fetch());
            if ($usuario->getIs_foto_url() == 1) {
                $stmt = $pdo->prepare("update usuario set  foto = :foto where facebook_id = :id");
                $stmt->bindValue(":foto", $us['picture']['url']);
                $stmt->bindValue(":id", $us['id']);
                $stmt->execute();
            }
            $_SESSION['logado'] = serialize($usuario);
            header("location: ../index.php");
            exit();
        } else {
            echo "erro";
            return false;

        }
    }

    public
    function confirmaEmail()
    {
        $cod = $_GET['codigo'];
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set ativo = 1 , email_confirmado = 1 where id_usuario in (select id_usuario from codigoconfirmacao where codigo = :codigo) ;');
        $stmt->bindValue(":codigo", $cod);
        if ($stmt->execute()) {
            $stmtDelete = $pdo->prepare('delete from codigoconfirmacao where codigo = :codigo;');
            $stmtDelete->bindValue(":codigo", $cod);
            if ($stmtDelete->execute()) {
                $_SESSION['toast'][] = "Seu email foi confirmado!";
                $_SESSION['toast'][] = "Entre para continuar...";
                header('location: ../Tela/login.php');
            } else {
                header('location: ../Tela/erroInterno.php');
            }
        } else {
            header('location: ../Tela/erroInterno.php?msg=Eroo');
        }
    }

    public
    function updateEmail()
    {
        $usuario = new usuario($_POST);
        $usuario->setId_usuario($_SESSION['id_usuario']);
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set email = :email , email_confirmado = 0 where id_usuario = :id_usuario ;');
        $stmt->bindValue(":email", $usuario->getEmail());
        $stmt->bindValue(":id_usuario", $usuario->getId_usuario());
        $stmt->execute();
        $codigo = mt_rand(1000, 99999);
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into codigoconfirmacao values (default, :id_usuario , :codigo , 'email');");
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        $stmt->bindValue(':codigo', $codigo);
        if (!$stmt->execute()) {
            header("location: ../Tela/erroInterno.php?insertCodigo");
            exit(0);
        } else {
            $emailPDO = new emailPDO();
            $emailPDO->confirmaEmail($usuario->getEmail(), $codigo);
            header('location: ../Tela/codigoEmail.php');
        }
    }

    public
    function updateTelefone()
    {
        $usuario = new usuario($_POST);
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set telefone = :telefone , telefone_confirmado = 0 where id_usuario = :id_usuario ;');
        $stmt->bindValue(":telefone", $usuario->getTelefone());
        $stmt->bindValue(":id_usuario", $usuario->getId_usuario());
        $stmt->execute();
        $codigo = mt_rand(1000, 99999);
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into codigoconfirmacao values (default, :id_usuario , :codigo , 'telefone');");
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        $stmt->bindValue(':codigo', $codigo);
        if (!$stmt->execute()) {
            header("location: ../Tela/erroInterno.php?insertCodigo");
            exit(0);
        } else {
            $this->enviaSMS($usuario->getId_usuario(), $usuario->getTelefone(), false);
            header('location: ../Tela/codigoSMS.php');
        }
    }

    public
    function selectUsuario()
    {

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario order by nome;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioId_usuario($id_usuario)
    {

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioNome($nome)
    {
        $nome = "%" . $nome . "%";
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where nome like :nome and deletado = 0;');
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function pesquisaListagem($nome)
    {
        $nome = "%" . $nome . "%";
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where (nome like :nome or telefone like :telefone or email like :email) and deletado = 0 ORDER BY nome;');
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':telefone', $nome);
        $stmt->bindValue(':email', $nome);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioSenha($senha)
    {

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where senha = :senha;');
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioCpf($cpf)
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where cpf = :cpf;');
        $stmt->bindValue(':cpf', $cpf);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioEmail($email)
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where email = :email;');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioTelefone($telefone)
    {

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where telefone = :telefone;');
        $stmt->bindValue(':telefone', $telefone);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectNome($id_usuario)
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select nome from usuario where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        while ($linha = $stmt->fetch()) {
            $usuario = new usuario($linha);
        }
        return $usuario->getNome();
    }

    public
    function selectUsuarioDdata_nasc($ddata_nasc)
    {

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where data_nasc = :ddata_nasc;');
        $stmt->bindValue(':ddata_nasc', $ddata_nasc);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioFoto($foto)
    {

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where foto = :foto;');
        $stmt->bindValue(':foto', $foto);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioToken($token): usuario
    {

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where token = :foto;');
        $stmt->bindValue(':foto', $token);
        $stmt->execute();
        return new usuario($stmt->fetch());
    }

    public
    function selectUsuarioAdministrador($administrador)
    {

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where administrador = :administrador or administrador = 2;');
        $stmt->bindValue(':administrador', $administrador);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }


    public
    function selectUsuarioAtivo($ativo)
    {

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where ativo = :ativo;');
        $stmt->bindValue(':ativo', $ativo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function updateSenha()
    {
        $logado = $this->getLogado();
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where id_usuario = :id_usuario');
        $stmt->bindValue(':id_usuario', $logado->getId_usuario());
        $stmt->execute();
        $logado = new usuario($stmt->fetch());
        if ($_POST['senha1'] == $_POST['senha2']) {
            $novaSenha = md5($_POST['senha1']);
            if (md5($_POST['oldSenha']) == $logado->getSenha() || ($_POST['oldSenha'] == "" && $logado->getSenha() == "")) {
                $stmt = $pdo->prepare("update usuario set senha = :senha where id_usuario = :id_usuario;");
                $stmt->bindValue(":senha", $novaSenha);
                $stmt->bindValue(":id_usuario", $logado->getId_usuario());
                $stmt->execute();
                $_SESSION['toast'][] = "Senha alterada!";
                header('location: ../Tela/perfil.php');
            } else {
                $_SESSION['toast'][] = 'Sua senha antiga não corresponde';
                header('location: ../Tela/perfil.php?msg=errouOld');
            }
        } else {
            $_SESSION['toast'][] = 'As senhas tem que serem idênticas';
            header('location: ../Tela/perfil.php');
        }
    }

    public
    function updateUsuario()
    {
        $usuario = new usuario($_POST);
        $logado = $this->getLogado();
        $usuarioAnterior = $this->selectUsuarioId_usuario($logado->getId_usuario());
        $usuarioAnterior = new usuario($usuarioAnterior->fetch());
        $selectCpf = $this->selectUsuarioCpf($usuario->getCpf());
        if ($selectCpf && $usuario->getCpf() != '') {
            if ($selectCpf->rowCount() > 0) {
                $usuarioTeste = new usuario($selectCpf->fetch());
                if ($usuarioTeste->getId_usuario() != $usuarioAnterior->getId_usuario()) {
                    header('location: ../Tela/dadosJaCadastrados.php?msg=cpf&update=1');
                    exit();
                }
            }
        }
        $selectTelefone = $this->selectUsuarioTelefone($usuario->getTelefone());
        if ($selectTelefone) {
            if ($selectTelefone->rowCount() > 0 && $usuario->getTelefone() != '') {
                $usuarioTeste = new usuario($selectTelefone->fetch());
                if ($usuarioTeste->getId_usuario() != $usuarioAnterior->getId_usuario()) {
                    header('location: ../Tela/dadosJaCadastrados.php?msg=telefone&update=1');
                    exit();
                }
            }
        }
        $selectEmail = $this->selectUsuarioEmail($usuario->getEmail());
        if ($selectEmail && $usuario->getEmail() != '') {
            if ($selectEmail->rowCount() > 0) {
                $usuarioTeste = new usuario($selectEmail->fetch());
                if ($usuarioTeste->getId_usuario() != $usuarioAnterior->getId_usuario()) {
                    header('location: ../Tela/dadosJaCadastrados.php?msg=email&update=1');
                    exit();
                }
            }
        }
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set nome = :nome , cpf = :cpf , email = :email , telefone = :telefone , data_nasc = :data_nasc , ativo = :ativo , email_confirmado = :email_confirmado , '
            . 'telefone_confirmado = :telefone_confirmado where id_usuario = :id_usuario;');
        $stmt->bindValue(':nome', $usuario->getNome());

        $stmt->bindValue(':cpf', $usuario->getCpf());

        $stmt->bindValue(':email', $usuario->getEmail());

        $stmt->bindValue(':telefone', $usuario->getTelefone());

        $stmt->bindValue(':data_nasc', $usuario->getData_banco());


        $verificaEmail = false;
        $verificaTelefone = false;
        $parametros = new parametros();
        if ($parametros->getConfirmaEmail() == 1) {
            if ($usuario->getEmail() != $logado->getEmail() && $usuario->getEmail() != "") {

                $_SESSION['id_usuario'] = $logado->getId_usuario();
                $verificaEmail = true;
            }
        }
        if ($parametros->getSms() == 1) {
            if ($usuario->getTelefone() != $logado->getTelefone()) {

                $_SESSION['id_usuario'] = $logado->getId_usuario();
                $verificaTelefone = true;
            }
        }
        if (!$verificaEmail && !$verificaTelefone) {
            $stmt->bindValue(':ativo', 1);
            $stmt->bindValue(':email_confirmado', 1);
            $stmt->bindValue(':telefone_confirmado', 1);
        } else {
            if ($verificaEmail) {

                $stmt->bindValue(':email_confirmado', 0);
            } else {
                $stmt->bindValue(':email_confirmado', 1);
            }
            if ($verificaTelefone) {
                $stmt->bindValue(':telefone_confirmado', 0);
            } else {
                $stmt->bindValue(':telefone_confirmado', 1);
            }
            $stmt->bindValue(':ativo', 0);
        }

        $stmt->bindValue(':id_usuario', $logado->getId_usuario());

        if ($verificaEmail) {
            $emailPDO = new emailPDO();
            $emailPDO->confirmaEmail($usuario->getEmail(), null, $logado->getId_usuario());
            session_destroy();
            setcookie("user", '', time() + 1, '/');
            setcookie("hashValidade", '', time() + 1, '/');
            if ($verificaTelefone) {
                $this->enviaSMS($logado->getId_usuario(), $usuario->getTelefone());
                header('location: ../Tela/codigoSMS.php?msg=emailAlterado');
            } else {
                header('location: ../Tela/codigoEmail.php');
            }
        } else {
            if ($verificaTelefone) {
                session_destroy();
                setcookie("user", '', time() + 1, '/');
                setcookie("hashValidade", '', time() + 1, '/');
                $this->enviaSMS($logado->getId_usuario(), $usuario->getTelefone());
                header('location: ../Tela/codigoSMS.php');
                $stmt->execute();
                exit(0);
            }
            $stmt->execute();
            $usuario->setFoto($logado->getFoto());
            $usuario->setAdministrador($logado->getAdministrador());
            $logado->atualizar($_POST);
            $_SESSION['logado'] = serialize($logado);
            $_SESSION['toast'][] = 'Dados alterados';
            header('location: ../Tela/perfil.php');
        }
        if (!$stmt->execute()) {
            header("location: ../Tela/erroInterno.php?msg=erroInsert");
        }
    }

    public
    function updateUsuarioDataNascCpf(usuario $usuario)
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set  cpf = :cpf , data_nasc = :data_nasc , email = :email where id_usuario = :id_usuario;');
        $stmt->bindValue(':cpf', $usuario->getCpf());
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':data_nasc', $usuario->getData_banco());
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        return $stmt->execute();
    }

    public
    function getLogado()
    {
        return new usuario(unserialize($_SESSION['logado']));
    }

    public
    function deleteUsuario($definir)
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set deletado = 1 where id_usuario = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }

    function deletar()
    {
        $logado = $this->getLogado();
        if ($logado->getAdministrador() == 0) {
            $_SESSION['toast'][] = 'Nível de administrador necessário!';
        } else {
            $this->deleteUsuario($_GET['id']);
            $_SESSION['toast'][] = 'Cliente excluído';
        }
        header('location: ../Tela/listagemUsuario.php');
    }


    /* login */
    function loginAppFace()
    {
        $id_face = $_GET['facebook_id'];
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from usuario where facebook_id = :id");
        $stmt->bindValue(":id", $id_face);
        $stmt->execute();
        $usuario = new usuario($stmt->fetch());
        $_SESSION['logado'] = serialize($usuario);
        header("location: ../index.php");
    }

//Bloco de funções do Login
    protected
    function compatibilidadeLogin()
    {
        if (isset($_GET['us'])) {
            if ($_GET['us'] == "") {
                echo 'erroSenha';
            }
            $_POST['usuario'] = $_GET['us'];
            $_POST['senha'] = $_GET['ps'];
            if ($_GET['url'] != "null") {
                $_POST['url'] = $_GET['url'];
            }
        }
        if (isset($_GET['url'])) {
            $_POST['url'] = $_GET['url'];
        }
    }

    protected
    function validacaoFormularioLogin()
    {
        if ($_POST['usuario'] == "") {
            return false;

        }
        $_POST['usuario'] = str_replace("(", "", $_POST['usuario']);
        $_POST['usuario'] = str_replace(" ", "", $_POST['usuario']);
        $_POST['usuario'] = str_replace(")", "", $_POST['usuario']);
        $_POST['usuario'] = str_replace("-", "", $_POST['usuario']);
        return true;
    }

    protected
    function selectLogin()
    {
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :email or telefone = :telefone and senha != ''");
        $stmt->bindValue(":email", $_POST['usuario']);
        $stmt->bindValue(":telefone", $_POST['usuario']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);
            $usuario = new usuario($linha);
            return $usuario;
        } else {
            return null;
        }
    }

    protected
    function verificaDados(usuario $usuario)
    {
        $parametros = new parametros();
        if ($parametros->getSms() == 1 || $parametros->getConfirmaEmail() == 1) {
            if ($usuario->getEmail_confirmado() == 0 || $usuario->getTelefone_confirmado() == 0) {
                $_SESSION['id_usuario'] = $usuario->getId_usuario();
                $sms = ($parametros->getSms() == 1 ? $usuario->getTelefone_confirmado() : 1);
                $email = ($parametros->getConfirmaEmail() == 1 ? $usuario->getEmail_confirmado() : 1);
                if ($sms == 0 || $email == 0) {
                    return ('location: ../Tela/dadosNaoConfirmados.php?email=' . $email . "&telefone=" . $sms);
                } else {
                    return 'true';
                }
            }
        }
        return "true";
    }

    protected
    function verificaPreCadastro(usuario $usuario)
    {
        if ($usuario->getPre_cadastro() == 0) {
            return true;
        } else {
            session_destroy();
            return false;
        }
    }

    protected
    function verificaDeletado(usuario $usuario)
    {
        if ($usuario->getDeletado() == 0) {
            return true;
        } else {
            return false;
        }
    }

    protected
    function verificaAtivo(usuario $usuario)
    {
        if ($usuario->getAtivo() == 1) {
            return true;
        } else {
            return false;

        }
    }

    protected
    function verificaStatus(usuario $usuario)
    {
        $senha = md5($_POST['senha']);
        return ($usuario->getSenha() == $senha && $usuario->getPre_cadastro() == 0 && $usuario->getSenha() != md5(""));
    }

    protected
    function defineCookieAndSession(usuario $usuario)
    {
        $_SESSION['logado'] = serialize($usuario);
        setcookie("user", $usuario->getId_usuario(), time() + (365 * 24 * 60 * 60), "/" , "mastereduca.com");
        setcookie("hashValidade", md5($_SERVER['REMOTE_ADDR']), time() + (365 * 24 * 60 * 60), "/" , "mastereduca.com");
    }

//Fim do bloco de funções do login

    function login()
    {
        $parametros = new parametros();
        //Para fins de compatibilidade, testar futuramente a possível remoção
        $this->compatibilidadeLogin();
        //Fim do bloco
        if ($this->validacaoFormularioLogin()) {
            $senha = md5($_POST['senha']);
            $usuario = $this->selectLogin();
            if ($usuario != null) {
                //Caso o usuario ja tenha sido cadastrado ele vai ter que completar o cadastro
                if ($this->verificaPreCadastroRegistro($usuario)) {
                    header("Location: ../Tela/completaPorEmail.php");
                    exit();
                }
                if ($this->verificaStatus($usuario)) {
                    $dados = $this->verificaDados($usuario);
                    if ($dados == "true") {
                        if ($this->verificaAtivo($usuario)) {
                            if ($this->verificaDeletado($usuario)) {
                                if ($this->verificaPreCadastro($usuario)) {
                                    $this->defineCookieAndSession($usuario);
                                    if (isset($_POST['url'])) {
                                        header('location: ../' . $_POST['url']);
                                    } else {
                                        header("Location: ../index.php?logado=true");
                                    }

                                } else {
                                    session_start();
                                    $_SESSION['id_usuario_correcao'] = $usuario->getId_usuario();
                                    header('location: ../Tela/redefineSenha.php?primeiraSenha=1&primeiro&codigo=' . $usuario->getId_usuario());
                                    session_write_close();
                                    exit(0);
                                }
                            } else {
                                header('location: ../Tela/usuarioDeletado.php?id_usuario=' . $usuario->getId_usuario());
                                exit();
                            }
                        } else {
                            $_SESSION['id_usuario'] = $usuario->getId_usuario();
                            header('location: ../Tela/confirmaCadastro.php');
                        }
                    } else {
                        header($dados);
                        exit(0);
                    }
                } else {
                    if ($senha != $usuario->getSenha()) {
                        header("Location: ../Tela/login.php?msg=erro");
                    } else {
                        if ($parametros->getSms() == 0) {
                            if ($this->verificaPreCadastro($usuario)) {
                                header("location: ../Tela/completaPorEmail.php");
                            } else {
                                session_start();
                                $_SESSION['id_usuario_correcao'] = $usuario->getId_usuario();
                                header("location: ../Tela/redefineSenha.php?primeiraSenha=1&segundo&codigo=" . $usuario->getId_usuario());
                                session_write_close();
                                exit(0);
                            }
                        } else {
                            $this->enviaSMS($usuario->getId_usuario(), $usuario->getTelefone());
                            header('location: ../Tela/codigoSMS.php?semSenha');
                        }
                        exit(0);
                    }
                }
            } else {
                header("Location: ../Tela/login.php?msg=erro&2");
            }
        } else {
            $_SESSION['toast'][] = "Não adianta tirar o required!";
            header("location: ../Tela/login.php");
            exit(0);
        }
    }

    function updateToken($id_usuario, $token)
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set token = :token  where id_usuario = :id_usuario;');
        $stmt->bindValue(':token', $token);
        $stmt->bindValue(':id_usuario', $id_usuario);
        return $stmt->execute();
    }

    function logout()
    {
        session_destroy();
        setcookie("user", '', time() + 1, '/');
        setcookie("user", '', time() + 1, '/' , "mastereduca.com");
        setcookie("hashValidade", '', time() + 1, '/');
        setcookie("hashValidade", '', time() + 1, '/' , "mastereduca.com");
        if (isset($_GET['url'])) {
            header('location: ../index.php');
        } else {
            header('location: ../index.php');
        }
    }

    /* login */

    public
    function alteraFoto()
    {
        if (filesize($_FILES['imagem']['tmp_name']) > 15000000) {
            $_SESSION['toast'][] = "O tamanho máximo de arquivo é de 15MB";
            header("location: ../Tela/perfil.php");
        } else {
            $fatorReducao = 5;
            $tamanho = filesize($_FILES['imagem']['tmp_name']);
            $qualidade = (100000000 - ($tamanho * $fatorReducao)) / 1000000;
            if ($qualidade < 5) {
                $qualidade = 5;
            }
            $us = new usuario(unserialize($_SESSION['logado']));
            $antiga = $us->getFoto();

            //Receber os dados do formulÃ¡rio
            $nome_imagem = hash_file('md5', $_FILES['imagem']['tmp_name']);
            $ext = explode('.', $_FILES['imagem']['name']);
            $extensao = "." . $ext[(count($ext) - 1)];
            $extensao = strtolower($extensao);
            file_put_contents('./logodotipodafoto', $extensao);
            switch ($extensao) {
                case '.jfif':
                case '.jpeg':
                case '.jpg':
                    imagewebp(imagecreatefromjpeg($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.svg':
                    move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.svg');
                    break;
                case '.gif':
                    move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.gif');
                    break;
                case '.png':
                    $img = imagecreatefrompng($_FILES['imagem']['tmp_name']);
                    imagepalettetotruecolor($img);
                    imagewebp($img, __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.webp':
                    imagewebp(imagecreatefromwebp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.bmp':
                    imagewebp(imagecreatefromwbmp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', $qualidade);
                    break;
            }
            $conexao = new conexao();
            $pdo = $conexao->getConexao();
            $stmt = $pdo->prepare("update usuario set foto = :imagem , is_foto_url = 0 where id_usuario = :id");
            $stmt->bindValue(':id', $us->getId_usuario());
            $stmt->bindValue(':imagem', 'Img/Perfil/' . $nome_imagem . ($extensao == '.svg' ? ".svg" : ($extensao == '.gif' ? ".gif" : ".webp")));


            //Verificar se os dados foram inseridos com sucesso
            if ($stmt->execute()) {
                $us->setFoto('Img/Perfil/' . $nome_imagem . ($extensao == '.svg' ? ".svg" : ($extensao == '.gif' ? ".gif" : ".webp")));

                if ($antiga != 'Img/Perfil/default.png' && $antiga != $us->getFoto()) {
                    if ($us->getIs_foto_url() != 1) {
                        unlink('../' . $antiga);
                    }
                }
                $us->setIs_foto_url(0);
                $_SESSION['logado'] = serialize($us);
                header('Location: ../Tela/perfil.php');
            } else {
                header('Location: ../Tela/perfil.php?msg=erro1');
            }
        }
    }

    public
    function removeAdm()
    {
        $id = $_GET['id'];
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set administrador = 0 where id_usuario = :id');
        $stmt->bindValue(":id", $id);
        if($stmt->execute()) {
            header("Location: ../Tela/listagemUsuario.php?sucesso");
        } else {
            header("Location: ../Tela/listagemUsuario.php?erro");
        }
    }

    public
    function addAdm()
    {
        $id = $_GET['id'];
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set administrador = 1 where id_usuario = :id');
        $stmt->bindValue(":id", $id);
        if($stmt->execute()) {
            header("Location: ../Tela/listagemUsuario.php?sucesso");
        } else {
            header("Location: ../Tela/listagemUsuario.php?erro");
        }
    }

    /* chave */
}
