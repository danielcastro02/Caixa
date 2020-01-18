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
    include_once '../Modelo/Movimento.php';
    include_once '../Controle/movimentoPDO.php';
    $relatorioPDO = new Relatorio_mensalPDO();
    $movimentoPDO = new MovimentoPDO();
    include_once '../Base/header.php';
    ?>
<body style="background: white;">
<main>
    <style>
        td, th{
            padding: 2px;
            border: solid 1px black;
            color: black;
        }
    </style>
    <div class="row" >
        <div class=" col s12">
            <?php
            if (isset($_GET['id_relatorio'])) {
                $movimentoPDO = new MovimentoPDO();
                $stmt = $movimentoPDO->selectMovimentoId_mes($_GET['id_relatorio']);
                if ($stmt) {
                    ?>
                    <table class="bordered striped col s12"><?php
                        $atual = $relatorioPDO->selectRelatorio_mensalId($_GET['id_relatorio']);
                        $atual = new relatorio_mensal($atual->fetch());
                        echo "<h5>Relatorio: " . $atual->getMes() . " " . $atual->getAno() . "</h5>"
                        ?>
                        <div class="row">
                            <h5>Saldo inicial: <?php
                                $anterior = $relatorioPDO->selectRelatorio_mensalId($atual->getAnterior());
                                $anterior = new relatorio_mensal($anterior->fetch());
                                echo 'R$ ' . $anterior->getSaldofinal();
                                ?></h5>
                        </div>
                        <thead>
                        <tr>
                            <th>Dia</th>
                            <th>Entrada</th>
                            <th>Saida</th>
                            <th>Saldo</th>
                            <th>Descrição</th>
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
    </div>
    </div>
<p>Gerado em <?php $data = new DateTime(); echo $data->format("d/m/Y \à\s H:i:s"); ?> por Caixa/MarkeyVip</p>
</main>
<?php
include_once '../Base/footer.php';
?>
<script>
    $(document).ready(function () {
        window.print();
    });
</script>
</body>
</html>

