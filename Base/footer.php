<?php
$pontos = "";
if (realpath("./index.php")) {
    $pontos = './';
} else {
    if (realpath("../index.php")) {
        $pontos = '../';
    } else {
        if (realpath("../../index.php")) {
            $pontos = '../../';
        }
    }
}
?>

<footer class="center">
    <div class="footer-copyright"><a target="_blank" href="http://markeyvip.com" class="center col l10 s12 offset-l1">
            © 2019 Desenvolvido por - Markey</a>
    </div>
</footer>

