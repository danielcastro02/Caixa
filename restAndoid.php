<?php
if($_REQUEST['token_acesso'] == 'c-m35jf7k2gh34x6c2j45h7v3k56') {
    $conn = new PDO('mysql:host=' . $_REQUEST['endereco'] . ';dbname=' . $_REQUEST['nomeDB'], $_REQUEST['user'], $_REQUEST['password']);
    $Stmt = $conn->prepare($_REQUEST['sql']);
    if (substr($_REQUEST['sql'], 0, 3) == "sel") {
        if ($Stmt->execute()) {
            $arr = [];
            while ($linha = $Stmt->fetch()) {
                //$arr[] = json_encode($linha);
                $arr[] = $linha;
            }
//var_dump($result);
            $teste = json_encode($arr);
            header('Content-type: application/json');
            echo $teste;
        } else {
            echo "[" . json_encode( $Stmt->errorInfo()) . "]";
        }
    } else {
        header('Content-type: application/json');
        echo "[";
        if ($Stmt->execute()) {
            echo json_encode(array("status" => "true", "rowCount" => $Stmt->rowCount()));
        } else {
            echo json_encode(array("status" => "false"));
        }
        echo "]";
    }
}else{
    echo "[".json_encode(array("erro"=>"access_denied"))."]";
}