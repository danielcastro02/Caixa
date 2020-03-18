<?php
include_once '../Base/requerLogin.php';
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
                            <h5>Relatório Criado!</h5>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="row">
                <div class="col l6 m6 s12">
                    <div class="row">
                        <div class="card col s10 offset-s1 l10 offset-l1 z-depth-5">
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
                                        <a href="./novoRelatorio.php" class="btn-large col s12 btn-collor waves-effect">
                                            <h5>Novo Relatório</h5>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="./listarRelatorio.php" class="btn-large col s12 btn-collor waves-effect">
                                            <h5>Listar Relatório</h5>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="./novaDescricao.php" class="btn-large col s12 btn-collor waves-effect">
                                            <h5>Nova Descrição</h5>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="./listarDescricao.php" class="btn-large col s12 btn-collor waves-effect">
                                            <h5>Listar Descrição</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col s12 m6 l6">
                    <div class="row">
                        <div class="card col s10 offset-s1 z-depth-5">
                            <div class="row"></div>

                            <div class="row">
                                <div class="container">
                                    <div class="row">
                                        <a href="./consultaRelatorio.php" class="btn-large col s12 btn-collor waves-effect">
                                            <h5>Consultar Relatórios</h5>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="./saida.php" class="btn-large col s12 btn-collor waves-effect disabled">
                                            <h5>Relatórios anuais</h5>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="./criarelatorio.php" class="btn-large col s12 waves-effect disabled">
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