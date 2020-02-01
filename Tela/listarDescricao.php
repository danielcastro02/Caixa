<?php
include_once '../Base/requerLogin.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <?php
        include_once '../Controle/descricaoPDO.php';
        include_once '../Modelo/Descricao.php';
        include_once '../Base/header.php';
        $descPDO = new DescricaoPDO();
        ?>
    <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row" style="margin-top: 5vh;">
                <table class="col s12 center">
                    <tr class="center">
                        <td class="center">Descrição</td>
                        <td class="center">Editar</td>
                        <td class="center">Apagar</td>
                    </tr>
                    <?php
                    $descricaos = $descPDO->selectDescricao();
                    if ($descricaos) {
                        while ($linha = $descricaos->fetch()) {
                            $descricao = new descricao($linha);
                                ?>
                                <tr>
                                    <td class="center"><?php echo $descricao->getTexto()?></td>
                                    <td class="center">
                                        <a href="./editarDescricao.php?id=<?php echo $descricao->getId()?>">Editar</a>
                                    </td>
                                    <td class="center"><a href="../Controle/descricaoControle.php?function=deletar&id=<?php echo $descricao->getId()?>">Excluir</a></td>
                                </tr>
                                <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

