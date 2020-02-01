<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php
    include_once './Base/header.php';
    include_once './Modelo/Parametros.php';
    $parametros = new Parametros();
    ?>
<body style="background-image: url('.<?php echo $parametros->getIndexImg()?>')">
<nav class="nav-extended">
    <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">
        <a href="<?php echo $pontos; ?>./Tela/home.php" class="brand-logo left">Bem Vindo</a>

    <ul class="right hide-on-med-and-down">
        <!--movimento-->
        <li><a href="./Tela/consultaRelatorio.php" class="">Ver Relatórios</a></li>
        <li><a href="./Tela/login.php" class="">Administração</a></li>
    </ul>
    </div>
</nav>
<main>
    <div class="hide-on-med-and-down" style="width: 100% ; height: 25vh;"></div>
    <div class="row">
        <div class="col s10 m6 l4 offset-l4 offset-m3 offset-s1 card">
            <div class="row"></div>
            <div class="row center">
                <a class="btn corPadrao2" href="./Tela/consultaRelatorio.php">Consultar Relatórios</a>
            </div>
            <div class="row center">
                <a class="btn corPadrao3" href="./Tela/login.php">Area Administrativa</a>
            </div>
        </div>
    </div>
</main>
<?php
include_once './Base/footer.php';
?>
</body>
</html>

