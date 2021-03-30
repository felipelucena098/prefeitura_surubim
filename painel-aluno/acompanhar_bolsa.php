            <?php 
            require_once("../conexao.php"); 

            @session_start();
                //verificar se o usuário está autenticado
            if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != '2'){
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
                                    <th>Situação da Documentação</th>
                                    <th>Situação da Documentação da Faculdade</th>
                                    <th>Valor da Bolsa</th>
                                </tr>
                            </thead>

                            <tbody>

                             <?php 

                             $query = $pdo->query("SELECT * FROM situacao order by id asc");
                             $res = $query->fetchAll(PDO::FETCH_ASSOC);

                             for ($i=0; $i < count($res); $i++) { 
                              foreach ($res[$i] as $key => $value) {
                              }
                              $nome = $res[$i]['nome'];
                              $s_documentos = $res[$i]['s_documentos'];
                              $s_matricula = $res[$i]['s_matricula'];
                              $valor_b = $res[$i]['valor_b'];
                              $id = $res[$i]['id'];


                              ?>


                              <tr>
                                <td><?php echo $nome ?></td>
                                <td><?php echo $s_documentos ?></td>
                                <td><?php echo $s_matricula ?></td>
                                <td><?php echo $valor_b ?></td>
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

                        $query = $pdo->query("SELECT * FROM dados_socio where id = '" . $id2 . "' ");
                        $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    } else {
                        $titulo = "Inserir Registro";

                    }


                    ?>

                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form" method="POST" action="dados_financeiros/inserir.php">
                    <div class="modal-body">

                    <div class="form-group">
                            <label>Banco</label>
                            <select class="form-control" id="banco" name="banco"> 
                            <option>Caixa Econômica do Brasil</option>
                            </select>
                    </div>


                        <div class="row">
                            <div class="col-md-6">
                               <div class="form-group">
                                <label >Nome</label>
                                <input value="<?php echo @$n_agencia2 ?>" type="text" class="form-control" id="n_agencia" name="n_agencia" placeholder="Nº da Agência" onkeyup="somenteNumeros(this);">
                            </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group">
                            <label >Código de Operação</label>
                            <input value="<?php echo @$cod_op2?>" type="text" class="form-control" id="cod_op" name="cod_op" placeholder="Código de Operação" onkeyup="somenteNumeros(this);">
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tipo da Conta</label>
                            <select class="form-control" id="tipo_conta" name="tipo_conta"> 
                            <option selected=""></option>
                            <option>Conta Corrente</option>
                            <option>Conta Poupança</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label>Nº da Conta</label>
                        <input value="<?php echo @$n_conta2?>" type="text" class="form-control" id="n_conta" name="n_conta" placeholder="Nº da Conta" onkeyup="somenteNumeros(this);">
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label >Renda do Universitário</label>
                            <input value="<?php echo @$renda2 ?>" type="text" class="form-control" id="renda" name="renda" placeholder="Renda do Universitário">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label >Renda Familiar</label>
                            <input value="<?php echo @$renda_f2 ?>" type="text" class="form-control" id="renda_f" name="renda_f" placeholder="Renda Familiar">
                        </div>
                    </div>
                </div>





                <div class="row">



                </div>




                <small>
                    <div id="mensagem">

                    </div>
                </small> 

            </div>



            <div class="modal-footer">



                <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                <input value="<?php echo @$n_conta2 ?>" type="hidden" name="antigo" id="antigo">

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



    ?>




    <!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
    <script type="text/javascript">
        $("#form").submit(function () {
            var pag = "<?=$pag?>";
            event.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "dados_financeiros/inserir.php",
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

    <script>
    function somenteNumeros(num) {
        var er = /[^0-9.]/;
        er.lastIndex = 0;
        var campo = num;
        if (er.test(campo.value)) {
          campo.value = "";
        }
    }
 </script>

