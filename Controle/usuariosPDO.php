<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Modelo/Usuarios.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Modelo/Usuarios.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Usuarios.php';
        }
    }
}


class UsuariosPDO
{

    /*inserir*/
    function inserirUsuarios()
    {

        include_once '../Base/requerLogin.php';

        $usuarios = new usuarios($_POST);
        if ($_POST['senha1'] == $_POST['senha2']) {
            $senhamd5 = md5($_POST['senha1']);
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into usuarios values(default , :nome , :usuario , :senha);');

            $stmt->bindValue(':nome', $usuarios->getNome());

            $stmt->bindValue(':usuario', $usuarios->getUsuario());

            $stmt->bindValue(':senha', $senhamd5);

            if ($stmt->execute()) {
                header('location: ../index.php?msg=usuariosInserido');
            } else {
                header('location: ../index.php?msg=usuariosErroInsert');
            }
        } else {
            header('location: ../Tela/registroUsuario.php?msg=senhaerrada');
        }
    }

    /*inserir*/


    public function selectUsuarios()
    {

        include_once '../Base/requerLogin.php';

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuarios ;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }


    public function selectUsuariosId($id)
    {

        include_once '../Base/requerLogin.php';

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuarios where id = :id;');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }


    public function selectUsuariosNome($nome)
    {

        include_once '../Base/requerLogin.php';

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuarios where nome = :nome;');
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }


    public function selectUsuariosUsuario($usuario)
    {

        include_once '../Base/requerLogin.php';

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuarios where usuario = :usuario;');
        $stmt->bindValue(':usuario', $usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }


    public function selectUsuariosSenha($senha)
    {

        include_once '../Base/requerLogin.php';

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuarios where senha = :senha;');
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }


    public function updateUsuarios(Usuarios $Usuarios)
    {

        include_once '../Base/requerLogin.php';

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('updateusuariosset nome = :nome , usuario = :usuario , senha = :senha where id = :id;');
        $stmt->bindValue(':nome', $usuarios->getNome());

        $stmt->bindValue(':usuario', $usuarios->getUsuario());

        $stmt->bindValue(':senha', $usuarios->getSenha());

        $stmt->bindValue(':id', $usuarios->getId());
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteUsuarios($definir)
    {

        include_once '../Base/requerLogin.php';

        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from usuarios where id = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }


    /*login*/
    public function login()
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        $senha = md5($_POST['senha']);
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario LIKE :usuario AND senha LIKE :senha");
        $stmt->bindValue(":usuario", $_POST['usuario']);
        $stmt->bindValue(":senha", $senha);
        $stmt->execute();
        if ($stmt->rowCount()>0) {
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['logado'] = serialize(new Usuarios($linha));
            header("Location: ../Tela/home.php");
        } else {
            header("Location: ../Tela/login.php?msg=erro");
        }
    }

    function logout()
    {
        session_destroy();
        header('location: ../Tela/login.php');
    }

    /*login*/

    /*chave*/
}
