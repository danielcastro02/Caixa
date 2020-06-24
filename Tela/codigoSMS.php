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

    <div class="row">
        <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 card">
            <?php if (isset($_GET['matricula'])) {
                ?>
                <h5>Sua solicitação de matrícula foi realizada!</h5>
                <?php
            } else { ?>
                <h5>Confirmação</h5>
                <?php
            } ?>
            <p>Enviamos um SMS para seu número de celular, por favor insira o código que enviamos</p>
            <form action="../Controle/usuarioControle.php?function=confirmaCadastro<?php echo isset($_GET['semSenha']) ? "&semSenha" : ""; ?>"
                  method="POST">
                <div class="input-field container">
                    <input type="text" name="codigo" id="codigo">
                    <label for="codigo">Código</label>
                </div>
                <div class="row center">
                    <!--<a class="btn waves-effect  corPadrao3" href="../Tela/confirmaCadastro.php">Não quero fazer isso agora</a>-->
                    <input class="btn waves-effect  corPadrao2" value="Confirmar" type="submit">
                </div>
                <?php
                if (isset($_GET['msg'])) {
                    ?>
                    <div class="row center">
                        <span>Enviamos um link para a confirmação do seu e-mail, é necessario que o acesse também!</span>
                    </div>

                    <?php
                }
                ?>
            </form>
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

