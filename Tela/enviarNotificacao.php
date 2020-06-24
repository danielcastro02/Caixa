<?php
include_once '../Base/requerGodMode.php';
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

    <div class="row">
        <div class="card col s10 offset-s1">
            <form action="../Controle/notificacaoControle.php?function=notificaPersonalizada" method="post">
                <div class="row center">
                    <h5>Enviar notificação</h5>
                </div>
                <div class="row">
                    <div class="col s6 input-field">
                        <input name="title" id="titulo" type="text"/>
                        <label for="titulo">Título</label>
                    </div>
                    <div class="col s6 input-field">
                        <select name="destinatarios[]" id="destinatarios" multiple>
                            <?php
                            include_once '../Controle/usuarioPDO.php';
                            include_once '../Modelo/Usuario.php';
                            $usuarioPDO = new UsuarioPDO();
                            $stmtUsuario = $usuarioPDO->selectUsuarioHasToken();
                            if ($stmtUsuario) {
                                while ($linha = $stmtUsuario->fetch()) {
                                    $usuario = new usuario($linha);
                                    echo "<option value='" . $usuario->getToken() . "'>" . $usuario->getNome() . " - " . $usuario->getTelefone() . "</option>";
                                }
                            } else {
                                echo "<option value=''>Nenhum Usuário</option>";
                            }
                            ?>
                        </select>
                        <label for="destinatarios">Destinatários</label>
                    </div>
                    <div class="col s12 input-field">
                        <textarea class="materialize-textarea" name="body" id="body"></textarea>
                        <label for="body">Mensagem</label>
                    </div>
                </div>
                <div class="row center">
                    <a class="btn corPadrao3" href="../index.php">Voltar</a>
                    <button type="submit" class="btn corPadrao2">Enviar</button>
                </div>
            </form>
        </div>

    </div>
    <script>
        $('select').formSelect();
    </script>
</main>
<?php
include_once '../Base/footer.php';
?>
</body>
</html>

