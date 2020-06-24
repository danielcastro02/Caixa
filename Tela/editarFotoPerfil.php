<?php
if(!isset($_SESSION)){
    session_start();
}
?>
<div class="row">
    <form class="col s12" action="../Controle/usuarioControle.php?function=alteraFoto" method="post" enctype="multipart/form-data">
        <input type="file" class="file-chos" id="btnFile" name="imagem" hidden="true">
        <input class="file-path validate" type="text" hidden="true">
        <div class="row center" style="margin-top: 20px;">
            <h5>Pré Visualização</h5>
            <img  class="fotoPerfil prev-img" style="background-size: cover;
                  background-position: center;
                  background-repeat: no-repeat;
                  ">
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn waves-effect  corPadrao3">Cancelar</a>
            <button type="submit" name="SendCadImg" value="true" class="btn waves-effect  corPadrao2">Confirmar</button>
        </div>
    </form>

</div>

<script>

    

    const $ = document.querySelector.bind(document);
    const previewImg = $('.prev-img');
    const fileChooser = $('.file-chos');

    fileChooser.onchange = e => {
        const fileToUpload = e.target.files.item(0);
        const reader = new FileReader();

        // evento disparado quando o reader terminar de ler 
        reader.onload = e => previewImg.src = e.target.result;

        // solicita ao reader que leia o arquivo 
        // transformando-o para DataURL. 
        // Isso disparará o evento reader.onload.
        reader.readAsDataURL(fileToUpload);
    };
</script>