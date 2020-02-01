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
        $desc = $descPDO->selectDescricaoId($_GET['id']);
        $descricao = new descricao($desc->fetch());
        ?>
        <main>
            <div class="row" style="margin-top: 10vh;">
                <form action="../Controle/descricaoControle.php?function=update" class="card col l8 offset-l2 m10 offset-m1 s12" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Registre a descrição</h4>
                        <div class="input-field col s10 offset-s1">
                            <input type="text" name="texto" value="<?php echo $descricao->getTexto() ?>">
                            <input type="text" name="id" hidden="true" value="<?php echo $descricao->getId() ?>">
                            <label>Descrição</label>
                        </div>
                    </div>
                    <div class="row center">
                        <a href="./home.php" class="corPadrao3 btn">Voltar</a>
                        <input type="submit" class="btn corPadrao2" value="Registrar">
                    </div>
                    
                </form>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

