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
</main>
<?php
include_once './Base/footer.php';
?>
</body>
</html>

