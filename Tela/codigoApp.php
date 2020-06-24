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
            <p>Enviamos uma notificaão para seu celular, por favor insira o código que enviamos</p>
            <form action="../Controle/usuarioControle.php?function=codigoConfirmaRecuperaSenha" method="POST">
                <div class="input-field container">
                    <input type="text" name="codigo" id="codigo">
                    <label for="codigo">Código</label>
                </div>
                <div class="row center">
                    <a class="btn waves-effect  corPadrao3" href="../index.php">Voltar</a>
                    <button class="btn waves-effect  corPadrao2" value="" type="submit">Confirmar</button>
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
</script>
</body>
</html>

