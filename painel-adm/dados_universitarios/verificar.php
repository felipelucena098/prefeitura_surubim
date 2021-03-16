<?php

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != '1'){
    echo "<script language='javascript'> window.location='../login.php' </script>";

}

$id2 = $_GET['id'];

$query = $pdo->query("SELECT * FROM dados_pessoais where id = '" . $id2 . "' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$documentos = $res[0]['documentos'];


?>