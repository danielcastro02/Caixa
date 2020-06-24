<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php
        include_once '../Base/header.php';
        include_once '../Modelo/Parametros.php';
        include_once '../Modelo/Usuario.php';
        include_once '../Controle/usuarioPDO.php';
        include_once '../Controle/codigoConfirmacaoPDO.php';
        $codigoConfirmacaoPDO = new codigoConfirmacaoPDO();
        $parametros = new parametros();
        $usuarioPDO = new UsuarioPDO();
        if(isset($_GET['codigo'])) {
            $id_usuario = $codigoConfirmacaoPDO->verificaCodigoCompleta($_GET['codigo']);
            if ($id_usuario){
                $user = new usuario($usuarioPDO->selectUsuarioId_usuario($id_usuario)->fetch());
            } else {
                $usuarioPDO->addToast("Este link não é mais valido!");
                header("Location: ./acessoNegado.php");
            }
        } else {
            $usuarioPDO->addToast("Você não vai conseguir burlar...");
            header("Location: ./acessoNegado.php");
        }
    ?>
    <title><?php echo $parametros->getNomeEmpresa(); ?></title>

<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
?>
<main>
    <div class="hide-on-med-and-down" style="margin-top: 1vh;"></div>
    <div class="row">
        <form action="../Controle/usuarioControle.php?function=inserirUsuarioCompletaCadastro" id="formUsuario"class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1" method="post" enctype="multipart/form-data">
            <div class="row center">
                <h4 class="textoCorPadrao2">Complete seu cadastro</h4>
                <input name="id_usuario" value="<?php echo $user->getId_usuario() ?>" hidden>
                <div class="row">
                    <a href="#!" id="linkfoto" class="center col s4 offset-s4">
                        <div style="margin: auto" class="circle ">
                            <img class=" prev-img fotoPerfil center" width="150" height="150"
                                 src="../Img/Perfil/default.png">
                        </div>
                        <div class="fotoPerfil" style="position: relative; margin-top: -155px; z-index: 2">
                            <div class="linkfoto white-text center">Adicionar Foto</div>
                        </div>
                    </a>
                </div>
                <div class="file-field input-fiel">
                    <div>
                        <input type="file" class="file-chos" name="imagem" id="btnFile"
                               accept=".jpg,.jpeg,.bmp,.png,.jfif,.svg,.webp" hidden>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate"  name="imagem" type="text" placeholder="Selecione a foto"
                               hidden>
                    </div>
                </div>
                <div class="input-field col s12 l7">
                    <input id="nome" type="text" name="nome" required="true" value="<?php echo $user->getNome() ?>">
                    <label for="nome">Nome</label>
                </div>
                <div class="input-field col s12 l5">
                    <input type="text" name="cpf" id="cpf" maxlength="14">
                    <label for="cpf">CPF</label>
                </div>
                <div class="input-field col l7 s12">
                    <input id="email" type="email" name="email" value="<?php echo $user->getEmail() ?>" readonly>
                    <label for="email" class="active">Email</label>
                </div>
                <div class="input-field col s12 l5">
                    <input type="text" name="telefone" id="telefone">
                    <label for="telefone">Telefone</label>
                </div>
                <div class="input-field col l4 s12">
                    <input type="text" name="data_nasc" id="dataNascimento" maxlength="10">
                    <label for="dataNasc" class="active">Data de nascimento</label>
                </div>
                <div class="input-field col s12 l4">
                    <input type="password" name="senha1" id="senha1reg" required>
                    <label for="senha1Mod" class="active">Senha</label>
                </div>
                <div class="input-field col s12 l4">
                    <input type="password" name="senha2" id="senha2reg" required>
                    <label for="senha2Mod">Repita a senha</label>
                </div>
            </div>
            <div class="row center">
                <a href="../index.php" class="corPadrao3 btn waves-effect ">Voltar</a>
                <button type="submit" class="btn waves-effect  corPadrao2" >Registrar</button>
            </div>
        </form>
    </div>
</main>
<?php
    include_once '../Base/footer.php';
?>
<script>
    $("#cpf").mask('000.000.000-00');
    $("#dataNascimento").mask('00/00/0000');
    $("#telefone").mask('(00) 00000-0000');
    $("#formUsuario").submit(function () {

        if($("#senha1reg").val() != $("#senha2reg").val()){
            M.toast({html: 'As senhas não conhecidem!', classes: 'rounded'});
            return false;
        }

        if(verificaData($("#dataNascimento"))==false){
            return false;
        }

        if ($("#telefone").val().length !== 15 && $("#telefone").val().length > 0) {
            M.toast({html: 'Digite um número de celular válido!', classes: 'rounded'})
            return false;
        } else {
            var dados = $(this).serialize();
            var resposta = true;
            $.ajax({
                url: '../Controle/usuarioControle.php?function=verificaTelefone',
                type: 'POST',
                data: dados,
                async: false,
                success: function (data) {
                    if (data == 'true') {
                        resposta = false;
                        $('#telefone').attr('class', 'invalid');
                        M.toast({html: "O telefone já existe no sistema!", classes: 'rounded'});
                    } else {
                        $('#telefone').attr('class', 'valid');
                    }
                }
            });
            return resposta;
        }
    });

    $("#linkfoto").click(function () {
        M.updateTextFields();
        $('#btnFile').click();
        carregarFoto();
        setFotoDefault();
    });

    function setFotoDefault() {
        $(".prev-img").removeAttr("src").attr("src", "../Img/Perfil/default.png");
    }

    function carregarFoto() {
        const s = document.querySelector.bind(document);
        const previewImg = s('.prev-img');
        const fileChooser = s('.file-chos');

        fileChooser.onchange = e => {
            const fileToUpload = e.target.files.item(0);
            const reader = new FileReader();
            reader.onload = e => previewImg.src = e.target.result;
            $('#loader').show();
            reader.readAsDataURL(fileToUpload);
        };
    }


</script>
</body>
</html>

