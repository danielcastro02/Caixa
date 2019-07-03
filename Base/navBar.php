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

<nav class="nav-extended white">
    <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">
        <a href="<?php echo $pontos; ?>./Tela/home.php" class="brand-logo left black-text">Sloth</a>
        <ul class="right hide-on-med-and-down">
            <!--movimento-->
            <li>
                <a class='dropdown-trigger center black-text' style="background-color: transparent" data-hover="true" href='#' data-target='movimento'>Movimento</a>
                <ul id='movimento' class='dropdown-content'>
                    <!--movimentoitem-->
                    <!--movimentoitem-->
                </ul>
            </li>
            <!--movimento-->
            <!--relatorio_mensal-->
            <li>
                <a class='dropdown-trigger center black-text' style="background-color: transparent" data-hover="true" href='#' data-target='relatorio_mensal'>Relatorio_mensal</a>
                <ul id='relatorio_mensal' class='dropdown-content'>
                    <!--relatorio_mensalitem-->
                    <!--relatorio_mensalitem-->
                </ul>
            </li>
            <!--relatorio_mensal-->
            <!--usuarios-->
            <li>
                <a class='dropdown-trigger center black-text' style="background-color: transparent" data-hover="true" href='#' data-target='usuarios'>Usuarios</a>
                <ul id='usuarios' class='dropdown-content'>
                    
            <!--usuarioslogin-->
                <li><a href="<?php echo $pontos; ?>./Tela/login.php">Login</a></li>
            <!--usuarioslogin-->
                
            
            <!--usuariosregistro-->
                <li><a href="<?php echo $pontos; ?>./Tela/registroUsuario.php">Registro</a></li>
            <!--usuariosregistro-->
                
            <!--usuariositem-->
            <!--usuariositem-->


                </ul>
            </li>
            <!--usuarios-->
            <!--proximo-->
            <!--proximo-->
            

            



        </ul>
    </div>

</nav>
<script>
$('.dropdown-trigger').dropdown({
        coverTrigger: false,
    });

</script>
