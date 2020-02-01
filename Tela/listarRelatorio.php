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
            <div class="row" style="margin-top: 5vh;">
                <table class="col s12 center">
                    <tr class="center">
                        <td class="center">Mes</td>
                        <td  class="center">Ano</td>
                        <td class="center">Alterar Status</td>
                        <td class="center">Alterar Relatório</td>
                    </tr>
                    <?php
                    $relatorios = $relatorioPDO->selectRelatorio_mensal();
                    while ($linha = $relatorios->fetch()) {
                        $relatorio = new relatorio_mensal($linha);
                        if ($relatorio->getMes() != "Primeiro") {
                            ?>
                            <tr>
                                <td class="center"><?php echo $relatorio->getMes() ?></td>
                                <td class="center"><?php echo $relatorio->getAno() ?></td>
                                <td class="center">
                                    <?php if ($relatorio->getStatus() == 'aberto' || $relatorio->getStatus() =="abertolincado") { ?>
                                        <a href="../Controle/relatorio_mensalControle.php?function=fechar&id=<?php echo $relatorio->getId() ?>" class="btn corPadrao2">Fechar</a>
                                    <?php } else {
                                        ?>
                                        <a href="../Controle/relatorio_mensalControle.php?function=abrir&id=<?php echo $relatorio->getId() ?>" class="btn corPadrao2">Abrir</a>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td class="center">Alterar Relatório</td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

