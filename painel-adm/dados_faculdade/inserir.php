<?php 
require_once("../../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != '1'){
    echo "<script language='javascript'> window.location='../login.php' </script>";

}


$nome_faculdade = $_POST['nome_faculdade'];
$municipio = $_POST['municipio'];
$semestre = $_POST['semestre'];


$id = $_POST['txtid2'];


if($nome_faculdade == ""){
	echo 'O nome da Faculdade é obrigatório!';
	exit();
}

if($semestre == ""){
	echo 'O semestre é obrigatório!';
	exit();
}

if($municipio == ""){
	echo 'O Municipio é obrigatório!';
	exit();
}

$nome_pasta = $idUsuario." - ".$nome_usu;


if(isset($_FILES['comprovante'])){
	date_default_timezone_set("Brazil/East"); //Definindo timezone padrão

      //$nome_arquivo_editado = preg_replace('/[ -]+/' , '-' , @$_FILES['arquivo']['name']);
      $ext2 = pathinfo($_FILES['comprovante']['name'], PATHINFO_EXTENSION);
      $ext = strtolower(substr($_FILES['comprovante']['name'],-4)); //Pegando extensão do arquivo
      $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
      $dir = '../arquivos-alunos/'. $nome_pasta . '/'; //Diretório para uploads


    if($_FILES['comprovante']['size'] > 1048576){
    	echo "O arquivo ultrapassa 1 MB!";
    	exit();
    }
  	if($_FILES['comprovante']['type'] != "application/pdf"){
      echo "Arquivo não suportado ou arquivo não anexado. Use apenas PDF!";
      exit();
    } 
}

if(isset($_FILES['contrato'])){
	date_default_timezone_set("Brazil/East"); //Definindo timezone padrão

      //$nome_arquivo_editado = preg_replace('/[ -]+/' , '-' , @$_FILES['arquivo']['name']);
      //$ext2 = pathinfo($_FILES['contrato']['name'], PATHINFO_EXTENSION);
      //$ext = strtolower(substr($_FILES['contrato']['name'],-4)); //Pegando extensão do arquivo
      //$new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
      $dir = '../arquivos-alunos/'.$nome_pasta.'/'; //Diretório para uploads

    if($_FILES['contrato']['size'] > 1048576){
    	echo "O arquivo ultrapassa 1 MB!";
    	exit();
    }
    if($_FILES['comprovante']['type'] != "application/pdf"){
      echo "Arquivo não suportado ou arquivo não anexado. Use apenas PDF!";
      exit();
    }  
}

$nome_arquivo_comprovante = "Comprovante de Matrícula - ".$idUsuario."-".$nome_usu."-".$semestre.".pdf";
$nome_arquivo_contrato = "Comprovante de Contrato - ".$idUsuario."-".$nome_usu."-".$semestre.".pdf";



if($id != ""){
	$res = $pdo->prepare("INSERT INTO dados_faculdade SET nome_faculdade = :nome_faculdade, municipio = :municipio, semestre = :semestre, limitar_update = '1',  comprovante = :comprovante, contrato_transporte = :contrato_transporte");	
	

}

	
$res->bindValue(":nome_faculdade", $nome_faculdade);
$res->bindValue(":municipio", $municipio);
$res->bindValue(":semestre", $semestre);
$res->bindValue(":comprovante", $nome_arquivo_comprovante);
$res->bindValue(":contrato_transporte", $nome_arquivo_contrato);


$res->execute();


echo 'Salvo com Sucesso!';

?>