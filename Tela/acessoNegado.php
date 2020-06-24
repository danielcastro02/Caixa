<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include_once '../Base/header.php';
        include_once '../Modelo/Parametros.php';
        $parametros = new parametros();
        ?>
        <meta charset="UTF-8">

        <title><?php echo $parametros->getNomeEmpresa(); ?></title>

    <body class="homeimg">
        <?php
        include_once '../Base/iNav.php';
        ?>
        <main>
            <div class="row">
                <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 card center">
                    <h5>Você necessida de permissão elevada para acessar esta página!</h5>
                    <div class="row">
                        <a class="btn waves-effect  corPadrao2" href='../Tela/login.php'>Voltar</a>
                    </div>
                </div>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>

        <script>
            $("#telefone").mask("(00) 00000-0000");
        </script>
    </body>
</html>

