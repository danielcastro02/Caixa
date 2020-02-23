<?php
    include_once '../Modelo/Usuarios.php';
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_SESSION['logado'])){
        $logado = new usuarios(unserialize($_SESSION['logado']));
    }?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php
        include_once '../Base/header.php';
        include_once '../Controle/usuariosPDO.php';
        include_once '../Modelo/Usuarios.php';
        $usuarioPDO = new usuariosPDO();
    ?>
    <title>Caixa</title>

<body class="homeimg">
<?php
    include_once '../Base/navBar.php';
?>
<main>
    <div class="row " style="margin-top: 5vh;">
        <h4 class='center'>Listagem Clientes</h4>
        <div class="table-responsive-vertical hide-on-med-and-down">
            <table class="card col s10 offset-s1 center table">
                <thead>
                <tr class="center">
                    <td class='center'>Nome</td>
                    <td class='center'>Usuario</td>
                    <?php if ($logado->getAdmin() == 1) { ?>
                        <td class='center'>Adm</td>
                    <?php } ?>
                </tr>
                </thead>
                <tbody id="corpoTabela">
                <?php
                    $stmt = $usuarioPDO->selectUsuarios();

                    if ($stmt) {
                        while ($linha = $stmt->fetch()) {
                            $usuario = new usuarios($linha);
                                ?>
                            <tr>
                                <td class="center" data-title="Nome"><?php echo $usuario->getNome() ?></td>
                                <td class="center cpf" data-title="CPF"><?php echo $usuario->getUsuario(); ?></td>
                                <?php if ($logado->getAdmin() == 1) { ?>
                                    <td class="center">
                                        <?php if($usuario->getAdmin() == 1) { ?>
                                            <a class='btn waves-effect red darken-3' href='../Controle/usuariosControle.php?function=removeAdm&id=<?php echo $usuario->getId() ?>'>Remover Adm</a>
                                        <?php } else {
                                            ?>
                                            <a class='btn waves-effect green darken-2' href='../Controle/usuariosControle.php?function=addAdm&id=<?php echo $usuario->getId() ?>'>Adicionar Adm</a>
                                            <?php
                                        } ?>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

