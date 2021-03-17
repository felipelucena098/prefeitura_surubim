<?php 
require_once("../../conexao.php"); 

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
$cpf_usu = @$res[0]['cpf'];
$idUsuario = @$res[0]['id'];  



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


$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];
$id = $_POST['txtid2'];



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

if($nome != $nome_usu){
	echo " O Nome do usuário não confere com o cadastrado no início!";
	exit();
}

if($cpf != $cpf_usu){
	echo "O CPF do usuário não confere com o cadastrado no início!";
	exit();
}
if($email != $email_usu){
	echo "O E-mail do usuário não confere com o cadastrado no início!";
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

$nome_arquivo = "Documentos - ".$idUsuario."-".$nome_usu.".pdf";

if(isset($_FILES['documentos'])){
      date_default_timezone_set("Brazil/East"); //Definindo timezone padrão

      //$nome_arquivo_editado = preg_replace('/[ -]+/' , '-' , @$_FILES['arquivo']['name']);
      //$ext2 = pathinfo($_FILES['documentos']['name'], PATHINFO_EXTENSION);
      //$ext = strtolower(substr($_FILES['documentos']['name'],-4)); //Pegando extensão do arquivo
      $dir = '../arquivos/'; //Diretório para uploads

    if($_FILES['documentos']['size'] > 1048576){
    	echo "O arquivo ultrapassa 1 MB!";
    	exit();
    }
    if($_FILES['documentos']['type'] != "application/pdf"){
    	echo "Arquivo não suportado ou arquivo não anexado. Use apenas PDF!";
    	exit();
    }
}





	if($id == "" ){
	$res = $pdo->prepare("INSERT INTO dados_pessoais SET id_usuario = :id_usuario, nome = :nome, cpf = :cpf, rg = :rg, orgao_exp = :orgao_exp, nasc = :nasc, nis = :nis, rua = :rua, bairro = :bairro, cep = :cep, email = :email, telefone = :telefone, uf = :uf, limitar_update = '1', documentos = :documentos");

	move_uploaded_file($_FILES['documentos']['tmp_name'], $dir.$nome_arquivo);

	$res->bindValue(":id_usuario", $idUsuario);
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
	$res->bindValue(":documentos", $nome_arquivo);

	$res->execute();

	echo 'Salvo com Sucesso!';	
}

$query = $pdo->query("SELECT * FROM dados_pessoais where limitar_update = '0' and id_usuario = '$_SESSION[id_usuario]' ");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res2);

if ($total_reg == 0) {
		echo "Você não tem permissão para atualizar o arquivo anexado. Entre em contato com o suporte!";
		exit();
}	
	if($id != ""){

	$res2 = $pdo->prepare("UPDATE dados_pessoais SET  documentos = :documentos, limitar_update = '1' WHERE id = '$id'");

	move_uploaded_file($_FILES['documentos']['tmp_name'], $dir.$nome_arquivo);

	$res2->bindValue(":documentos", $nome_arquivo);

	$res2->execute();

	echo 'Salvo com Sucesso!';
}



?>