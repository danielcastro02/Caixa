<?php

$conn = new PDO('mysql:host='.$_REQUEST['endereco'].';dbname='.$_REQUEST['nomeDB'], $_REQUEST['user'], $_REQUEST['password']);
$Stmt = $conn->prepare($_REQUEST['sql']);
if(substr($_REQUEST['sql'] , 0 , 3) == "sel"){
if($Stmt->execute()){
$arr = [];
while ($linha = $Stmt->fetch()){
	$arr[] = $linha;
}
$teste = json_encode($arr);
header('Content-type: application/json');
echo $teste;
}else{
	echo "[".json_encode(array("status"=>"false"))."]";
}
}else{
	header('Content-type: application/json');
	echo "[";
	if($Stmt->execute()){
	echo json_encode(array("status"=>"true" , "rowCount" => $Stmt->rowCount()));
	}else{
		echo json_encode(array("status"=>"false"));
	}
	echo "]";
}