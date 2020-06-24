<?php
//include_once '../Base/requerAdm.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php
        include_once '../Base/header.php';
        include_once '../Controle/usuarioPDO.php';
        include_once '../Modelo/Usuario.php';
        include_once '../Modelo/Parametros.php';
        $parametros = new parametros();
        $usuarioPDO = new usuarioPDO();
        ?>
        <title><?php echo $parametros->getNomeEmpresa(); ?></title>
    <body class="homeimg">
        <?php
        include_once '../Base/iNav.php';
        ?>
        <main>
            <div class="row " style="margin-top: 5vh;">
                <h4 class='center'>Listagem Clientes</h4>
                <div class="table-responsive-vertical hide-on-med-and-down">
                    <table class="striped card col s10 offset-s1 center table table-bordered table-striped table-hover table-mc-red">
                        <div class="row center">
                            <div class="input-field col s12 m6 l4 offset-m3 offset-l4">
                                <input type="text" name="pesquisa" id="pesquisa"/>
                                <label for="pesquisa">Nome ou Celular</label>
                            </div>
                        </div>
                        <thead>
                            <tr class="center">
                                <td class='center'>Nome</td>
                                <td class='center'>Cpf</td>
                                <td class='center'>Email</td>
                                <td class='center'>Telefone</td>
                                <td class='center'>Perfil</td>
                                <td class='center'>Excluir</td>
                            </tr>
                        </thead>
                        <tbody id="corpoTabela">
                            <?php
                            $stmt = $usuarioPDO->selectUsuario();

                            if ($stmt) {
                                while ($linha = $stmt->fetch()) {
                                    $usuario = new usuario($linha);
                                    if ($usuario->getDeletado() != 1 && $usuario->getPre_cadastro()!=2) {
                                        ?>
                                        <tr>
                                            <td class="center" data-title="Nome"><?php echo $usuario->getNome() ?></td>
                                            <td class="center cpf" data-title="CPF"><?php echo $usuario->getCpf(); ?></td>
                                            <td class="center" data-title="Email"><?php echo $usuario->getEmail() ?></td>
                                            <td class="center telefone" data-title="Telefone"><?php echo $usuario->getTelefone() ?></td>
                                            <td class="center">
                                                <a class='btn waves-effect  corPadrao2' href='../Tela/detalhesUsuario.php?id_usuario=<?php echo $usuario->getId_usuario() ?>'>Ver Perfil</a>
                                            </td>
                                            <td class="center" data-title="Excluir">
                                                <a class="btn waves-effect  red darken-2" href="#!" onclick="excluir(<?= $usuario->getId_usuario() ?>)"><i class="material-icons">delete</i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="row container hide-on-large-only">
                <div class="row center">
                    <div class="input-field col s12 m6 l4 offset-m3 offset-l4">
                        <input id="pesquisaa" type="text" name="pesquisaa" />
                        <label for="pesquisaa">Nome ou Celular</label>
                    </div>
                </div>
                <ul class="collapsible" id="corpoCollapsible">
                    <?php
                    $stmt = $usuarioPDO->selectUsuario();
                    if ($stmt) {
                        while ($linha = $stmt->fetch()) {
                            $usuario = new usuario($linha);
                            if ($usuario->getDeletado() != 1) {
                                ?>
                                <li>
                                    <div class="collapsible-header">
                                        <div class="left-align" style="background-image: url('<?php echo $usuario->getIs_foto_url()==1? $usuario->getFoto() :$pontos . $usuario->getFoto(); ?>'); 
                                             float: left;
                                             margin: 0 8px 0 -5px;
                                             border-radius: 50%;
                                             height: 25px; width: 25px;
                                             background-position: center;
                                             background-size: cover;
                                             background-position: center;
                                             background-repeat: no-repeat;
                                             object-fit: cover;
                                             object-position: center;
                                             ">
                                        </div>
                                        <?php echo $usuario->getNome(); ?>
                                    </div>
                                    <div class="collapsible-body grey lighten-4">
                                        <span class="bold">CPF: </span> 
                                        <span><?php
                                            if ($usuario->getCpf() != "") {
                                                $vetCPF = explode(".", $usuario->getCpfPontuado());
                                                echo $vetCPF[0] . ".***.***-**";
                                            } else {
                                                echo '***.***.***-**';
                                            }
                                            ?>
                                        </span>
                                        <p>
                                            <span class="bold">Email: </span>
                                            <span><?php echo $usuario->getEmail() ?></span>
                                        </p>
                                        <p>
                                            <span class="bold">Telefone: </span>
                                            <span class="telefone"><?php echo $usuario->getTelefone() ?></span>
                                        </p>
                                        <p class="center-align">
                                            <a class="btn waves-effect  red darken-2 hide-on-large-only hide-on-small-and-down" href="#!" onclick="excluir(<?= $usuario->getId_usuario() ?>)"><i class="material-icons">delete</i></a>

                                        </p>
                                        <p class="center hide-on-med-and-up">
                                            <a class="btn waves-effect  red darken-3" href="#!" onclick="excluir(<?= $usuario->getId_usuario() ?>)">Excluir</a>
                                        </p>
                                    </div>
                                </li>
                                <?php
                            }
                        }
                    }
                    ?>


                </ul>
            </div>

            <div class="modal" id="modalExcluir">
                <div class="modal-content">
                    <h4>Atenção</h4>
                    <div class="row">
                        <h6>Voce realmente deseja excluir um usário?</h6>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="modal-close waves-effect waves-green btn-flat corPadrao2 white-text">Cancelar</a>
                        <a href="#!" class="modal-close waves-effect waves-green btn-flat red darken-3 white-text excluir">Excluir</a>
                    </div>
                </div>
            </div>
            <div class="fixed-action-btn" <?php echo $parametros->getActiveChat() == 1 ? "style='margin-bottom: 70px'" : "" ?>>
                <a class="btn-floating btn-large red  " href="./cadastroUsuarioAdm.php">
                    <i class="large material-icons corPadrao2">add</i>
                </a>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
        <script>
//            alert(<?php echo $usuario->getCpf(); ?>);
            $("#pesquisa").keyup(function () {
                $("#corpoTabela").load('./pesquisaUsuario.php?pesquisa=' +  encodeURI($(this).val()));
            });

            $("#pesquisaa").keyup(function () {
                $("#corpoCollapsible").load('./pesquisaUsuarioCollapsible.php?pesquisa=' + encodeURI($(this).val()));
            });

            $(".telefone").mask("(00) 00000-0000");
            $(".cpf").mask("000.000.000-00");
            $(".data").mask("00/00/0000");

            var idExcluir;
            $('.modal').modal();
            function excluir(id) {
                $('#modalExcluir').modal('open');
                idExcluir = id;
            }
            $('.excluir').click(function () {
                window.location.href = "../Controle/usuarioControle.php?function=deletar&id=" + idExcluir + "";
            });

            $('.collapsible').collapsible();
        </script>
    </body>
</html>

