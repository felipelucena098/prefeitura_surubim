<?php 
require_once("../../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != '1'){
    echo "<script language='javascript'> window.location='../login.php' </script>";

}


$n_agencia = $_POST['n_agencia'];
$banco = $_POST['banco'];
$cod_op = $_POST['cod_op'];
$tipo_conta = $_POST['tipo_conta'];
$n_conta = $_POST['n_conta'];
$renda = $_POST['renda'];
$renda_f = $_POST['renda_f'];


$antigo = $_POST['antigo'];
$id = $_POST['txtid2'];


if($tipo_conta == ""){
	echo 'O Tipo da Conta é Obrigatório!';
	exit();
}

if($n_agencia == ""){
	echo 'O Nº da Agência é Obrigatória!';
	exit();
}

if($cod_op == ""){
	echo 'O Código de Operação é Obrigatório!';
	exit();
}

if($n_conta == ""){
	echo 'O Nº da Conta é Obrigatória!';
	exit();
}
if($renda == ""){
	echo 'A Renda é Obrigatória!';
	exit();
}
if($renda_f == ""){
	echo 'A Renda Familiar é Obrigatória!';
	exit();
}

//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $n_conta){
	$query = $pdo->query("SELECT * FROM dados_socio where n_conta = '$n_conta' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'A conta já está cadastrada!';
		exit();
	}
}

if($id != ""){

	$res = $pdo->prepare("UPDATE dados_socio SET n_agencia = :n_agencia, banco = :banco, cod_op = :cod_op, tipo_conta = :tipo_conta, n_conta = :n_conta, renda = :renda, renda_f = :renda_f WHERE id_usuario = '$id'");

	$res->bindValue(":n_agencia", $n_agencia);
	$res->bindValue(":cod_op", $cod_op);
	$res->bindValue(":n_conta", $n_conta);
	$res->bindValue(":renda", $renda);
	$res->bindValue(":renda_f", $renda_f);
	$res->bindValue(":tipo_conta",$tipo_conta);
	$res->bindValue(":banco",$banco);


$res->execute();


echo 'Salvo com Sucesso!';
}
?>