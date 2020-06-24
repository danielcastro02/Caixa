<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once '../Modelo/Usuario.php';
$logado = new usuario(unserialize($_SESSION['logado']));
?>
<form action="../Controle/usuarioControle.php?function=updateUsuario" id="formUpdateTudo" method="POST">
    <div class="modal-content">
        <div class="row">
            <h4>Editar Dados</h4>
            <input type="text" name="id_usuario" hidden="true" value="<?php echo $logado->getId_usuario() ?>">
            <div class="input-field col l6 s12">
                <input id="nome" type="text" name="nome" value="<?php echo $logado->getNome() ?>">
                <label for="nome">Nome:</label>
            </div>
            <div class="input-field col l6 s12">
                <input type="text" name="cpf" value="<?php echo $logado->getCpf() ?>" id="cpf">
                <label for="cpf">CPF:</label>
            </div>
            <div class="input-field col l8 s12">
                <input id="email" type="email" name="email" id="email" class="tooltipped" data-position="rigth" data-tooltip="Alterar o E-mail exigira reativação da conta!" value="<?php echo $logado->getEmail() ?>">
                <label for="email">Email:</label>
<!--                <p class="red-text" style="display: none;" id="mostrar">Alterar o E-mail exigira reativação da conta!</p>-->
            </div>
            <div class="input-field col l4 s12">
                <input type="text" name="telefone" value="<?php echo $logado->getTelefone() ?>" id="telefone">
                <label for="telefone">Telefone:</label>
            </div>
            <div class="input-field col l4 s12">
                <input type="text" name="data_nasc" value="<?php echo $logado->getData_nascExibicao() ?>" id="dataNasc">
                <label for="dataNasc">Data de nascimento:</label>
            </div>
        </div>
    </div>
    <div class="row center">
        <a href="#!" class="modal-close waves-effect waves-green btn waves-effect  corPadrao3">Cancelar</a>
        <button type="submit" class="btn waves-effect  corPadrao2">Confirmar</button>
    </div>
</form>

<script>
    $("#formUpdateTudo").submit(function () {
        var dados = $(this).serialize();
        var resposta = true;
        $.ajax({
            url: '../Controle/usuarioControle.php?function=verificaEmail',
            type: 'POST',
            data: dados,
            async: false,
            success: function (data) {
                if (data == 'true') {
                    resposta = false;
                    $('#email').attr('class', 'invalid');
                    M.toast({html: "O email já existe no sistema!", classes: 'rounded'});
                } else {
                    $('#email').attr('class', 'valid');
                }
            }
        });
        return resposta;
    });

</script>
