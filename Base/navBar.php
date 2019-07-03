<?php
$pontos = "";
if (realpath("./index.php")) {
    $pontos = '';
} else {
    if (realpath("../index.php")) {
        $pontos = '.';
    } else {
        if (realpath("../../index.php")) {
            $pontos = '../.';
        }
    }
    session_start();
    if(!isset($_SESSION['logado'])){
        header('location: '.$pontos.'./Tela/login.php');
    }else{
        include_once $pontos.'./Modelo/Usuarios.php';
        $logado = new usuarios(unserialize($_SESSION['logado']));
    }
}
?>

<nav class="nav-extended white">
    <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">
        <a href="<?php echo $pontos; ?>./Tela/home.php" class="brand-logo left black-text">IELSPJ</a>
        <ul class="right hide-on-med-and-down">
            <!--movimento-->
            <li><a href="#!" class="black-text"><?php echo $logado->getNome() ?></a></li>
            <li>
                <a class='dropdown-trigger center black-text' data-hover="true" href='#' data-target='movimento'>Movimento</a>
                <ul id='movimento' class='dropdown-content'>
                    <li><a href="<?php echo $pontos; ?>./Tela/entrada.php">Registrar Entrada</a></li>
                    <li><a href="<?php echo $pontos; ?>./Tela/saida.php">Registrar Saida</a></li>
                </ul>
            </li>
            <!--movimento-->
            <!--relatorio_mensal-->
            <li>
                <a class='dropdown-trigger center black-text'  data-hover="true" href='#' data-target='relatorio_mensal'>Relatorio mensal</a>
                <ul id='relatorio_mensal' class='dropdown-content'>
                    <li><a href="<?php echo $pontos; ?>./Tela/novoRelatorio.php">Novo</a></li>
                    <li><a href="<?php echo $pontos; ?>./Tela/listarRelatorio.php">Listar</a></li>
                    <!--relatorio_mensalitem-->
                    <!--relatorio_mensalitem-->
                </ul>
            </li>
            
            <li>
                <a class='dropdown-trigger center black-text'  data-hover="true" href='#' data-target='desc'>Descrição</a>
                <ul id='desc' class='dropdown-content'>
                    <li><a href="<?php echo $pontos; ?>./Tela/novaDescricao.php">Nova</a></li>
                    <li><a href="<?php echo $pontos; ?>./Tela/listarDescricao.php">Listar</a></li>
                    <!--relatorio_mensalitem-->
                    <!--relatorio_mensalitem-->
                </ul>
            </li>
            <!--relatorio_mensal-->
            <!--usuarios-->
            <li>
                <a class='dropdown-trigger center black-text'  data-hover="true" href='#' data-target='usuarios'>Usuarios</a>
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
