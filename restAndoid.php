<?php
if ($_REQUEST['token_acesso'] == 'c-m35jf7k2gh34x6c2j45h7v3k56') {
    $conn = new PDO('mysql:host=' . $_REQUEST['endereco'] . ';dbname=' . $_REQUEST['nomeDB'], $_REQUEST['user'], $_REQUEST['password'] , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $Stmt = $conn->prepare($_REQUEST['sql']);
    $sql = strtolower($_REQUEST['sql']);
    if (substr($sql, 0, 3) == "sel") {
        if ($Stmt->execute()) {
            $arr = [];
            while ($linha = $Stmt->fetch()) {
                foreach ($linha as $atributo => $valor) {
                    if (isset($valor)) {
                        $valor = utf8_encode($valor);
                        $linha[$atributo]= $valor;
                    }
                }

                array_push($arr , $linha);
            }
            //var_dump($arr);


//var_dump($result);
            $teste = json_encode($arr);
            header('Content-type: application/json');
            echo $teste;
        } else {
            echo "[" . json_encode($Stmt->errorInfo()) . "]";
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
    echo "[" . json_encode(array("status" => "access_denied")) . "]";
}