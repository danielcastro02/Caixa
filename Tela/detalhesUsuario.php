<?php
include_once "../Base/requerAdm.php";
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
    tem que fazer
</main>
<?php
include_once '../Base/footer.php';
?>
</body>
</html>

