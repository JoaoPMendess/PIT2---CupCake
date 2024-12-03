$(document).ready(function () {
    carrinho = [];
    function atualizaElementos() {
      const cartCount = localStorage.getItem("cartCounter") || 0;
      $(".cart-counter").text(cartCount);

      $(".product-counter").each(function () {
        const productId = $(this).data("product");
        const productCount = localStorage.getItem(`product_${productId}`) || 0;
        if (productCount > 0) {
          $(`.btn-buy-product[data-product='${productId}']`).hide();
          $(`.btn-group-product[data-product='${productId}']`).show();
        } else {
          $(`.btn-buy-product[data-product='${productId}']`).show();
          $(`.btn-group-product[data-product='${productId}']`).attr('style','display: none !important');  
        }
        $(this).text(productCount);
      });
    }
    function updateCartDropdown() {
      const $cartItems = $(".cartitems");
      const $cartTotal = $("#cartTotal");
      let total = 0;
      carrinho = []
      $cartItems.html("");

      for (const productId in products) {
        const count = parseInt(localStorage.getItem(`product_${productId}`)) || 0;
        if (count > 0) {
          const product = products[productId];
          const subtotal = product.price * count;
          total += subtotal;
          carrinho.push({'id': productId, 'nome': product.name, 'quantidade': count, 'valor': subtotal.toFixed(2)});
          $cartItems.append(`
            <li class="dropdown-item d-flex justify-content-between align-items-center">
              <a class="nav-link" style="display:contents">
                <button id="btn-limpa" class="btn btn-limpa" data-product="${productId}"><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16" color="black">
                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                </svg></span></button>
              </a>
              <span>${product.name} (x${count})</span>
              <span>R$ ${subtotal.toFixed(2)}</span>
            </li>
          `);
        }
      }

      if (total === 0) {
        $cartItems.append('<li class="dropdown-item text-center">Seu carrinho está vazio.</li>');
      }

      $cartItems.append(`
        <li class="dropdown-item text-center"><strong>Total: R$ ${total.toFixed(2)}</strong></li>
      `);
      if (total > 0) {
        $cartItems.append(`
          <li class="dropdown-item text-center">
            <button id="btnGerarPedido" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#pedidoModal">
              Gerar Pedido
            </button>
          </li>
        `);
      }

      $cartTotal.text(`R$ ${total.toFixed(2)}`);
    }

    $("#cartDropdown").on("click", updateCartDropdown);

    function incrementProduct(productId) {
      const productCounter = $(`.product-counter[data-product='${productId}']`);
      const currentCount = parseInt(productCounter.text()) + 1;
      productCounter.text(currentCount);

      const globalCount = parseInt($("#cartCounter").text()) + 1;
      $(".cart-counter").text(globalCount);

      localStorage.setItem(`product_${productId}`, currentCount);
      localStorage.setItem("cartCounter", globalCount);

      updateCartDropdown();
    }

    function decrementProduct(productId, remove) {
      const productCounter = $(`.product-counter[data-product='${productId}']`);
      let currentCount = parseInt(productCounter.text());
      if (remove) {
        const globalCount = parseInt($("#cartCounter").text()) - currentCount;
        $(".cart-counter").text(globalCount);
        currentCount -= currentCount;
        productCounter.text(currentCount);
        localStorage.setItem(`product_${productId}`, currentCount);
        localStorage.setItem("cartCounter", globalCount);

        updateCartDropdown();
        $(`.btn-buy-product[data-product='${productId}']`).show();
        $(`.btn-group-product[data-product='${productId}']`).attr('style','display: none !important');
      }else {
        if (currentCount > 0) {
          currentCount -= 1;
          productCounter.text(currentCount);

          const globalCount = parseInt($("#cartCounter").text()) - 1;
          $(".cart-counter").text(globalCount);

          localStorage.setItem(`product_${productId}`, currentCount);
          localStorage.setItem("cartCounter", globalCount);

          updateCartDropdown();

          if (currentCount === 0) {
            $(`.btn-buy-product[data-product='${productId}']`).show();
            $(`.btn-group-product[data-product='${productId}']`).attr('style','display: none !important');  
          }
        }
      }
    }

    $(".btn-increment").on("click", function () {
      const productId = $(this).data("product");
      incrementProduct(productId);
    });

    $(".btn-decrement").on("click", function () {
      const productId = $(this).data("product");
      decrementProduct(productId);
    });

    $(".btn-buy-product").on("click", function () {
      const productId = $(this).data("product");
      $(this).hide();
      $(`.btn-group-product[data-product='${productId}']`).show();
      incrementProduct(productId);
    });
    $(document).on("click", ".btn-limpa", function () {
      const productId = $(this).data("product");
      decrementProduct(productId, true);
    });
    $("#deslogar").click(function() {
      $.ajax({
        url: 'ajax.php',
        method: 'POST',
        data: {
            sair : 1
        },
        success: function(response) {
          window.location.reload(true)
        }
      });
    });
    $('#btnWhatsApp').on('click', function () {
      let total = 0;
      let mensagemProdutos = "Resumo do pedido:\n";
      carrinho.forEach(item => {
        total += item.quantidade * item.valor;
        mensagemProdutos += `- ${item.nome} (x${item.quantidade}) - R$ ${item.valor}\n`;
      });
      mensagemProdutos += `\nTotal: R$ ${total.toFixed(2)}\n\n`;
      const mensagem =
        encodeURIComponent(
          `${mensagemProdutos}Para facilitar a separação do produto, nos encaminhe seu pedido via WhatsApp.`
        );
      const numero = "5519989258369";

      // Detecta se o usuário está em um dispositivo móvel
      const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
      const linkWhatsApp = isMobile
        ? `whatsapp://send?phone=${numero}&text=${mensagem}`
        : `https://web.whatsapp.com/send?phone=${numero}&text=${mensagem}`;
      window.open(linkWhatsApp, '_blank');
    });
    $(document).on('click', '#btnGerarPedido', function() {
      let carrinhobkp = carrinho;
      localStorage.clear();
      atualizaElementos()      
      updateCartDropdown();
      carrinho = carrinhobkp;
      $.ajax({
        url: `ajax.php?criapedido=1&cliente=${id}`,
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(carrinho),
        success: function(response) {
          console.log(response);
        }
      });
    });
    atualizaElementos()
    updateCartDropdown()
  });


