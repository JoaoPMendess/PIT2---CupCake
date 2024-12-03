<?php

    $usuarios = DB::query("SELECT id, IF(permissoes > 0, 'ADM', 'Cliente') as tipo, nome, email, telefone, 
    coalesce(DATE_FORMAT(ult_compra,'%d/%m/%Y'), '00/00/0000') AS ult_compra FROM usuarios");
    $usertable = MontaTabela($usuarios, 6, 6, true);
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
                <table class="table" id="table-pai">
                    <thead>
                        <tr style="text-align: left !important;">
                            <th scope="col">Codigo</th>
                            <th scope="col">tipo</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Ult. Compra</th>
                            <th scope="col">Add/Rem ADM</th>
                        </tr>
                    </thead>
                    <tbody>
<?=$usertable?>
                    </tbody>
                </table>   
                <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
                <script>
                    $(document).ready( function () {
                        const categorias = { 'CHOCOLATE': 1, 'BRIGADEIRO': 2, 'MORANGO': 3, 'BAUNILHA': 4, 'LARANJA': 5};
                        var tablepai = $('#table-pai').DataTable({ //Inicializa pai
                            language: {
                                url: './js/datatablept.json'
                            },
                        });
                        $('#table-pai tbody').on('click', 'tr', function () { //Ações ao clicar na tabela pai
                            if ($(this).hasClass('highlight')) {
                                $(this).removeClass('highlight');
                            } else {
                                $('tr.highlight').removeClass('highlight');
                                $(this).addClass('highlight');
                            }
                        });
                    })
                    $(document).on('click', '.btn-toggle-admin', function() {
                        var row = $(this).closest('tr');
                        var userId = row.data('id');
                        var action = $(this).text().toLowerCase().includes("remover") ? 'remover' : 'permitir';
                        $.ajax({
                            url: 'ajax.php',
                            method: 'POST',
                            data: {
                                user_id: userId,
                                acao: action
                            },
                            success: function(response) {
                                if (action === 'remover') {
                                    $(this).text('PERMITIR');
                                } else {
                                    $(this).text('REMOVER');
                                }
                                alert(response);
                            },
                            error: function() {
                                alert(response);
                            }
                        });
                    });
                </script>
                