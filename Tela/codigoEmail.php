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
            }
            if (isset($_GET['motivo'])) {
                ?>
                <p>Enviamos um link de recuperação para seu E-mail, por favor acesse o link para recuperar sua
                    conta!</p>
                <?php
            } else {
                ?>
                <p>Enviamos um link de confirmação para seu E-mail, por favor acesse o link para ativar sua conta!</p>
                <?php
            }
            ?>
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

