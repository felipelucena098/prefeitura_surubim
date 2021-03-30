<?php 
require_once("../../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != '1'){
    echo "<script language='javascript'> window.location='../login.php' </script>";

}

$nome = $_POST['nome'];
$s_documento = $_POST['s_documento'];
$s_matricula = $_POST['s_matricula'];
$valor_b = $_POST['valor_b'];


$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];
$id = $_POST['txtid2'];




if($id == "" ){
	$res = $pdo->prepare("INSERT INTO situacao SET nome = :nome, s_documento = :s_documento, s_matricula = :s_matricula, valor_b = :valor_b");


	$res->bindValue(":nome", $nome);
	$res->bindValue(":s_documento", $s_documento);
	$res->bindValue(":s_matricula", $s_matricula);
	$res->bindValue(":valor_b", $valor_b);


	$res->execute();

	echo 'Salvo com Sucesso!';

	exit();
	
}



	if($id != ""){

	$res2 = $pdo->prepare("UPDATE dados_pessoais SET  documentos = :documentos, limitar_update = '1' WHERE id = '$id'");

	move_uploaded_file($_FILES['documentos']['tmp_name'], $dir.$nome_arquivo);

	$res2->bindValue(":documentos", $id_usuario);

	$res2->execute();

	echo 'Salvo com Sucesso!';
}



?>