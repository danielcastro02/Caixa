<?php
include_once '../Base/requerLogin.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <?php
        include_once '../Controle/relatorio_mensalPDO.php';
        include_once '../Modelo/Relatorio_mensal.php';
        $relatorioPDO = new Relatorio_mensalPDO();
        include_once '../Base/header.php';
        ?>
    <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row" style="">
                <form action="../Controle/relatorio_mensalControle.php?function=inserirRelatorio_mensal" class="card col l8 offset-l2 m10 offset-m1 s12" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Registre o relatório</h4>
                        <div class="input-field col s12 l6">
                            <input type="text" name="mes">
                            <label>Mes</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <input type="text" name="ano">
                            <label>Ano</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <select name="id_anterior">
                                <option value="0">Nenhum</option>
                                <?php
                                $relatorios = $relatorioPDO->selectRelatorio_mensal();
                                if($relatorios) {
                                    while ($linha = $relatorios->fetch()) {
                                        $relatorio = new relatorio_mensal($linha);
                                        if ($relatorio->getStatus() == 'fechado') {
                                            echo "<option value='" . $relatorio->getId() . "'>" . $relatorio->getMes() . " " . $relatorio->getAno() . "</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                            <label>Anterior</label>
                        </div>
                        <input type="text" hidden="true" value="0" name="saldofinal"/>
                        <input type="text" hidden="true" value="aberto" name="status"/>
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
        <script>
        $('select').formSelect();
        </script>
    </body>
</html>

