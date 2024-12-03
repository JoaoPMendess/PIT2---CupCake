<?php
    include './include/system.func.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loja de Cupcakes</title>
  <link href="./css/bootstrap.css" rel="stylesheet">  
  <link href="./css/style.css" rel="stylesheet">
  <script src="./js/jquery.js"></script>
</head>
<body>

<!-- include menu -->
<?php include './include/menu.php'?>

<!-- Cards de Produtos -->
<?php include './include/vitrine.php'?>
<div class="modal fade" id="pedidoModal" tabindex="-1" aria-labelledby="pedidoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="pedidoModalLabel">Pedido gerado com sucesso!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Para facilitar a separação do produto, nos encaminhe seu pedido via WhatsApp:</p>
        <a id="btnWhatsApp" class="btn btn-primary">
          Enviar pedido via WhatsApp
        </a>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function () {
      products = {
        <?php
        foreach($vitrine as $produto) {
          $valpromo = str_replace(",", ".", $produto['valpromo']);
          echo "$produto[id]: {name: '$produto[nome]', price: $valpromo},";
        }
        ?>};
    });
    id = <?=$usuario_id?>;
</script>
<script src="./js/custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="./js/bootstrap.js"></script>
</body>
</html>