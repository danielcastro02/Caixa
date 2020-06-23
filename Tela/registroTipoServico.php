<?php
include_once '../Base/requerLogin.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php
    include_once '../Base/header.php';
    ?>
<body class="homeimg">
<?php
include_once '../Base/navBar.php';
?>
<main>
    <div class="row" style="margin-top: 10vh;">
        <form action="../Controle/tipoServicocontrole.php?function=inserir" class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1" method="post">
            <div class="row center">
                <h4 class="textoCorPadrao2">Registre a descrição</h4>
                <div class="input-field col s6">
                    <select name="operacao">
                        <option value="-1">Saída</option>
                        <option value="1">Entrada</option>
                    </select>
                </div>
                <div class="input-field col s6">
                    <input type="text" name="nome">
                    <label>Nome</label>
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

