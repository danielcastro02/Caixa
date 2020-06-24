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
include_once $pontos . "Modelo/Usuario.php";
include_once $pontos . 'Modelo/Parametros.php';
$parametros = new parametros();
$logado = new usuario(unserialize($_SESSION['logado']));
?>
<div class="navbar-fixed">
    <nav class="nav-extended white">
        <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">

            <a href="#" data-target="slide-out" class="sidenav-trigger">
                <i class="material-icons black-text">menu</i>
            </a>
            <?php if ($parametros->getIsFoto() == 1) { ?>
                <a  href="https://mastereduca.com" class="brand-logo">
                    <img class="responsive-img hide-on-small-only" src="<?php echo $pontos . $parametros->getLogo() . '?' . $numeruzinho; ?>" style="max-height: 60px; height:auto; width: auto; margin-left: 5px;">
                    <img class="responsive-img hide-on-med-and-up" src="<?php echo $pontos . $parametros->getLogo() . '?' . $numeruzinho; ?>" style="max-height: 55px; height:auto; width: auto; margin-left: 5px;">
                </a>
            <?php } else {
                ?>
                <a  href="https://mastereduca.com" class="brand-logo black-text">
                    <?php echo $parametros->getNomeEmpresa(); ?>
                </a> 
            <?php } ?>
            <ul class="right hide-on-med-and-down">
                <li>
                    <a href="#!" class="dropdown-trigger black-text" data-target='dropPessoal'>
                        <div class="chip detalheSuave ">
                            <div class="left-align " style="background-image: url('<?php echo $logado->getIs_foto_url() == 1 ? $logado->getFoto() : $pontos . $logado->getFoto(); ?>'); 
                                 float: left;
                                 margin: 0 8px 0 -12px;
                                 border-radius: 50%;
                                 height: 32px; width: 32px;
                                 background-position: center;
                                 background-size: cover;
                                 background-position: center;
                                 background-repeat: no-repeat;
                                 object-fit: cover;
                                 object-position: center;
                                 ">
                            </div>
                            <?php echo $logado->getNome() ?>
                        </div>

                    </a>
                    <ul id='dropPessoal' class=' dropdown-content'>
                        <li><a href="<?php echo $pontos ?>Tela/perfil.php" id="linkprestador" class="black-text modal-trigger">Meu Perfil</a></li>
                    </ul>
                </li>

                <!--Botão de Inicio-->
                <li>
                    <a href="<?php echo $pontos; ?>./index.php">
                        <div class="chip detalheSuave">
                            <img style="height: 20px; width: 20px; margin-top: 12%" class="" src="<?php echo $pontos ?>Img/Icones/iconeInicio.svg">
                            Início
                        </div>
                    </a>
                </li>
                <li><a href="<?php echo $pontos ?>Tela/meusEncaminhamentos.php"  class="black-text modal-trigger"><div class="chip detalheSuave">Encaminhamentos</div></a></li>

                <li>
                    <a class="btSair black-text" href="<?php echo $pontos; ?>Controle/usuarioControle.php?function=logout&url=<?php echo $_SERVER["REQUEST_URI"]; ?>" class="black-text">
                        <div class="chip detalheSuave ">
                            Sair
                        </div>
                    </a>
                </li>

            </ul>
        </div>
    </nav>
</div>

<!--Teste de SidNavBar-->

<ul id="slide-out" class="sidenav">
    <li><div class="user-view">
            <div class="background">
                <img src="<?php echo $pontos; ?>Img/bg1.jpg">
            </div>
            <a href="#user"><div class="fotoPerfil left-align" style="background-image: url('<?php echo $pontos . $logado->getFoto(); ?>');background-size: cover;
                                 background-position: center;
                                 background-repeat: no-repeat;
                                 max-height: 20vh; max-width: 20vh;">
                </div>
            </a>
            <a href="#name"><span class="white-text name"><?php echo $logado->getNome(); ?></span></a>
            <a href="#email"><span class="white-text email"><?php echo $logado->getEmail(); ?></span></a>
        </div></li>
    <ul class="collapsible">
        <a href="<?php echo $pontos; ?>./index.php" class="black-text">
            <li>
                <div class="headerMeu" style="margin-left: 16px">
                    Início
                </div>
            </li>
        </a>
        <a href="<?php echo $pontos ?>Tela/meusCursos.php"  class="black-text">
            <li>
                <div class="headerMeu" style="margin-left: 16px">
                    Meus Cursos
                </div>
            </li>
        </a>
        <li class="active">
            <div class="collapsible-header anime" x="1">Meu Perfil<i class="large material-icons right animi">arrow_drop_down</i></div>
            <div class="collapsible-body">
                <ul class="grey lighten-2">
                    <li><a href="<?php echo $pontos ?>Tela/perfil.php" id="linkprestador" class="black-text modal-trigger">Ver Meu Perfil</a></li>
                    <li><a href="<?php echo $pontos ?>Tela/meusAgendamentos.php" class="black-text modal-trigger">Meus agendamentos</a></li>
                </ul>
            </div>
        </li>
        <a class="black-text modal-trigger" href="#modalSair">
            <li>
                <div class="headerMeu black-text" style="margin-left: 16px">
                    Sair
                </div>
            </li>
        </a>
    </ul>
</ul>
<div id="modal25" class="modal">
    <div class="modal-content">
        <h4>Desculpe interromper</h4>
        <p>Por favor, cadastre seu E-mail, é importante, enviamos às notificações do sistema por lá!</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn waves-effect -flat">Não obrigado!</a>
        <a href="./Tela/perfil.php?pulseDados" class="modal-close waves-effect waves-green btn waves-effect -flat">Ok vamos lá!</a>
    </div>
</div>
<div id="modalSair" class="modal">
    <div class="modal-content">
        <h4>Atenção</h4>
        <p>Você realmente deseja sair? Se sair não receberá nenhuma notificação do app...</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn corPadrao2">Cancelar</a>
        <a href="<?php echo $pontos; ?>Controle/usuarioControle.php?function=logout&url=<?php echo $_SERVER["REQUEST_URI"]; ?>" class="btSair modal-close waves-effect waves-green btn red darken-2">Sair</a>
    </div>
</div>
<script>

    $('.sidenav').sidenav();
    $('.collapsible').collapsible();

    $('.dropdown-trigger').dropdown({
        coverTrigger: false
    });
    $('#modal25').modal();
    $('#modalSair').modal();
    var instanceASDF = M.Modal.getInstance(document.getElementById('modal25'));
<?php
if (($logado->getEmail() == null || "") && (!isset($_SESSION['ignore_null_mail']))) {
    echo "instanceASDF.open();";
    $_SESSION['ignore_null_mail'] = 'true';
}
?>  $(".anime").each(function (){
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

    if (interfaceAndroid != undefined) {
        $('.btSair').click(function () {
            $.ajax({url: '<?php echo $pontos ?>Controle/usuarioControle.php?function=eliminaToken'});
            interfaceAndroid.logOut();
        });
    }

</script>