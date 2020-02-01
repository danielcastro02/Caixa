<?php

include_once __DIR__ . '/conexao.php';
include_once __DIR__ . '/../Modelo/Anexo.php';

class AnexoPDO
{
    const REPO_PATH = "/Repo/Docs/";
    public function inserirAnexo(Anexo $anexo)
    {
        $nome_imagem = hash_file('md5', $_FILES['anexo']['tmp_name']);
        $ext = explode('.', $_FILES['anexo']['name']);
        $extensao = "." . $ext[(count($ext) - 1)];
        $extensao = strtolower($extensao);
        $webp = true;
        switch ($extensao) {
            case '.jpeg':
            case '.jfif':
            case '.jpg':
                imagewebp(imagecreatefromjpeg($_FILES['anexo']['tmp_name']), __DIR__ . '/../'.self::REPO_PATH.'/' . $nome_imagem . '.webp', 65);
                break;
            case '.svg':
                move_uploaded_file($_FILES['anexo']['tmp_name'], __DIR__ . '/../'.self::REPO_PATH.'/' . $nome_imagem . '.svg');
                $webp = false;
                break;
            case '.png':
                $img = imagecreatefrompng($_FILES['anexo']['tmp_name']);
                imagepalettetotruecolor($img);
                imagewebp($img, __DIR__ . '/../'.self::REPO_PATH.'/' . $nome_imagem . '.webp', 35);
                break;
            case '.webp':
                imagewebp(imagecreatefromwebp($_FILES['anexo']['tmp_name']), __DIR__ . '/../'.self::REPO_PATH.'/' . $nome_imagem . '.webp', 65);
                break;
            case '.bmp':
                imagewebp(imagecreatefromwbmp($_FILES['anexo']['tmp_name']), __DIR__ . '/../'.self::REPO_PATH.'/' . $nome_imagem . '.webp', 65);
                break;
            default:
                $_SESSION['toast'][] = "Erro ao carregar a foto";
                header('location: ../Tela/erroInterno.php');
                exit(0);
                break;
        }
        if($webp){
            $anexo->setCaminho(self::REPO_PATH.$nome_imagem.".webp");
        }else{
            $anexo->setCaminho(self::REPO_PATH.$nome_imagem.".svg");
        }
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into anexo values(default , :id_movimento , :caminho)");
        $stmt->bindValue(":id_movimento" , $anexo->getIdMovimento());
        $stmt->bindValue(":caminho" , $anexo->getCaminho());
        return $stmt->execute();
    }

    function selectAnexoIdMovimento($id_movimento){
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from anexo where id_movimento = :id_movimento");
        $stmt->bindValue(":id_movimento" , $id_movimento);
        $stmt->execute();
        if($stmt->rowCount()>0){
            return new Anexo($stmt->fetch());
        }else{
            return false;
        }
    }
}