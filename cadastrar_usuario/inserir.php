<?php 
require_once("../conexao.php"); 

$nome = $_POST['nome'];
$senha = $_POST['senha'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];

if($nome == ""){
	echo 'O nome é obrigatório!';
	exit();
}

if($email == ""){
	echo 'O email é obrigatório!';
	exit();
}

if($senha == ""){
	echo 'A senha é obrigatória!';
	exit();
}

if($cpf == ""){
	echo 'O CPF é obrigatório!';
	exit();
}

	//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
	$query = $pdo->query("SELECT * FROM usuario where nome = '$nome' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
	echo "<script language='javascript'> window.alert('Usuário já cadastrado!') </script>";
	echo "<script language='javascript'> window.location='../login.php' </script>";
	exit();	
	}

	//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
	$query = $pdo->query("SELECT * FROM usuario where email = '$email' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
	echo "<script language='javascript'> window.alert('Email já cadastrado!') </script>";
	echo "<script language='javascript'> window.location='../login.php' </script>";
	exit();	
	}

	//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
	$query = $pdo->query("SELECT * FROM usuario where cpf = '$cpf' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
	echo "<script language='javascript'> window.alert('CPF já cadastrado!') </script>";
	echo "<script language='javascript'> window.location='../login.php' </script>";
	exit();	
	}

	$res = $pdo->prepare("INSERT INTO usuario SET nome = :nome, email = :email, senha = :senha,cpf = :cpf, nivel = '2' ");	

$res->bindValue(":nome", $nome);
$res->bindValue(":email", $email);
$res->bindValue(":senha", $senha);
$res->bindValue(":cpf", $cpf);

$res->execute();

echo "<script language='javascript'> window.alert('Cadastrado com Sucesso!') </script>";
echo "<script language='javascript'> window.location='../login.php' </script>";
exit();
 ?>