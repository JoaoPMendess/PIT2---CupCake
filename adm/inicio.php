<?php
    $valdashboard = DB::fetchOne("SELECT SUM(if(finalizado_data >= (date(now()) - INTERVAL 7 DAY), valor, 0)) as SEMANAL,
                     sum(valor) as MENSAL, sum(IF(finalizado, 1,0)) as FINALIZADOS, sum(IF(!finalizado, 1,0)) AS PENDENTES FROM pedidos");
    $semanal    = $valdashboard['SEMANAL'];
    $mensal     = $valdashboard['MENSAL'];
    $valdashboard = DB::fetchOne("SELECT sum(IF(finalizado, 1,0)) as FINALIZADOS, sum(IF(!finalizado, 1,0)) AS PENDENTES FROM pedidos_cab");
    $finalizado = $valdashboard['FINALIZADOS'];
    $pendente   = $valdashboard['PENDENTES'];
    $evomensal = DB::fetchAll("SELECT SUM(valor) AS total, UPPER(LEFT(MONTHNAME(finalizado_data),3)) AS MES,
                MONTH(finalizado_data) Mes_, YEAR(finalizado_data) AS ano FROM pedidos GROUP BY MES,mes_,ano ORDER BY ano asc, mes_ asc LIMIT 5");
    $cattotal  = DB::fetchAll("SELECT sum(quantidade) AS qtd, IF(categoria_prod = 1, 'CHOCOLATE', IF(categoria_prod = 2, 'BRIGADEIRO', IF(categoria_prod = 3, 'MORANGO', IF(categoria_prod = 4, 'BAUNILHA', 
    IF(categoria_prod = 5, 'LARANJA', 'LIMAO'))))) AS catnome FROM pedidos WHERE finalizado_data >= (date(now()) - INTERVAL 30 DAY) GROUP BY categoria_prod ORDER BY qtd DESC");
    echo "<script>mes=[];valormes=[];catnome = []; catqtd = [];";
    foreach ($evomensal as $linha) {
        echo "mes.push('$linha[MES]');";
        echo "valormes.push('$linha[total]');";
    }
    foreach ($cattotal as $linha) {
        echo "catnome.push('$linha[catnome]');";
        echo "catqtd.push('$linha[qtd]');";
    }
    echo "</script>"
?>                
                <link href="css/sb-admin.css" rel="stylesheet">
                <link
                href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
                rel="stylesheet">
                <div class="d-sm-flex align-items-center justify-content-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800 text-center">Dashboard</h1>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Venda (Ult. 7 Dias)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?=$semanal?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M96 32l0 32L48 64C21.5 64 0 85.5 0 112l0 48 448 0 0-48c0-26.5-21.5-48-48-48l-48 0 0-32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 32L160 64l0-32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192L0 192 0 464c0 26.5 21.5 48 48 48l352 0c26.5 0 48-21.5 48-48l0-272z"/></svg></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Venda (Mensal)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?=$mensal?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pedidos Atendidos
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$finalizado?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Pedidos Pendentes</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$pendente?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Evolução mensal</h6>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="chart-area flex-fill">
                                    <canvas id="myAreaChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Categorias mais vendidas (Mensal)</h6>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="chart-pie flex-fill">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="js/Chart.min.js"></script>
                <script src="js/chart-area-demo.js"></script>
                <script src="js/chart-pie-demo.js"></script>    