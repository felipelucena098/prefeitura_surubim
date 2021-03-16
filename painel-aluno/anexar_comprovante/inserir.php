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
$idUsuario = @$res[0]['id'];

$id = $_POST['txtid2'];

if(isset($_FILES['comprovante']))
{
      date_default_timezone_set("Brazil/East"); //Definindo timezone padrão

      //$nome_arquivo_editado = preg_replace('/[ -]+/' , '-' , @$_FILES['arquivo']['name']);
      $ext2 = pathinfo($_FILES['comprovante']['name'], PATHINFO_EXTENSION);
      $ext = strtolower(substr($_FILES['comprovante']['name'],-4)); //Pegando extensão do arquivo
      $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
      $dir = '../comprovantes/'; //Diretório para uploads
      $nome_arquivo = "Comprovante - ".$idUsuario."-".$nome_usu;

    if($_FILES['comprovante']['size'] > 1048576){
    	echo "O arquivo ultrapassa 1 MB!";
    	exit();
    }
	if($ext2 != 'pdf'){
		echo "Arquivo não suportado, use apenas formato PDF!";
		exit();
	}  
}
$query = $pdo->query("SELECT * FROM comprovante where limitar_cadastro = '1' and id_usuario = '$_SESSION[id_usuario]' ");  
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);


if($id == "" && $ext2 == 'pdf'){

	$res = $pdo->prepare("INSERT INTO comprovante SET comprovante = '$nome_arquivo', id_usuario = '$idUsuario', obs = 'Documentos em análise!', limitar_cadastro = '1'");
  move_uploaded_file($_FILES['comprovante']['tmp_name'], $dir.$nome_arquivo);
}
if($id != "" && $ext2 =='pdf'){

  $res = $pdo->prepare("UPDATE comprovante SET documentos = '$nome_arquivo' obs = 'Documentos em análise!' WHERE id = '$id'");
  move_uploaded_file($_FILES['comprovante']['tmp_name'], $dir.$nome_arquivo);
  }

$res->bindValue(":documentos", $nome_arquivo);
$res->bindValue(":id_usuario", $idUsuario);

$res->execute();

echo 'Salvo com Sucesso!';

?>