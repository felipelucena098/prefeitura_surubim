<?php 
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != '1'){
    echo "<script language='javascript'> window.location='../login.php' </script>";

//RECUPERAR DADOS DO USUÁRIO
$query = $pdo->query("SELECT * FROM usuario where id = '$_SESSION[id_usuario]'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_usu = @$res[0]['nome'];
$email_usu = @$res[0]['email'];
$cpf_usu = @$res[0]['cpf'];
$idUsuario = @$res[0]['id'];



}



?>

<div class="row mt-4 mb-4">
    <a type="button" id="cadastrar" class="btn-info btn-sm ml-3 d-none d-md-block"  href="index.php?pag=<?php echo $pag ?>&funcao=novo">Cadastrar Resultado</a>
    <a type="button" class="btn-info btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo">+</a>
    
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Situação da Documentação</th>
                        <th>Situação da Documentação da Faculdade</th>
                        <th>Valor da Bolsa</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM dados_pessoais inner join situacao on dados_pessoais.id_usuario = situacao.id_usuario");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                    $nome = $res[$i]['nome'];
                    $s_documentos = $res[$i]['s_documento'];
                    $s_matricula = $res[$i]['s_matricula'];
                    $valor_b = $res[$i]['valor_b'];
                    $id = $res[$i]['id'];
                    $id_usuario = $res[$i]['id_usuario'];

                    

                

                  ?>


                  <tr>
                        <td><?php echo $nome ?></td>
                        <td><?php echo $s_documentos ?></td>
                        <td><?php echo $s_matricula ?></td>
                        <td><?php echo $valor_b ?></td>
                        


                    <td>
                       <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>
                       
                        <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Ver Endereço'><i class='fas fa-home'></i></a>
                   </td>
               </tr>
           <?php } ?>





       </tbody>
   </table>
</div>
</div>
</div>





<!-- Modal -->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                if (@$_GET['funcao'] == 'editar') {
                    $titulo = "Editar Registro";
                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM dados_pessoais where id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $nome2 = $res[0]['nome'];
                    $s_documentos2 = $res[0]['s_documentos'];
                    $s_matricula2 = $res[0]['s_matricula'];
                    $valor_b2 = $res[0]['valor_b'];

                      



                } else {
                    $titulo = "Inserir Registro";

                }


                ?>
                
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST" action="../inserir.php" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                            <label >Nome</label>
                            <input value="<?php echo @$nome2 ?>" type="text" class="form-control" id="nome" name="nome" placeholder="">
                    </div>
                    <div class="form-group">
                            <label >Situação da Documentação</label>
                            <input value="<?php echo @$s_documento2 ?>" type="text" class="form-control" id="s_documento" name="s_documento" placeholder="">
                    </div>
                    
                    <div class="form-group">
                        <label >Situação da documentação da Faculdade</label>
                        <input value="<?php echo @$s_matricula2 ?>" type="text" class="form-control" id="s_matricula" name="s_matricula" placeholder="">
                    </div>
                   
                    <div class="form-group">
                        <label >Valor da Bolsa</label>
                        <input value="<?php echo @$valor_b2 ?>" type="text" class="form-control" id="valor_b" name="valor_b" placeholder="">
                    </div>

  
     

            


                    <small>
                        <div id="mensagem">

                        </div>
                    </small> 

                </div>



                <div class="modal-footer">



                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo @$_GET['id_usuario'] ?>" type="hidden" name="txtid3" id="txtid3">
                    <input value="<?php echo @$cpf2 ?>" type="hidden" name="antigo" id="antigo">
                    <input value="<?php echo @$email2 ?>" type="hidden" name="antigo2" id="antigo2">

                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>






<div class="modal" id="modal-deletar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Deseja realmente Excluir este Registro?</p>

                <div align="center" id="mensagem_excluir" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id"  name="id" value="<?php echo @$_GET['id'] ?>" required>

                    <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>






<div class="modal" id="modal-endereco" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados do Universitário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php 
                if (@$_GET['funcao'] == 'endereco') {
                    

                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM dados_pessoais where id = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                      $nome3 = $res[0]['nome'];
                      $cpf3 = $res[0]['cpf'];
                      $rg3 = $res[0]['rg'];
                      $org_exp3 = $res[0]['org_exp '];
                      $rg3 = $res[0]['rg'];
                      $org_exp3 = $res[0]['orgao_exp'];
                      $nis3 = $res[0]['nis'];
                      $nasc3 = $res[0]['nasc'];
                      $rua3 = $res[0]['rua'];
                      $bairro3 = $res[0]['bairro'];
                      $cep3 = $res[0]['cep'];
                      $uf3 = $res[0]['uf'];
                      $email3 = $res[0]['email'];
                      $telefone3 = $res[0]['telefone'];
                      $documentos3 = $res[0]['documentos'];
                      $id_usuario3 = $res[0]['id_usuario'];
                } 

                    $query = $pdo->query("SELECT * FROM usuario where id = '$id_usuario3' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $nome_usu = @$res[0]['nome'];
                    $idUsuario = @$res[0]['id']; 

                    $nome_pasta = $idUsuario." - ".$nome_usu;

                ?>

                    <span><b>Nome: </b> <i><?php echo $nome3 ?></i><br>
                    <span><b>Rua: </b> <i><?php echo $rua3 ?></i> <span class="ml-4"><b>Bairro: </b> <i><?php echo $bairro3 ?></i><br>
                    <span><b>UF: </b> <i><?php echo $uf3 ?><br>
                    <span><b>CEP: </b> <i><?php echo $cep3 ?><br>
                    <span><b>Telefone: </b> <i><?php echo $telefone3 ?><br>
                    <span><b>Email: </b> <i><?php echo $email3 ?><br>
                    <span><b>Documentos: </b> <a target="_blank" href="../painel-aluno/arquivos-alunos/<?php echo $nome_pasta ?>/<?php echo $documentos3 ?>"><i><?php echo $documentos3 ?><br>

            </div>
            
        </div>
    </div>
</div>




<?php 

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novo") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editar") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir") {
    echo "<script>$('#modal-deletar').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "endereco") {
    echo "<script>$('#modal-endereco').modal('show');</script>";
}



?>




<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form").submit(function () {
        var pag = "<?=$pag?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/inserir.php",
            type: 'POST',
            data: formData,

            success: function (mensagem) {

                $('#mensagem').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar').click();
                    window.location = "index.php?pag="+pag;

                } else {

                    $('#mensagem').addClass('text-danger')
                }

                $('#mensagem').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function () {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>





<!--AJAX PARA EXCLUSÃO DOS DADOS -->
<script type="text/javascript">
    $(document).ready(function () {
        var pag = "<?=$pag?>";
        $('#btn-deletar').click(function (event) {
            event.preventDefault();

            $.ajax({
                url: pag + "/excluir.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function (mensagem) {

                    if (mensagem.trim() === 'Excluído com Sucesso!') {


                        $('#btn-cancelar-excluir').click();
                        window.location = "index.php?pag=" + pag;
                    }

                    $('#mensagem_excluir').text(mensagem)



                },

            })
        })
    })
</script>



<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">

    function carregarImg() {

        var target = document.getElementById('target');
        var file = document.querySelector("input[type=file]").files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);


        } else {
            target.src = "";
        }
    }

</script>





<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTable').dataTable({
            "ordering": false
        })

    });
</script>



