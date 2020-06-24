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
        <title><?php echo $parametros->getNomeEmpresa();?></title>
        
    <body class="homeimg">
        <?php
        include_once '../Base/iNav.php';
        ?>
        <main>
            <div class="hide-on-med-and-down" style="margin-top: 10vh;"></div>
            <div class="row">
                <form action="../Controle/usuarioControle.php?function=<?php echo isset($_GET['primeiraSenha'])?"primeiraSenha":'redefineSenha' ; ?>"class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1 " id="formSenha" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Digite sua nova senha</h4>
                        <div class = "input-field col s12 l6">
                            <input id="senha1" type="password" name="senha1" required="true">
                            <input type="text" hidden="true" name="codigo" value="<?php echo $_GET['codigo'];?>">
                            <input type="text" hidden="true" name="email" value="<?php echo isset($_GET['primeiraSenha'])?"": $_GET['email'] ; ?>">
                            <label for="senha1">Senha</label>
                            <!--Se tocar nesse input eu te dou um tiro  ^^^^ -->
                         </div>
                        <div class = "input-field col s12 l6">
                            <input id="senha2" type="password" name="senha2" required="true">
                            <label for="senha2">Repita a senha</label>
                        </div>
                    </div>
                      <?php if(isset($_GET['primeriaSenha'])){ ?>
                      <div class="row center">
                        <label>
                            <input type="checkbox" required/>
                            <span>Eu concordo com a politica de privacidade disponível 
                                <a href="http://markeyvip.com/politica.php"target="_blank">Neste link</a>
                            </span>
                        </label>
                    </div>
                      <?php } ?>
                    <div class="row center">
                        <a href="../index.php" class="corPadrao3 btn waves-effect ">Voltar</a>
                        <button type="submit" class="btn waves-effect  corPadrao2 white-text">Confirmar</button>
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
            
            $("#formSenha").submit(function(){
                if($("#senha1").val() != $("#senha2").val()){
                    M.toast({
                        html: "As senhas não coincidem!",
                        classes: 'rounded'
                    });
                    $("#preLoader").hide();
                    return false;
                }else{
                    return true;
                }
            });
        </script>
    </body>
</html>


