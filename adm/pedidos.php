<?php

    $usuarios = DB::query("SELECT
    p.ID,
	p.DATA,
	u.nome,
	u.telefone,
	COALESCE (
		DATE_FORMAT(
			p.data_finalizado,
			'%d/%m/%Y'
		),
		'00/00/0000'
	) AS Data_finalizado,
	replace(sum(p1.valor), '.',',') AS Total,

IF (
	! p.finalizado,
	'PENDENTE',
	'FINALIZADO'
) as pendente
FROM
	pedidos_cab p
JOIN usuarios u ON u.id = p.cliente_id
JOIN pedidos p1 ON p1.pedido_id = p.id
AND p1.cliente_id = p.cliente_id
GROUP BY p.id");
    $usertable = MontaTabela($usuarios, 6, 6, false, true);
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
                            <th scope="col">Pedido</th>
                            <th scope="col">Data</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Data Finalizado</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
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
                    $(document).on('click', '.btn-toggle-pedido', function() {
                        var row = $(this).closest('tr');
                        var ped_ID = row.data('id');
                        $.ajax({
                            url: 'ajax.php',
                            method: 'POST',
                            data: {
                                finalizapedido : 1,
                                id: ped_ID,
                            },
                            success:function(response) {
                                location.reload()
                            },
                            error: function() {
                                alert(response);
                            }
                        });
                    });
                </script>
                