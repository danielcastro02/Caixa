<?php
include_once '../Base/requerAdm.php';
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
            <div class="hide-on-med-and-down" style="margin-top: 10vh;"></div>
            <div class="row">
                <form action="../Controle/usuarioControle.php?function=inserirUsuarioAdm" id="formUsuario"class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Cadastro de Cliente</h4>
                        <div class="input-field col s12 l6">
                            <input id="nome" type="text" name="nome" required="true">
                            <label for="nome">Nome</label>
                        </div>
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
                    </div>
                    <div class="row center">
                        <a href="../index.php" class="corPadrao3 btn waves-effect ">Voltar</a>
                        <button type="submit" class="btn waves-effect  corPadrao2" >Registrar</button>
                    </div>

                </form>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
        <script>
            $('#telefone').mask("(00) 00000-0000");
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
                    return resposta;
                }
            });


        </script>
    </body>
</html>

