<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php
        include_once '../Base/header.php';
        include_once '../Modelo/Parametros.php';
        $parametros = new parametros();
        ?>
        <title><?php echo $parametros->getNomeEmpresa()?></title>

    <body class="homeimg">
        <?php
        include_once '../Base/iNav.php';
        ?>
        <main>
            <div class="hide-on-med-and-down" style="margin-top: 1vh;"></div>
            <div class="row">
                <form action="../Controle/usuarioControle.php?function=inserirUsuario" id="formUsuario" class="card col l8 offset-l2 m10 offset-m1 s12" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Registre-se</h4>
                        <div class="input-field col s12 l6">
                            <input id="nome" type="text" name="nome" required="true">
                            <label for="nome">Nome</label>
                        </div>
                        <?php if(isset($_GET['token'])) {
                            ?>
                        <input type="text" name="token" value="<?php echo $_GET['token'] ?>" hidden/>
                        <?php } ?>
                        <div class="input-field col s12 l6">
                            <?php
                                if($parametros->getMetodoAutenticacao()==1){
                                    ?>
                                    <input type="email" name="email" required="true" id="email">
                                    <label for="email">E-mail</label>
                                    <?php
                                }else{
                                    ?>
                                    <input type="text" name="telefone" required="true" id="telefone">
                                    <label for="telefone">Telefone</label>
                                    <?php
                                }
                            ?>

                        </div>

                        <div class = "input-field col s12 l6">
                            <input type="password" name="senha1" id="senha1" required="true">
                            <label for="senha1">Senha</label>
                        </div>
                        <div class = "input-field col s12 l6">
                            <input type="password" name="senha2" id="senha2" required="true">
                            <label for="senha2">Repita a senha</label>
                        </div>
                    </div>
                    <div class="row center">
                        <label>
                            <input type="checkbox" required/>
                            <span>Eu concordo com a politica de privacidade disponível 
                                <a href="https://markeyvip.com/Portfolio/politica.php"target="_blank">Neste link</a>
                            </span>
                        </label>
                    </div>
                    <div class="row">
                        <span class="g-recaptcha" style="padding-left: auto; padding-right: auto;" data-sitekey="6LdSGcIUAAAAAMYl8rJbwwgDioD8alzSK19ouPor"></span>
                    </div>
                    <div class="row center">
                        <a href="../index.php" class="corPadrao3 btn waves-effect ">Voltar</a>
                        <button type="submit" class="btn waves-effect  corPadrao2" value="">Registrar</button>
                        <?php
                        if (isset($_GET['msg'])) {
                            if ($_GET['msg'] == "senhaerrada") {
                                echo "<script>M.toast({html: \"Senhas não coincidem!\", classes: 'rounded'});</script>";
                            }
                        }
                        ?>
                    </div>

                </form>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>

        <script>
            $("#telefone").mask("(00) 00000-0000");
            $("#formUsuario").submit(function () {
                if ($("#telefone").val().length != 15) {
                    M.toast({html: 'Digite um número de celular válido!', classes: 'rounded'})
                    return false;
                } else {
                    var dados = $(this).serialize();
                    var resposta = true;
                    $.ajax({
                        url: '../Controle/usuarioControle.php?function=verificaTelefone',
                        type: 'POST',
                        data: dados,
                        async: false,
                        success: function (data) {
                            if (data == 'true') {
                                resposta = false;
                                $('#telefone').attr('class', 'invalid');
                                M.toast({html: "O telefone já existe no sistema!", classes: 'rounded'});
                            } else {
                                $('#telefone').attr('class', 'valid');
                            }
                        }
                    });
                    if ($("#senha1").val() != $("#senha2").val()) {
                        resposta = false;
                        M.toast({html: "Senhas não coincidem!", classes: 'rounded'});
                    }
                    return resposta;
                }
            });
        </script>
    </body>
</html>

