<?php
    include_once '../Base/requerLogin.php';
    include_once '../Modelo/Usuarios.php';
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_SESSION['logado'])){
        $logado = new usuarios(unserialize($_SESSION['logado']));
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <?php
        include_once '../Base/header.php';
        ?>
    <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row" style="">
                <form action="../Controle/usuariosControle.php?function=inserirUsuarios" class="card col l8 offset-l2 m10 offset-m1 s12" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Registre-se</h4>
                        <div class="input-field col s12 l6">
                            <input type="text" name="nome">
                            <label>nome</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <input type="text" name="usuario">
                            <label>usuario</label>
                        </div>
                        <div class = "input-field col s12 l6">
                            <input type="password" name="senha1">
                            <label>Senha</label>
                        </div>
                        <div class = "input-field col s12 l6">
                            <input type="password" name="senha2">
                            <label>Repita a senha</label>
                        </div>
                        <?php if ($logado->getAdmin() == 1) {?>
                            <label>
                                <input type="checkbox" class="filled-in" name="admin" />
                                <span class="black-text">ADM</span>
                            </label>
                        <?php } ?>
                    </div>
                    <div class="row center">
                        <a href="../index.php" class="corPadrao3 btn">Voltar</a>
                        <input type="submit" class="btn corPadrao2" value="Login">
                        <?php
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == "senhaerrada") {
        echo "Senhas não coincidem!";
    }
}
?>
                    </div>
                    
                </form>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

