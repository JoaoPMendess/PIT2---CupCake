<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['tipo'])) {
            $codigo     = filtra($_POST['codigo']);
            $nome       = SubStr(filtra($_POST['nome']), 0, 50);
            $descricao  = SubStr(filtra($_POST['descricao']), 0,200);
            $categoria  = intval(filtra($_POST['categoria']));
            $valor      = floatval(filtra($_POST['valor']));
            $promocao   = floatval(filtra($_POST['promocao']));
            $tipo       = intval(filtra($_POST['tipo']));
            if ($tipo == 1) {
                $fileTmpPath = $_FILES['imagem']['tmp_name'];
                $fileName = $_FILES['imagem']['name'];
                $fileSize = $_FILES['imagem']['size'];
                $fileType = $_FILES['imagem']['type'];
                $fileHash = md5(uniqid(rand(), true));
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $insertnew = DB::exQuery("INSERT INTO vitrine (nome, descricao, categoria, valor, promocao, ativo, imagem) VALUES (?, ?, ?, ?, ?, ?, ?)", [$nome, $descricao, $categoria, $valor, $promocao, 1, $fileHash]);
                if($insertnew > 0) {
                    $newFileName = $fileHash . '.' . $fileExtension;
                    $uploadDir = './imagens/vitrine/';
                    $destPath = $uploadDir . $newFileName;
                    move_uploaded_file($fileTmpPath, $destPath);
                    DB::query("UPDATE utils set vitrine_qtd = ".DB::insertID());
                    echo "<script> alert('produto adicionado com sucesso')</script>";
                }else {
                    echo "<script> alert('Falha ao adicionar produto')</script>";
                }

            } else {
                $update = DB::exQuery("UPDATE vitrine SET nome = ?, descricao = ?, categoria = ?, valor = ?, promocao = ? WHERE id = ?", [$nome, $descricao, $categoria, $valor, $promocao, $codigo]);
                if ($update) {
                    echo "<script> alert('produto atualizado')</script>";
                } else {
                    echo "<script> alert('Houve uma falha ao finalizar.')</script>";
                }
            }
            
        }
    }
    $vitrine = DB::query("SELECT id, left(nome,30) AS nome, descricao AS descricao, 
    IF(categoria = 1, 'CHOCOLATE', IF(categoria = 2, 'BRIGADEIRO', IF(CATEGORIA = 3, 'MORANGO', 
    IF(categoria = 4, 'BAUNILHA', IF(categoria = 5, 'LARANJA', 'LIMAO'))))) AS categoria, 
    valor, CONCAT(promocao, ' %') AS promocao FROM vitrine WHERE ativo");
    $valtable = MontaTabela($vitrine, 6, 6);
    $ultcod = DB::fetchOne("SELECT vitrine_qtd + 1 AS ultcod FROM utils")['ultcod'];
?>
                <script>
                    sessionStorage.setItem('form_submitted', 'true');
                    window.onbeforeunload = function() {
                        sessionStorage.removeItem('form_submitted');
                    };
                </script>
                <style>
                    .d-md-flex.justify-content-between.align-items-center.col-12.dt-layout-full.col-md {
                    overflow-x: scroll !important;
                }
                </style>
                <form class="row g-3" method="POST" href="?pagina=vitrine" id="formularioprod" enctype="multipart/form-data">
                    <div class="col-md-2">
                        <label class="form-label">Código</label>
                        <input type="text" class="form-control" name="codigo" id="codigo" value="<?=$ultcod?>" readonly>
                    </div>
                    <div class="col-md-10">
                        <label class="form-label">Nome:</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Descrição:</label>
                        <input type="text" class="form-control" name="descricao" id="descricao" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Categoria</label>
                        <select class="form-select" name="categoria" id="categoria" required>
                            <option selected>Escolha</option>
                            <option value="1">CHOCOLATE</option>
                            <option value="2">BRIGADEIRO</option>
                            <option value="3">MORANGO</option>
                            <option value="4">BAUNILHA</option>
                            <option value="5">LARANJA</option>
                            <option value="6">LIMAO</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Valor</label>
                        <input type="number" step="any" class="form-control" name="valor" id="valor" maxlength="15" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Promoção</label>
                        <input type="number" step="any" class="form-control" name="promocao" id="promocao" maxlength="5" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" id="labelimagem">Imagem:</label>
                        <input type="file" class="form-control" name="imagem" id="imagem" accept="image/*" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" vaue="1" class="btn btn-success float-end" name="botaonovo"id="botanovo">Novo</button>
                        <button type="button" class="btn btn-warning float-end me-2" onclick="limpar()">Limpar</button>
                    </div>
                    <input type="number" id="tipo" name="tipo" value="1" hidden required>
                </form>
                <table class="table" id="table-pai">
                    <thead>
                        <tr style="text-align: left !important;">
                            <th scope="col" class="col-port">Codigo</th>
                            <th scope="col" class="col-codigo">Nome</th>
                            <th scope="col" class="col-descricao">Descrição</th>
                            <th scope="col" class="col-estoque">Categoria</th>
                            <th scope="col" class="col-lista">Valor</th>
                            <th scope="col" class="col-laboratorio">Promoção</th>
                        </tr>
                    </thead>
                    <tbody>
<?=$valtable?>
                    </tbody>
                </table>   
                <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
                <script>
                    var codigo  = <?=$ultcod?>;
                    $(document).ready( function () {
                        const categorias = { 'CHOCOLATE': 1, 'BRIGADEIRO': 2, 'MORANGO': 3, 'BAUNILHA': 4, 'LARANJA': 5};
                        var tablepai = $('#table-pai').DataTable({ //Inicializa pai
                            language: {
                                url: './js/datatablept.json'
                            },
                        });
                        $('#table-pai tbody').on('click', 'tr', function () { //Ações ao clicar na tabela pai
                            var data = tablepai.row(this).data();
                            if ($(this).hasClass('highlight')) {
                                $(this).removeClass('highlight');
                            } else {
                                $('tr.highlight').removeClass('highlight');
                                $(this).addClass('highlight');
                            }
                            if(data){
                                const categoria = categorias[data[3]] || 6                    
                                $("#codigo").val(data[0]);
                                $("#nome").val(data[1]);
                                $("#descricao").val(data[2]);
                                $("#categoria").val(categoria);
                                $("#valor").val(parseFloat(data[4]));
                                $("#promocao").val(parseFloat(data[5]));
                                $("#botanovo").text("Atualizar");
                                $("#tipo").val("2");
                                $("#imagem").removeAttr("required");
                                $("#imagem").hide();
                                $("#labelimagem").hide();
                                $("#main").animate({ scrollTop: 0 }, "slow");
                            };
                        });
                    })
                    function limpar() {
                        $("#codigo").val(codigo);
                        $("#nome").val('');
                        $("#descricao").val('');
                        $("#categoria").val('');
                        $("#valor").val('');
                        $("#promocao").val('');
                        $("#tipo").val("1");
                        $("#imagem").attr("required", "required");
                        $("#imagem").show();
                        $("#labelimagem").show();
                    }
                </script>
                