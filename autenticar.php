<?php 
require_once("conexao.php");
@session_start();

$cpf = $_POST['cpf'];
$senha = $_POST['senha'];

if($cpf == "" && $senha == ""){
	echo "<script language='javascript'> window.alert('Preencha os campos em branco!') </script>";
	echo "<script language='javascript'> window.location='login.php' </script>";	
	exit();
}

$query = $pdo->prepare("SELECT * FROM usuario where cpf = :cpf and senha = :senha");
$query->bindValue(":senha", $senha);
$query->bindValue(":cpf", $cpf);
$query->execute();




$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){

	$_SESSION['id_usuario'] = $res[0]['id'];
	$_SESSION['nome_usuario'] = $res[0]['nome'];
	$_SESSION['email_usuario'] = $res[0]['email'];
	$_SESSION['nivel_usuario'] = $res[0]['nivel'];

	$nivel = $res[0]['nivel'];



	if($nivel == '2'){
		echo "<script language='javascript'> window.location='painel-aluno' </script>";
	}

	if($nivel == '1'){
		echo "<script language='javascript'> window.location='painel-adm' </script>";
	}
	
}else{
	echo "<script language='javascript'> window.alert('Usuário ou Senha Incorreta!') </script>";
	echo "<script language='javascript'> window.location='login.php' </script>";	
}

exit();

?>