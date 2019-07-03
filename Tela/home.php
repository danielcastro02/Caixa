<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['logado'])) {
    header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <?php
        include_once '../Base/header.php';
        ?>

    </head>

    <body class="homeimg">
        <nav class="nav-extended cyan lighten-2">
            <?php
            include_once '../Base/navBar.php';
            ?>
        </nav>
        <main id="main">
            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 'relcriado') {
                    ?>
                    <div class="row center">
                        <div class="col s4 offset-s4 z-depth-5 card light-green">
                            <h5>Relatorio Criado!</h5>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="row">
                <div class="col s6">
                    <div class="row">
                        <div class="card col s10 offset-s1 cyan lighten-5 z-depth-5">
                            <div class="row"></div>

                            <div class="row">
                                <div class="container">
                                    <div class="row">
                                        <a href="./entrada.php" class="btn-large col s12 green lighten-1 waves-effect">
                                            <h5>Registrar Entrada</h5>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="./saida.php" class="btn-large col s12 red darken-2 waves-effect">
                                            <h5>Registrar Saída</h5>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="./criarelatorio.php" class="btn-large col s12 cyan lighten-1 waves-effect">
                                            <h5>Novo Relatório</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col s6">
                    <div class="row">
                        <div class="card col s10 offset-s1 cyan lighten-5 z-depth-5">
                            <div class="row"></div>

                            <div class="row">
                                <div class="container">
                                    <div class="row">
                                        <a href="./relatoriosmensais.php" class="btn-large col s12 cyan lighten-1 waves-effect">
                                            <h5>Consultar Relatorios</h5>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="./saida.php" class="btn-large col s12 cyan lighten-1 waves-effect disabled">
                                            <h5>Relatorios anuais</h5>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="./criarelatorio.php" class="btn-large col s12 cyan lighten-1 waves-effect disabled">
                                            <h5>Anotações</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php
        include_once "../Base/footer.php";
        ?>
    </body>
</html>