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
    if(!isset($_SESSION)){
        session_start();
    }
    include_once __DIR__."/../Modelo/Parametros.php";
    $parametros = new Parametros();
    if(!isset($_SESSION['logado'])){
        ?>
        <nav class="nav-extended">
            <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">

                <a href="<?php echo $pontos; ?>./Tela/home.php" class="brand-logo left">Bem Vindo</a>

                <ul class="right hide-on-med-and-down">
                    <!--movimento-->
                    <li><a href="<?php echo $pontos; ?>./Tela/consultaRelatorio.php" class="">Ver Relatórios</a></li>
                    <li><a href="<?php echo $pontos; ?>./Tela/login.php" class="">Administração</a></li>
                </ul>
            </div>
        </nav>

        <?php
    }else{
        include_once $pontos.'./Modelo/Usuario.php';
        $logado = new usuario(unserialize($_SESSION['logado']));
   ?>

<nav class="nav-extended">
    <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">
        <a href="#" data-target="slide-out" class="sidenav-trigger">
            <i class="material-icons black-text">menu</i>
        </a>
        <a href="<?php echo $pontos; ?>./Tela/home.php" class="brand-logo">MarkeyVip</a>
        <ul class="right hide-on-med-and-down">
            <!--movimento-->
            <li><a href="#!" class=""><?php echo $logado->getNome() ?></a></li>
            <li>
                <a class='dropdown-trigger center ' data-hover="true" href='#' data-target='movimento'>Movimento</a>
                <ul id='movimento' class='dropdown-content'>
                    <li><a href="<?php echo $pontos; ?>./Tela/entrada.php">Registrar Entrada</a></li>
                    <li><a href="<?php echo $pontos; ?>./Tela/saida.php">Registrar Saida</a></li>
                </ul>
            </li>
            <!--movimento-->
            <!--relatorio_mensal-->
            <li>
                <a class='dropdown-trigger center '  data-hover="true" href='#' data-target='relatorio_mensal'>Relatório mensal</a>
                <ul id='relatorio_mensal' class='dropdown-content'>
                    <li><a href="<?php echo $pontos; ?>./Tela/novoRelatorio.php">Novo</a></li>
                    <li><a href="<?php echo $pontos; ?>./Tela/listarRelatorio.php">Listar</a></li>
                    <li><a href="<?php echo $pontos; ?>./Tela/consultaRelatorio.php">Consultar Relatório</a></li>
                    <!--relatorio_mensalitem-->
                    <!--relatorio_mensalitem-->
                </ul>
            </li>
            
            <li>
                <a class='dropdown-trigger center '  data-hover="true" href='#' data-target='desc'>Descrição</a>
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
                <a class='dropdown-trigger center '  data-hover="true" href='#' data-target='usuarios'>Usuarios</a>
                <ul id='usuarios' class='dropdown-content'>
                    
            <!--usuarioslogin-->
                <li><a href="<?php echo $pontos; ?>./Tela/login.php">Login</a></li>
            <!--usuarioslogin-->
                
            
            <!--usuariosregistro-->
                <li><a href="<?php echo $pontos; ?>./Tela/registroUsuario.php">Registro</a></li>
            <!--usuariosregistro-->

                <li><a href="<?php echo $pontos; ?>./Tela/listagemUsuario.php">Listagem</a></li>
            <!--usuariositem-->
            <!--usuariositem-->


                </ul>
            </li>
            <?php if($logado->getAdministrador() == 1) { ?>
                <li><a href="<?php echo $pontos; ?>./Tela/configuracoesAvancadas.php" class="">Configurações</a></li>
            <?php } ?>
            <li><a href="<?php echo $pontos; ?>./Controle/usuarioControle.php?function=logout" class="">Sair</a></li>
            <!--usuarios-->
            <!--proximo-->
            <!--proximo-->

        </ul>
    </div>

</nav>

        <ul id="slide-out" class="sidenav">
            <li><div class="user-view">
                    <div class="background">
                        <img src="<?php echo $pontos; ?>./Img/bg1.jpg">
                    </div>
<!--                    <a href="#user"><img class="circle" src="images/yuna.jpg"></a>-->
                    <a href="#name"><span class="<?php if ($parametros->getTema() == "dark.css"){echo "black-text";}else{echo "white-text";}?> name"><?php echo $logado->getNome() ?></span></a>
                    <a href="#email"><span class="white-text email"></span></a>

                </div></li>
            <ul class="collapsible">
                <a href="<?php echo $pontos; ?>./index.php" class="black-text">
                    <li>
                        <div style="margin-left: 10px;">
                            Início
                        </div>
                    </li>
                </a>
                <li>
                    <div class="collapsible-header anime black-text" x="0">Movimento<i class="large material-icons right animi">arrow_drop_down</i></div>
                    <div class="collapsible-body">
                        <ul class="grey lighten-2">
                            <li><a href="<?php echo $pontos; ?>./Tela/entrada.php">Registrar Entrada</a></li>
                            <li><a href="<?php echo $pontos; ?>./Tela/saida.php">Registrar Saida</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header anime black-text" x="0">Relatório mensal<i class="large material-icons right animi">arrow_drop_down</i></div>
                    <div class="collapsible-body">
                        <ul class="grey lighten-2">
                            <li><a href="<?php echo $pontos; ?>./Tela/novoRelatorio.php">Novo</a></li>
                            <li><a href="<?php echo $pontos; ?>./Tela/listarRelatorio.php">Listar</a></li>
                            <li><a href="<?php echo $pontos; ?>./Tela/consultaRelatorio.php">Consultar Relatório</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header anime black-text" x="0">Descrição<i class="large material-icons right animi">arrow_drop_down</i></div>
                    <div class="collapsible-body">
                        <ul class="grey lighten-2">
                            <li><a href="<?php echo $pontos; ?>./Tela/novaDescricao.php">Nova</a></li>
                            <li><a href="<?php echo $pontos; ?>./Tela/listarDescricao.php">Listar</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header anime black-text" x="0">Usuarios<i class="large material-icons right animi">arrow_drop_down</i></div>
                    <div class="collapsible-body">
                        <ul class="grey lighten-2">
                            <li><a href="<?php echo $pontos; ?>./Tela/login.php">Login</a></li>
                            <li><a href="<?php echo $pontos; ?>./Tela/registroUsuario.php">Registro</a></li>
                        </ul>
                    </div>
                </li>

                        <a href="<?php echo $pontos; ?>./Tela/configuracoesAvancadas.php" class="black-text">
                            <li>
                                <div class="black-text" style="margin-left: 10px;">Configurações</div>
                            </li>
                        </a>

                <a class="black-text modal-trigger" href="<?php echo $pontos; ?>./Controle/usuarioControle.php?function=logout">
                    <li>
                        <div class="black-text" style="margin-left: 10px;">
                            Sair
                        </div>
                    </li>
                </a>
            </ul>
        </ul>
<script>
    $(document).ready(function(){
        $('.dropdown-trigger').dropdown({
        coverTrigger: false,
        });
        $('.sidenav').sidenav();
        $('.collapsible').collapsible();
        $('.modal').modal();

        $(".anime").each(function () {
            if ($(this).attr("x") == 1) {
                $(this).children($(".animi")).attr("style", "transform: rotate(180deg);");
            }

        });

        $(".anime").click(function () {
            if ($(this).attr("x") == 0) {
                $(".anime").attr("x", "0");
                $(".animi").attr("style", "transform: rotate(0deg);");
                $(this).children($(".animi")).attr("style", "transform: rotate(180deg);");
                $(this).attr("x", "1");
            } else {
                $(this).children($(".animi")).attr("style", "transform: rotate(0deg);");
                $(this).attr("x", "0");
            }
        });

    });

</script>
<?php
    }
}
?>