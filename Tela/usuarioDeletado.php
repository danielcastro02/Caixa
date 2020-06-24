<?php
if(!isset($_SESSION)){
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
            <div class="row">
                <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 card">
                    <div class="row">
                        <h5 class="col s12">Oops!</h5>
                        <p class="col s12">Seu usuário foi deletado, se acha que isto está errado, entre em contato com o administrador pelos campos abaixo:</p>
                        <form method="POST" action="../Controle/emailControle.php?function=usuarioDeletado">
                            <div class="input-field col s12">
                                <input type="text" name="id_usuario" hidden="true" value="<?php echo $_GET['id_usuario']; ?>"/>
                                <input id="remetente" type="text" name='remetente' required="true"/>
                                <label for="remetente">Seu E-mail</label>
                            </div>
                            <div class="input-field col s12">
                                <textarea id="mensagem" name="mensagem" class="materialize-textarea" required="true"></textarea>
                                <label for="mensagem">Mensagem</label>
                            </div>
                            <div class="col s12 center">
                                <a class="btn waves-effect  corPadrao3" href="./login.php">Voltar</a>
                                <button type="submit" class="btn waves-effect  corPadrao2">Enviar</button>
                            </div>
                        </form>
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

