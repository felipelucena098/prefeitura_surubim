<?php 
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != '2'){
    echo "<script language='javascript'> window.location='../login.php' </script>";

}

 //RECUPERAR DADOS DO USUÁRIO
$query = $pdo->query("SELECT * FROM usuario where id = '$_SESSION[id_usuario]'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_usu = @$res[0]['nome'];
$email_usu = @$res[0]['email'];
$senha_usu =@$res[0]['senha'];
$idUsuario = @$res[0]['id']; 


$nome = $_POST['nome_usu'];
$email = $_POST['email_usu'];
$senha = $_POST['senha_nova'];
$senha_antiga = $_POST['senha_antiga'];



if($nome == ""){
	echo 'O nome é Obrigatório!';
	exit();
}

if($email == ""){
	echo 'O email é Obrigatório!';
	exit();
}

	$query = $pdo->query("SELECT * FROM usuario where email = '$email_usu' and senha = '$senha_antiga' and id = '$idUsuario'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);

	if($total_reg > 0){
	$res = $pdo->prepare("UPDATE usuario SET nome = :nome, email = :email, senha = :senha WHERE id = '$idUsuario'");
	}

	else{
	echo "<script language='javascript'> window.alert('Dados Inválidos, tente novamente!') </script>";
	echo "<script language='javascript'> window.location='index.php' </script>";
	exit();
	}


	 
	
$res->bindValue(":nome", $nome);
$res->bindValue(":email", $email);
$res->bindValue(":senha", $senha);
$res->execute();

echo "<script language='javascript'> window.alert('Dados atualizados com Sucesso!') </script>";
echo "<script language='javascript'> window.location='index.php' </script>";



?>