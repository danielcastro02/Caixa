<?php
include_once '../Base/requerLogin.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <?php
    include_once '../Base/header.php';
    ?>

</head>

<body class="homeimg">
<nav class="nav-extended cyan lighten-2">
    <?php
    include_once '../Base/navBar.php';
    include_once '../Controle/graphPDO.php';
    $graphPDO = new graphPDO();
    ?>
</nav>
<main id="main">
    <?php
    if (isset($_GET['msg'])) {
        if ($_GET['msg'] == 'relcriado') {
            ?>
            <div class="row center">
                <div class="col s4 offset-s4 z-depth-5 card light-green">
                    <h5>Relatório Criado!</h5>
                </div>
            </div>
            <?php
        }
    }
    ?>
    <div class="row">
        <div class="row"></div>
        <div class="col s10 offset-s1 white">
            <canvas id="myChart" height="120"></canvas>
        </div>
    </div>
</main>
<script>
    var ctx = document.getElementById('myChart');
    var data = <?php  echo $graphPDO->getLineData($_GET['id_mes']); ?>;
    var myChart = new Chart(ctx, {
        type: 'line',

        data: data,
        options: {}
    });

</script>
<?php
include_once "../Base/footer.php";
?>
</body>
</html>