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
        <title><?php echo $parametros->getNomeEmpresa(); ?></title>
        
    <body class="homeimg">
        <?php
        include_once '../Base/iNav.php';
        ?>
        <main>
            <div class="hide-on-small-and-down" style="margin-top: 15vh;"></div>
            <div class="row">
                <form action="../Controle/usuarioControle.php?function=recuperaSenha" id="formRecupera" class="card col l6 offset-l3 m8 offset-m2 s10 offset-s1" method="post">
                    <div class="row center">
                        <h4>Informe seu E-mail para recuperar sua senha</h4>
                        <div class="input-field col s10 offset-s1">
                            <input id="usuario" type="text" name="usuario" required>
                            <label for="usuario">E-mail</label>
                        </div>
                    </div>
                    <div class="row center">
                        <a href="../index.php" class="corPadrao3 btn waves-effect ">Voltar</a>
                        <a href="#!"  class="corPadrao2 btn waves-effect " id="recuperaApp">Recuperar pelo app</a>
                        <button type="submit" class="btn waves-effect  corPadrao2">Recuperar minha Senha</button>
                        <div class='row'>
                            <?php
                            if (isset($_GET['msg'])) {
                                if ($_GET['msg'] == "erro") {
                                    echo "<script>M.toast({html: \"Você errou alguma coisa!<br> Ainda não é cadastrado? <a class='btn-flat toast-action textoCorPadrao3 modal-trigger' href='#modalRegistro'>Cadastre-se</a>\", classes: 'rounded'});</script>";
                                }
                            }
                            ?>
                        </div>
                    </div>

                </form>
            </div>
            <script>
                $("#recuperaApp").click(function () {
                    $("#formRecupera").attr("action" , "../Controle/usuarioControle.php?function=recuperaSenhaApp");
                    $("#formRecupera").submit();
                });

            </script>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

