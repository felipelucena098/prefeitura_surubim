<?php 
require_once("../../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != '1'){
    echo "<script language='javascript'> window.location='../login.php' </script>";

}
$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];
$id = $_POST['txtid2'];



$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$rg = $_POST['rg'];
$orgao_exp = $_POST['orgao_exp'];
$nasc = $_POST['nasc'];
$nis = $_POST['nis'];
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$cep = $_POST['cep'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$uf = $_POST['uf'];



if($nome == ""){
	echo 'O nome é Obrigatório!';
	exit();
}

if($email == ""){
	echo 'O email é Obrigatório!';
	exit();
}

if($cpf == ""){
	echo 'O CPF é Obrigatório!';
	exit();
}



//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $cpf){
	$query = $pdo->query("SELECT * FROM dados_pessoais where cpf = '$cpf' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O CPF já está Cadastrado!';
		exit();
	}
}


//VERIFICAR SE O REGISTRO COM MESMO EMAIL JÁ EXISTE NO BANCO
if($antigo2 != $email){
	$query = $pdo->query("SELECT * FROM dados_pessoais where email = '$email' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O Email já está Cadastrado!';
		exit();
	}
}


	if($id != "" ){
	$res = $pdo->prepare(" UPDATE dados_pessoais SET nome = :nome, cpf = :cpf, rg = :rg, orgao_exp = :orgao_exp, nasc = :nasc, nis = :nis, rua = :rua, bairro = :bairro, cep = :cep, email = :email, telefone = :telefone, uf = :uf, limitar_update = '1' WHERE id = '$id'");

	$res->bindValue(":nome", $nome);
	$res->bindValue(":cpf", $cpf);
	$res->bindValue(":rg", $rg);
	$res->bindValue(":orgao_exp", $orgao_exp);
	$res->bindValue(":nasc", $nasc);
	$res->bindValue(":nis", $nis);
	$res->bindValue(":rua", $rua);
	$res->bindValue(":bairro", $bairro);
	$res->bindValue(":cep", $cep);
	$res->bindValue(":email", $email);
	$res->bindValue(":telefone", $telefone);
	$res->bindValue(":uf", $uf);

	$res->execute();

	echo 'Salvo com Sucesso!';	
}



?>