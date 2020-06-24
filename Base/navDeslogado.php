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
include_once $pontos . 'Modelo/Parametros.php';
$parametros = new parametros();
$url = $_SERVER['REQUEST_URI'];

require_once $pontos . 'vendor/autoload.php'; // change path as needed
include_once $pontos . 'Modelo/Parametros.php';
?>

<nav class="nav-extended white" style="position: relative;">
    <div class="nav-wrapper" style="margin-left: auto; margin-right: auto;">
        <?php if ($parametros->getIsFoto() == 1) { ?>
            <a  href="https://mastereduca.com" class="brand-logo left">
                <img class="responsive-img" src="<?php echo $pontos . $parametros->getLogo() . '?' . $numeruzinho; ?>" style="max-height: 60px; height:auto; width: auto; margin-left: 5px;">

            </a>
        <?php } else {
            ?>
            <a  href="https://mastereduca.com" class="brand-logo black-text left">
                <?php echo $parametros->getNomeEmpresa(); ?>
            </a> 
        <?php } ?>

        <ul class="right">
            <li>
                <a class="black-text modal-trigger" href="#modalLogin">
                    <div class="chip detalheSuave">
                        Entrar
                    </div>
                </a>
            </li>
            <li>
                <a class="black-text modal-trigger hide-on-med-and-down" href="#modalRegistro" id="registro">
                    <div class="chip detalheSuave">
                        Registre-se
                    </div>
                </a>
            </li>

        </ul>
    </div>
</nav>

<div id="modalRegistro" class="modal">
    <div class="modal-content">
        <h4>Registre-se</h4>
        <div class="row">
            <form action="<?php echo $pontos; ?>Controle/usuarioControle.php?function=inserirUsuario" id="formModal" method="post">
                <div class="row center">
                    <div class="input-field col s12 l6">
                        <input id="Nome" type="text" name="nome"required="true">
                        <label for="Nome">Nome</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <?php
                        if($parametros->getMetodoAutenticacao()==1){
                            ?>
                            <input type="email" name="email" required="true" id="email">
                            <label for="email">E-mail</label>
                            <?php
                        }else{
                            ?>
                            <input type="text" name="telefone" required="true" id="telefone">
                            <label for="telefone">Telefone</label>
                            <?php
                        }
                        ?>
                    </div>

                    <div class = "input-field col s12 l6">
                        <input type="password" name="senha1" id="senha1Mod" required="true">
                        <label for="senha1Mod">Senha</label>
                    </div>
                    <div class = "input-field col s12 l6">
                        <input type="password" name="senha2" id="senha2Mod" required="true">
                        <label for="senha2Mod">Repita a senha</label>
                    </div>
                </div>
                <div class="row center">
                    <label>
                        <input type="checkbox" required/>
                        <span>Eu concordo com a política de privacidade disponível 
                            <a href="https://markeyvip.com/Portfolio/politica.php"target="_blank">Neste link</a>
                        </span>
                    </label>
                </div>
                <style>
                    .g-recaptcha>div{
                        margin-right: auto;
                        margin-left: auto;
                    }
                </style>
                <div class="row">
                    <span class="g-recaptcha" style="padding-left: auto; padding-right: auto;" data-sitekey="6LdSGcIUAAAAAMYl8rJbwwgDioD8alzSK19ouPor"></span>
                </div>
                <div class="modal-footer">
                    <div class="row center">
                        <a href="#!" class="modal-close waves-effect waves-green btn waves-effect -flat corPadrao3 white-text">Cancelar</a>
                        <button type="submit" class="waves-effect waves-green btn waves-effect -flat corPadrao2 white-text">Registrar</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div id="modalLogin" class="modal transparent z-depth-0">
    <div class="row">
        <div class="col l6 offset-l3 m8 s12 offset-m2 offset-s0 card" >
            <div class="modal-content" style="max-height: 100%; overflow: auto;">
                <h4>Indentifique-se</h4>
                <div class="row">
                    <form action="<?php echo $pontos; ?>Controle/usuarioControle.php?function=login"  method="post">
                        <div class="row center">
                            <div class="input-field col s12">
                                <?php
                                echo "<input type='text' name='url' value='.." . $url . "' hidden='true'/>";
                                ?>
                                <input id="Usuario" type="text" name="usuario" required="true">
                                <label for="Usuario">Celular ou e-mail</label>
                            </div>

                            <div class = "input-field col s12">
                                <input id="Senha" type="password" name="senha">
                                <label for="Senha">Senha</label>
                            </div>
                        </div>
                        <div class="row center">
                            <a href="#!" class="modal-close waves-effect waves-green btn waves-effect -flat corPadrao3 white-text">Cancelar</a>
                            <button type="submit" class="waves-effect waves-green btn waves-effect -flat corPadrao2 white-text">Entrar</button>
                        </div>
                        <div class="row center">
                            <a class="teal-text" href="<?php echo $pontos ?>Tela/recuperaSenha.php">Esqueci minha senha!</a>
                            <br>
                            Ainda não está cadastrado? 
                            <a class="teal-text modal-trigger" href="#modalRegistro">Cadastre-se</a>
                        </div>
                        <?php
                        if (isset($_GET['msg'])) {
                            if ($_GET['msg'] == "senhaerrada") {
                                echo "<script>M.toast({html: 'Você errou alguma coisa!<br> Ainda não é cadastrado? <a class='teal-text modal-trigger' href='#modalRegistro'>Cadastre-se</a>', classes: 'rounded'});</script>";
                            }
                        }
                        ?>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('.dropdown-trigger').dropdown({
        coverTrigger: false
    });
    $('.modal').modal();
    $("#telefoneModal").mask("(00) 00000-0000");
    $("#telefone").mask("(00) 00000-0000");


    $("#formModal").submit(function () {
        if ($("#telefoneModal").val().length != 15) {
            M.toast({html: 'Digite um número de celular válido!', classes: 'rounded'})
            return false;
        } else {
            var dados = $(this).serialize();
            var resposta = true;
            $.ajax({
                url: '<?php echo $pontos; ?>Controle/usuarioControle.php?function=verificaTelefone',
                type: 'POST',
                data: dados,
                async: false,
                success: function (data) {
                    if (data == 'true') {
                        resposta = false;
                        $('#telefoneModal').attr('class', 'invalid');
                        M.toast({html: "O telefone já existe no sistema!", classes: 'rounded'});
                    } else {
                        $('#telefoneModal').attr('class', 'valid');
                    }
                }
            });
            if ($("#senha1Mod").val() != $("#senha2Mod").val()) {
                resposta = false;
                M.toast({html: "Senhas não coincidem!", classes: 'rounded'});
            }
            if (resposta) {
                $("#preLoader").show();
            }
            return resposta;
        }
    });
</script>