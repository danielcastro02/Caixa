<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once '../Modelo/Usuario.php';
$logado = new usuario(unserialize($_SESSION['logado']));
?>
<form action="../Controle/usuarioControle.php?function=updateSenha" method="POST" id="formTrocaSenha">
    <div class="modal-content">
        <div class="row">
            <h4>Editar Dados</h4>
            <input type="text" name="id_usuario" hidden="true" value="<?php echo $logado->getId_usuario() ?>">
            <div class="input-field col l4 s12">
                <input id="oldSenha" type="password" name="oldSenha">
                <label for="oldSenha">Senha antiga</label>
            </div>
            <div class="input-field col l4 s12">
                <input id="senha1" type="password" name="senha1" required>
                <label for="senha1">Nova Senha</label>
            </div>
            <div class="input-field col l4 s12">
                <input id="senha2" type="password" name="senha2" required="true">
                <label for="senha2">Repita a nova senha</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn waves-effect  corPadrao3">Cancelar</a>
        <button type="submit" class="btn waves-effect  corPadrao2">Confirmar</button>
    </div>
</form>
