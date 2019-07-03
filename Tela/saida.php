<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <?php
        include_once '../Controle/relatorio_mensalPDO.php';
        include_once '../Controle/descricaoPDO.php';
        include_once '../Modelo/Relatorio_mensal.php';
        include_once '../Modelo/Descricao.php';
        $relatorioPDO = new Relatorio_mensalPDO();
        $descricaoPDO = new DescricaoPDO();
        include_once '../Base/header.php';
        ?>
    <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row" style="margin-top: 10vh;">
                <form action="../Controle/movimentoControle.php?function=inserirMovimento" class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Registre a Saida</h4>
                        <div class="input-field col s6">
                            <select name="id_mes">
                                <?php
                                $relatorios = $relatorioPDO->selectRelatorio_mensal();
                                while ($linha = $relatorios->fetch()) {
                                    $relatorio = new relatorio_mensal($linha);
                                    if ($relatorio->getStatus() == 'aberto') {
                                        echo "<option value='" . $relatorio->getId() . "'>" . $relatorio->getMes() . " " . $relatorio->getAno() . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <label>Mes</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" autocomplete="off" name="data">
                            <label>Dia</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="number" step="0.01" name="valor"  class="input-field">
                            <label>Valor</label>
                        </div>
                        <input type="text" hidden="true" value="saida" name="operacao"/>
                    </div><div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="descricao" id="autocomplete-input" autocomplete="off" class="autocomplete"/>

                            <label>Descrição</label>
                        </div>
                    </div>
                    
                    <div class="row center">
                        <a href="./home.php" class="corPadrao3 btn">Voltar</a>
                        <input type="submit" class="btn red darken-3" value="Registrar">
                    </div>

                </form>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
        <script>
            $("#descricao").change(function () {
                if ($(this).val() == "outro") {
                    $(".esconder").show();
                } else {
                    $(".esconder").hide();
                }
            });

            $('input.autocomplete').autocomplete({
                data: {<?php
        $descricoes = $descricaoPDO->selectDescricao();
        $cont = 0;
        while ($linha = $descricoes->fetch()) {
            if($cont!=0){
                echo ",";
            }
            $desc = new descricao($linha);
            echo "\"" . $desc->getTexto() . "\":null";
            $cont++;
        }
        ?>
                },
            });

            $('select').formSelect();
        </script>
    </body>
</html>
