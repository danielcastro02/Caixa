<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logado'])) {
    header('location: ../index.php');
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
    <div class='hide-on-small-and-down' style="margin-top: 15vh;"></div>
    <div class="row">
        <form action="../Controle/usuarioControle.php?function=login"
              class="card col l6 offset-l3 m8 offset-m2 s10 offset-s1 " method="post">
            <div class="row center">
                <h4 class="textoCorPadrao2">Entrar</h4>
                <div class="input-field col s10 offset-s1">
                    <?php
                    if (isset($_GET['url'])) {
                        echo '<input type="text" hidden="true" name="url" value="' . $_GET['url'] . '"/>';
                    }
                    ?>
                    <input id="telefoneEmail" type="text" name="usuario" required>
                    <label for="telefoneEmail">Telefone ou E-mail</label>
                </div>
                <div class="input-field col s10 offset-s1">
                    <input id="senha" type="password" name="senha">
                    <label for="senha">Senha</label>
                </div>
            </div>
            <div class="row center">
                <a href="../index.php" class="corPadrao3 btn waves-effect ">Voltar</a>
                <button type="submit" class="btn waves-effect white-text corPadrao2">Entrar</button>
                <div class="row center">
                    <a class="teal-text" href="./recuperaSenha.php">Esqueci minha senha!</a>
                    <br>
                    Ainda não está cadastrado?
                    <a class="teal-text modal-trigger" href="#modalRegistro">Cadastre-se</a>
                </div>
                <div class='row'>
                    <?php
                    if (isset($_GET['msg'])) {
                        if ($_GET['msg'] == "erro") {
                            echo "<script>M.toast({html: \"Você errou alguma coisa!<br> Ainda não é cadastrado? <a class='btn-flat toast-action textoCorPadrao3 modal-trigger' href='#modalRegistro'>Cadastre-se</a>\", classes: 'rounded'});</script>";
                        }
                    }
                    ?>
                </div>
            </div>

        </form>
    </div>
</main>
<script>
    if (interfaceAndroid != undefined) {
        toast.makeToast("Senha redefinida!");
        interfaceAndroid.logOut();
    }
</script>
<?php
include_once '../Base/footer.php';
?>
</body>
</html>

