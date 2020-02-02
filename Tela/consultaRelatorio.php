<?php
include_once "../Modelo/Parametros.php";
$parametros = new Parametros();
if(!$parametros->isContasPublicas()) {
    include_once '../Base/requerLogin.php';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php
    include_once '../Controle/relatorio_mensalPDO.php';
    include_once '../Modelo/Relatorio_mensal.php';
    include_once '../Modelo/Movimento.php';
    include_once '../Controle/movimentoPDO.php';
    $relatorioPDO = new Relatorio_mensalPDO();
    $movimentoPDO = new MovimentoPDO();
    include_once '../Base/header.php';
    ?>
<body class="homeimg">
<?php
include_once '../Base/navBar.php';
?>
<main>
    <div class="row">
        <div class=" col s12">
            <h4 class="textoCorPadrao2 center">Ralatórios Mensais</h4>
            <div class="row">
                <form action="./consultaRelatorio.php" method="post" name="relatorio" id="relatorio" class="col s12">
                    <div class="row">
                        <div class="input-field col s6">
                            <select name="id_relatorio">
                                <?php
                                $relatorioPDO = new Relatorio_mensalPDO();
                                $stmt = $relatorioPDO->selectRelatorio_mensal();
                                while ($linha = $stmt->fetch()) {
                                    $relatorio = new relatorio_mensal($linha);
                                    if ($relatorio->getMes() != "Primeiro") {
                                        echo "<option value='" . $relatorio->getId() . "'>" . $relatorio->getMes() . " " . $relatorio->getAno() . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <label for="id_relatorio">Mês</label>
                        </div>
                        <div class="col s4 input-field offset-s2">
                            <button class="btn green lighten-1 right" type="submit">Pesquisar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row hide-on-med-and-down">
                <?php
                if (isset($_POST['id_relatorio'])) {
                    $movimentoPDO = new MovimentoPDO();
                    $stmt = $movimentoPDO->selectMovimentoId_mes($_POST['id_relatorio']);
                    if ($stmt) {
                        ?>
                        <table class="bordered striped col s12"><?php
                            $atual = $relatorioPDO->selectRelatorio_mensalId($_POST['id_relatorio']);
                            $atual = new relatorio_mensal($atual->fetch());
                            echo "<h5>Relatorio: " . $atual->getMes() . " " . $atual->getAno() . "</h5>"
                            ?>
                            <div class="row">
                                <h5>Saldo inicial: <?php
                                    $anterior = $relatorioPDO->selectRelatorio_mensalId($atual->getAnterior());
                                    $anterior = new relatorio_mensal($anterior->fetch());
                                    echo 'R$ ' . $anterior->getSaldofinal();
                                    ?></h5>
                                <a class="btn corPadrao2"
                                   href="./graficoLinha.php?id_mes=<?php echo $atual->getId() ?>">Ver
                                    gráfico de linhas</a>
                                <a class="btn corPadrao2"
                                   href="./imprimirRelatorio.php?id_relatorio=<?php echo $atual->getId() ?>">Imprimir</a>
                            </div>
                            <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Entrada</th>
                                <th>Saida</th>
                                <th>Saldo</th>
                                <th>Descrição</th>
                                <th>Anexo</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $valor = $anterior->getSaldofinal();
                            while ($linha = $stmt->fetch()) {
                                $movimento = new movimento($linha);
                                ?>

                                <tr>
                                    <td><?php echo $movimento->getData() ?></td>
                                    <?php
                                    if ($movimento->getOperacao() == 'entrada') {
                                        echo "<td>" . 'R$ ' . $movimento->getValor() . "</td><td></td>";
                                        $valor = $valor + $movimento->getValor();
                                    } else {
                                        echo "<td></td><td>" . 'R$ ' . ($movimento->getValor()) . "</td>";
                                        $valor = $valor - $movimento->getValor();
                                    }
                                    ?>
                                    <td><?php echo 'R$ ' . number_format($valor, 2, '.', ''); ?></td>
                                    <td><?php echo $movimento->getDescricao(); ?></td>
                                    <?php
                                    include_once "../Controle/anexoPDO.php";
                                    include_once "../Modelo/Anexo.php";
                                    $anexoPDO = new AnexoPDO();
                                    $anexo = $anexoPDO->selectAnexoIdMovimento($movimento->getId());
                                    if ($anexo) {
                                        ?>
                                        <td><a href="..<?php echo $anexo->getCaminho(); ?>">Anexo</a></td>
                                        <?php
                                    }else{
                                        ?>
                                        <td>--</td>
                                        <?php
                                    }
                                    ?>
                                </tr>


                                <?php
                            }
                            ?> </tbody>
                        </table>
                        <h5>Saldo final: <?php echo 'R$ ' . number_format($valor, 2, '.', ''); ?></h5><?php
                    } else {
                        echo 'Nenhum movimento';
                    }
                }
                ?>
            </div>


            <div class="row hide-on-large-only">
                <?php
                if (isset($_POST['id_relatorio'])) {
                    $movimentoPDO = new MovimentoPDO();
                    $stmt = $movimentoPDO->selectMovimentoId_mes($_POST['id_relatorio']);
                    if ($stmt) {
                        ?>
                        <?php
                            $atual = $relatorioPDO->selectRelatorio_mensalId($_POST['id_relatorio']);
                            $atual = new relatorio_mensal($atual->fetch());
                            echo "<h5>Relatorio: " . $atual->getMes() . " " . $atual->getAno() . "</h5>"
                            ?>
                            <div class="row">
                                <h5>Saldo inicial: <?php
                                    $anterior = $relatorioPDO->selectRelatorio_mensalId($atual->getAnterior());
                                    $anterior = new relatorio_mensal($anterior->fetch());
                                    echo 'R$ ' . $anterior->getSaldofinal();
                                    ?></h5>
                                <a class="btn corPadrao2"
                                   href="./graficoLinha.php?id_mes=<?php echo $atual->getId() ?>">Ver
                                    gráfico de linhas</a>
                                <a class="btn corPadrao2"
                                   href="./imprimirRelatorio.php?id_relatorio=<?php echo $atual->getId() ?>">Imprimir</a>
                            </div>
                        <ul class="col s12 collapsible">
                            <?php
                            $valor = $anterior->getSaldofinal();
                            while ($linha = $stmt->fetch()) {
                                $movimento = new movimento($linha);
                                ?>

                                <li>
                                    <div class="collapsible-header">Dia <?php echo $movimento->getData() ?>
                                    <?php
                                    if ($movimento->getOperacao() == 'entrada') {
                                        echo "" . '- Entrada -R$ ' . $movimento->getValor();
                                        $valor = $valor + $movimento->getValor();
                                    } else {
                                        echo '- Saída -R$ ' . ($movimento->getValor());
                                        $valor = $valor - $movimento->getValor();
                                    }
                                    ?>
                                    <?php echo 'Saldo - R$ ' . number_format($valor, 2, '.', ''); ?></div>
                                    <div class="collapsible-body"><?php echo $movimento->getDescricao(); ?>
                                    <?php
                                    include_once "../Controle/anexoPDO.php";
                                    include_once "../Modelo/Anexo.php";
                                    $anexoPDO = new AnexoPDO();
                                    $anexo = $anexoPDO->selectAnexoIdMovimento($movimento->getId());
                                    if ($anexo) {
                                        ?>
                                        <a href="..<?php echo $anexo->getCaminho(); ?>">Anexo</a></div>
                                        <?php
                                    }else{
                                        ?>
                                       --</div>
                                        <?php
                                    }
                                    ?>
                                </li>


                                <?php
                            }
                            ?>
                        </ul>
                        <h5>Saldo final: <?php echo 'R$ ' . number_format($valor, 2, '.', ''); ?></h5><?php
                    } else {
                        echo 'Nenhum movimento';
                    }
                }
                ?>
            </div>

        </div>
    </div>
    </div>

</main>
<?php
include_once '../Base/footer.php';
?>
<script>
    $('select').formSelect();
    $('.collapsible').collapsible();
</script>
</body>
</html>

