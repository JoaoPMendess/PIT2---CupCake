<?php
$qtdpaginacao = ceil(DB::fetchOne("SELECT vitrine_qtd/8 as qtd FROM utils")['qtd']);
if (!isset($_GET['pagina'])) {
  $paginacao = 1;
} else{
  $paginacao   = intval(filtra($_GET['pagina']));
  if ($paginacao == 0) {
    $paginacao = 1;
  } elseif ($paginacao > $qtdpaginacao){
    $paginacao = $qtdpaginacao;
  }
}
$paginacaon = ($paginacao - 1) * 8;
$vitrine = DB::fetchAll("SELECT id, nome, descricao, categoria, REPLACE(valor, '.',',') AS valor, REPLACE(promocao, '.',',') AS promocao,
                              ativo, imagem, REPLACE(round(valor - valor * (promocao / 100),2), '.',',') AS valpromo FROM vitrine WHERE ativo LIMIT $paginacaon,8");
echo <<<E
<div class="container mt-3">
  <h2 class="text-center mb-3">Nossos Cupcakes</h2> 
  <div class="row">
E;
foreach ($vitrine as $produtos) {
  $valor = $produtos['promocao'] > 0.1 ? '<p class="price">R$ <span class="text-decoration-line-through">'. $produtos["valor"] .'</span><span> '.$produtos['valpromo'] . '</span></p>' : '<p class="price">'. $produtos["valor"] .'</p>';
  echo <<<E
  
      <div class="col-md-3 mb-3">
        <div class="card h-100" data-product="$produtos[id]">
          <img src="./imagens/vitrine/$produtos[imagem].jpg" class="card-img-top">
          <div class="card-body d-flex flex-column text-center">
            <h5 class="card-title">$produtos[nome]</h5>
            <div class="price-wrapper flex-grow-1 d-flex align-items-center justify-content-center">
              $valor
            </div>
            <div class="mt-auto">
              <button class="btn btn-buy btn-buy-product" style="display: none;" data-product="$produtos[id]">Comprar</button>
              <div class="d-flex justify-content-center align-items-center mt-3 btn-group-product" data-product="$produtos[id]" style="display: none !important;">
                <button class="btn btn-counter btn-decrement" data-product="$produtos[id]">-</button>
                <span class="mx-3 product-counter" data-product="$produtos[id]">0</span>
                <button class="btn btn-counter btn-increment" data-product="$produtos[id]">+</button>
              </div>
            </div>
          </div>
        </div>
      </div>
  E;
}
$botoespagina = '';
for ($i = 1; $i <= $qtdpaginacao; $i++) {
  $enabled = $paginacao == $i ?"disabled":"";
  $botoespagina .= "                <li class='page-item $enabled'><a class='page-link' href='?pagina=$i'>$i</a></li>\n";
}
$btnAnt     = $paginacao - 1;
$btnProx    = $paginacao + 1;
$btnAntAtv  = $paginacao <= 1 ? " disabled" : '';
$btnproxAtv = $paginacao == $qtdpaginacao ? " disabled" : '';

echo <<<E

  </div>
</div>
<div class="container mt-5">
    <nav aria-label="Paginação de produtos">
        <ul class="pagination justify-content-center">
            <li class="page-item$btnAntAtv">
                <a class="page-link" href="?pagina=$btnAnt" tabindex="-1" aria-disabled="true">Anterior</a>
            </li>
$botoespagina
            <li class="page-item$btnproxAtv">
                <a class="page-link" href="?pagina=$btnProx">Próximo</a>
            </li>
        </ul>
    </nav>
</div>
E;
?>
