<?php
    include_once __DIR__.'/../Controle/conexao.php';
    include_once __DIR__.'/../Controle/usuarioPDO.php';
    include_once __DIR__.'/../Modelo/Usuario.php';

    class codigoConfirmacaoPDO
    {
        function verificaCodigoCompleta($codigo)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("Select id_usuario from codigoconfirmacao where codigo = :codigo and tipo = 'completa';");
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->deletar();
                return $stmt->fetch()['id_usuario'];
            } else {
                $this->deletar();
                return false;
            }
        }

        function verificaCodigoRecuperaSenha($codigo, $email)
        {
            $usuarioPDO = new UsuarioPDO();
            $usuario = new usuario($usuarioPDO->selectUsuarioEmail($email)->fetch());
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("Select id_usuario from codigoconfirmacao where codigo = :codigo and tipo = 'recuperaSenha' and id_usuario = :id_usuario;");
            $stmt->bindValue(":codigo", $codigo);
            $stmt->bindValue(":id_usuario", $usuario->getId_usuario());
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->deletarRecuperaSenha($usuario->getId_usuario());
                return $stmt->fetch()['id_usuario'];
            } else {
                $this->deletarRecuperaSenha($usuario->getId_usuario());
                return false;
            }
        }

        function deletar()
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("delete from codigoconfirmacao where tipo = 'completa'");
            $stmt->execute();
        }

        function deletarRecuperaSenha($codigo)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("delete from codigoconfirmacao where id_usuario = :codigo");
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
        }
    }