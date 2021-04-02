<?php 
require_once("../../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != '1'){
    echo "<script language='javascript'> window.location='../login.php' </script>";

}

$s_documento = $_POST['s_documento'];
$s_matricula = $_POST['s_matricula'];
$valor_b = $_POST['valor_b'];


$id = $_POST['txtid2'];
$id_usuario = $_POST['txtid3'];

$query = $pdo->query("SELECT * FROM situacao where id_usuario = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg > 0){
	echo "<script language='javascript'> window.alert('Universitário já validado!') </script>";
	echo "<script language='javascript'> window.location='../index.php?pag=consulta_aluno' </script>";
	exit();
}

$res = $pdo->prepare("INSERT INTO situacao SET id_usuario = :id_usuario, s_documento = :s_documento, s_matricula = :s_matricula, valor_b = :valor_b, verificado = 'Usuário Validado' ");


$res->bindValue(":id_usuario", $id_usuario);
$res->bindValue(":s_documento", $s_documento);
$res->bindValue(":s_matricula", $s_matricula);
$res->bindValue(":valor_b", $valor_b);

$res->execute();


echo "<script language='javascript'> window.alert('Cadastrado com Sucesso!') </script>";

echo "<script language='javascript'> window.location='../index.php?pag=consulta_aluno' </script>";

?>