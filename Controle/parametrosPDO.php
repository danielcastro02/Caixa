<?php

include_once __DIR__ . '/../Controle/conexao.php';
include_once __DIR__ . '/../Controle/PDOBase.php';
include_once __DIR__ . '/../Modelo/Parametros.php';

class ParametrosPDO extends PDOBase
{

    public function update()
    {
        $parametros = new parametros();
        $parametros->atualizar($_POST);
        $parametros->save();
        echo "<script>history.go(-1);</script>";

    }


    function updateNotificacao()
    {
        $parametros = new parametros();
        $parametros->atualizar($_POST);
        if (isset($_POST['envia_notificacao'])) {
            $parametros->setEnviaNotificacao(1);
        } else {
            $parametros->setEnviaNotificacao(0);
        }
        $parametros->save();
        echo "<script>javascript:history.go(-1);</script>";
    }

    function updateChat()
    {
        $parametros = new parametros();
        $parametros->atualizar($_POST);
        if (isset($_POST['active_chat'])) {
            $parametros->setActiveChat(1);
        } else {
            $parametros->setActiveChat(0);
        }
        $parametros->save();
        echo "<script>javascript:history.go(-1);</script>";
    }

    function updateGeral()
    {
        $parametros = new parametros();
        $parametros->atualizar($_POST);
        $parametros->setConfirmaEmail(isset($_POST['confirma_email']) ? 1 : 0);
        $parametros->setContasPublicas(isset($_POST['contas_publicas']) ? 1 : 0);
        $parametros->save();
        header('location: ../Tela/configuracoesAvancadas.php?msg=parametrosAtualizados');
    }

    function updatePagamento()
    {
        $parametros = new parametros();
        $parametros->atualizar($_POST);
        if (isset($_POST['ativa_pagamento'])) {
            $parametros->setAtivaPagamento(1);
        } else {
            $parametros->setAtivaPagamento(0);
        }
        $parametros->save();
        echo "<script>javascript:history.go(-1);</script>";
    }

    function updateQrLink()
    {
        $parametros = new parametros();
        $parametros->atualizar($_POST);
        if ($_FILES['qr_app']['name'] != null) {
            $nomeImg = md5_file($_FILES['qr_app']['tmp_name']);
            $ext = explode('.', $_FILES['qr_app']['name']);
            $extensao = "." . $ext[(count($ext) - 1)];
            $extensao = strtolower($extensao);
            move_uploaded_file($_FILES['qr_app']['tmp_name'], "../Img/" . $nomeImg . $extensao);
            $parametros->setQrApp("/Img/" . $nomeImg . $extensao);
        }
        $parametros->save();
        header("location: ../Tela/configuracoesAvancadas.php");


    }

    public function updateTelaInicial()
    {
        if (filesize($_FILES['telainicial']['tmp_name']) > 15000000) {
            $_SESSION['toast'][] = "O tamanho máximo de arquivo é de 15MB";
            header("location: ../Tela/configuracoesAvancadas.php");
        } else {
            $fatorReducao = 0;
            $tamanho = filesize($_FILES['telainicial']['tmp_name']);
            $qualidade = (100000000 - ($tamanho * $fatorReducao)) / 1000000;
            if ($qualidade < 5) {
                $qualidade = 5;
            }
            $parametros = new parametros();
            $SendCadImg = filter_input(INPUT_POST, 'SendCadImg', FILTER_SANITIZE_STRING);
            //Receber os dados do formulÃ¡rio
            $antiga = $parametros->getLogo();
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $nome_imagem = hash_file('md5', $_FILES['telainicial']['tmp_name']);
            //Inserir no BD
            $ext = explode('.', $_FILES['telainicial']['name']);
            $extensao = "." . $ext[(count($ext) - 1)];
            $parametros->setIndexImg('/Img/' . $nome_imagem . ($extensao == '.svg' ? ".svg" : ($extensao == ".gif" ? ".gif" : ".webp")));
            $parametros->save();
            switch ($extensao) {
                case '.jpeg':
                case '.jfif':
                case '.jpg':
                    imagewebp(imagecreatefromjpeg($_FILES['telainicial']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.svg':
                    move_uploaded_file($_FILES['telainicial']['tmp_name'], __DIR__ . '/../Img/' . $nome_imagem . '.svg');
                    break;
                case '.gif':
                    move_uploaded_file($_FILES['telainicial']['tmp_name'], __DIR__ . '/../Img/' . $nome_imagem . '.gif');
                    break;
                case '.png':
                    $img = imagecreatefrompng($_FILES['telainicial']['tmp_name']);
                    imagepalettetotruecolor($img);
                    imagewebp($img, __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.webp':
                    imagewebp(imagecreatefromwebp($_FILES['telainicial']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.bmp':
                    imagewebp(imagecreatefromwbmp($_FILES['telainicial']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                    break;
            }
            //Verificar se os dados foram inseridos com sucesso
            if (realpath("../" . $antiga) && $antiga != $nome_imagem . ".webp") ;
            header('Location: ../Tela/configuracoesAvancadas.php');
        }
    }

    function updateAutenticacao()
    {
        $parametros = new parametros();
        if (isset($_POST['metodo_autenticacao'])) {
            $parametros->setMetodoAutenticacao(1);
        } else {
            $parametros->setMetodoAutenticacao(2);
        }
        $parametros->save();
        header("location: ../Tela/configuracoesAvancadas.php");
    }

    public function removeLogo()
    {
        $parametros = new parametros();
        unlink('../' . $parametros->getLogo());
        $parametros->setLogo("");
        $parametros->setIsFoto(0);
        $parametros->save();
        header('Location: ../Tela/editarParametros.php');
    }

    function recuperaParametros()
    {
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from parametros");
        $stmt->execute();
        $linha = $stmt->fetch();
        file_put_contents("../Modelo/parametros.json", json_encode($linha));
        header("location: ../Tela/configuracoesAvancadas.php");
    }


}
