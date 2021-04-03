<?php 
 require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != '1'){
    echo "<script language='javascript'> window.location='../login.php' </script>";

}

?>


<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Instituição de Ensino</th>
                        <th>Município</th>
                        <th>Semestre</th>
                        <th>Comprovante de Matrícula</th>
                        <th>Comprovante de Contrato do Transporte</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM dados_faculdade inner join usuario on dados_faculdade.id_usuario = usuario.id ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }
                    $nome = $res[$i]['nome'];
                    $nome_faculdade = $res[$i]['nome_faculdade'];
                    $municipio = $res[$i]['municipio'];
                    $semestre = $res[$i]['semestre'];
                    $comprovante = $res[$i]['comprovante'];
                    $contrato_transporte = $res[$i]['contrato_transporte'];
                    $id = $res[$i]['id'];


                  ?>


                  <tr> 
                        <td><?php echo $nome ?></td>
                        <td><?php echo $nome_faculdade ?></td>
                        <td><?php echo $municipio ?></td>
                        <td><?php echo $semestre ?></td>
                        <td><?php echo $comprovante ?></td>
                        <td><?php echo $contrato_transporte ?></td>

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

                    $query = $pdo->query("SELECT * FROM dados_faculdade where id_usuario = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $nome_faculdade2 = $res[0]['nome_faculdade'];
                    $municipio2 = $res[0]['municipio'];
                    $id_usuario2 = $res[0]['id_usuario'];
                    $semestre2 = $res[0]['semestre'];
                    $comprovante2 = $res[0]['comprovante'];
                    $contrato_transporte2 = $res[0]['contrato_transporte'];



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
                        <label >Nome da Faculdade</label>
                        <input value="<?php echo @$nome_faculdade2 ?>" type="text" class="form-control" id="nome_faculdade" name="nome_faculdade" placeholder="Nome da Faculdade">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                            <label >Município da Faculdade</label>
                            <input value="<?php echo @$municipio2 ?>" type="text" class="form-control" id="municipio" name="municipio" placeholder="Município da Faculdade">
                        </div>
                    </div>

                    <div class="col-md-6">
                           <div class="form-group">
                            <label >Semestre</label>
                            <input value="<?php echo @$semestre2 ?>" type="text" class="form-control" id="semestre" name="semestre" placeholder="Semestre">
                        </div>
                    </div>

                    
                    </div>

                    <small>
                        <div id="mensagem">

                        </div>
                    </small> 

                </div>



                <div class="modal-footer">



                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                

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

                    $query = $pdo->query("SELECT * FROM dados_faculdade where id_usuario = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                      $comprovante3 = $res[0]['comprovante'];
                      $contrato_transporte3 = $res[0]['contrato_transporte'];
                      $id_usuario3 = $res[0]['id_usuario'];
                
                } 

                    $query = $pdo->query("SELECT * FROM usuario where id = '$id_usuario3' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $nome_usu = @$res[0]['nome'];
                    $idUsuario = @$res[0]['id']; 

                    $nome_pasta = $idUsuario." - ".$nome_usu;

                ?>

                    <span><b>Comprovante de matrícula: </b> <a target="_blank" href="../painel-aluno/arquivos-alunos/<?php echo $nome_pasta ?>/<?php echo $comprovante3 ?>"><i><?php echo $comprovante3 ?></i></a><br>

                    <span><b>Comprovante de Contrato: </b> <a target="_blank" href="../painel-aluno/arquivos-alunos/<?php echo $nome_pasta ?>/<?php echo $contrato_transporte3 ?>"><i><?php echo $contrato_transporte3 ?></i></a><br>
                    

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



