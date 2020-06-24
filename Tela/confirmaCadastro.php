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
                    <h5>Confirmação</h5>
                    <p>Por favor, informe seu E-mail para confirmarmos a sua conta</p>
                    <form action="../Controle/usuarioControle.php?function=updateEmail" method="POST" id="formEmail">
                        <div class="input-field container">
                            <input id="Email" type="email" name="email" required="true">
                            <label for="Email">E-mail</label>
                        </div>
                        <div class="row center">
                            <!--<a class="btn waves-effect  corPadrao3 disabled" href="../Controle/usuarioControle.php?function=enviaSMS">Não quero fazer isso agora</a>-->
                            <button class="btn waves-effect  corPadrao2" type="submit">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>


        </main>
        <?php
        include_once '../Base/footer.php';
        ?>

        <script>
            $("#telefone").mask("(00) 00000-0000");

            $("#formEmail").submit(function () {
                var dados = $(this).serialize();
                var resposta = true;
                $.ajax({
                    url: '<?php echo $pontos; ?>Controle/usuarioControle.php?function=verificaEmail',
                    type: 'POST',
                    data: dados,
                    async: false,
                    success: function (data) {
                        if (data == 'true') {
                            resposta = false;
                            $('#email').attr('class', 'invalid');
                            M.toast({html: "O email já existe no sistema!", classes: 'rounded'});
                        } else {
                            $('#email').attr('class', 'valid');
                        }
                    }
                });
                return resposta;
            });

        </script>
    </body>
</html>

