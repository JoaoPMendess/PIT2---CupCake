<?php
$droplogin = '';
if (!$logado) {
    $contatxt = "Conta";
    $droplogin = <<<E
                            <ul class="dropdown-menu">
                                <li class="dropdown-item text-center"><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-action="login">Entrar</a></li>
                                <li class="dropdown-item text-center"><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-action="register">Cadastrar</a></li>
                            </ul>
                E;
} else{
    $contatxt = "Olá, ".!Empty($_SESSION["nome"]) ? $_SESSION["nome"] : "Consumidor";
    $droplogin = <<<E
                <ul class="dropdown-menu">
                    <li class="dropdown-item text-center"><a class="dropdown-item" href="adm.php">Administração</a></li>
                    <li class="dropdown-item text-center"><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-action="conta">Conta</a></li>
                    <li class="dropdown-item text-center"><a class="dropdown-item" href="#" id="deslogar">Sair</a></li>
                </ul>
E;
    $nome = $_SESSION['nome'];
    $telefone = $_SESSION['telefone'];
    $user_id = $_SESSION['id'];
}
echo <<<E
<nav class="navbar navbar-expand-lg navbar-dark position-fixed">
    <div class="container">
        <a class="navbar-brand" href="index.php">Cupcake Store</a>
        <a class="navbar-brand cart" id="cartDropdown" role="button" data-bs-toggle="dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart2" viewBox="0 0 20 20">
                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
            </svg>
            <span class="cart-counter" id="cartCounter">0</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end cartitems" id="cartItems">
            <li class="dropdown-item text-center"><strong>Total: <span id="cartTotal">R$ 0,00</span></strong></li>
        </ul>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown position-relative">
                <a class="nav-link cart-drop" href="#" id="cartDropdown" role="button" data-bs-toggle="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart2" viewBox="0 0 20 20">
                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                    </svg>
                    Carrinho
                    <span class="cart-counter" id="cartCounter">0</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end cartitems" id="cartItems">
                    <li class="dropdown-item text-center"><strong>Total: <span id="cartTotal">R$ 0,00</span></strong></li>
                </ul>

            </li>
            <li class="nav-item dropdown ">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-square" viewBox="0 0 20 20">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                    </svg>                    
                    $contatxt
                </a>
$droplogin
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-question-lg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.475 5.458c-.284 0-.514-.237-.47-.517C4.28 3.24 5.576 2 7.825 2c2.25 0 3.767 1.36 3.767 3.215 0 1.344-.665 2.288-1.79 2.973-1.1.659-1.414 1.118-1.414 2.01v.03a.5.5 0 0 1-.5.5h-.77a.5.5 0 0 1-.5-.495l-.003-.2c-.043-1.221.477-2.001 1.645-2.712 1.03-.632 1.397-1.135 1.397-2.028 0-.979-.758-1.698-1.926-1.698-1.009 0-1.71.529-1.938 1.402-.066.254-.278.461-.54.461h-.777ZM7.496 14c.622 0 1.095-.474 1.095-1.09 0-.618-.473-1.092-1.095-1.092-.606 0-1.087.474-1.087 1.091S6.89 14 7.496 14"/>
                    </svg>    
                    Sobre
                </a>
            </li>
        </ul>
        </div>
    </div>
</nav>
E;
if (!$logado) {
    echo <<<E
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="btn-group" role="group" aria-label="Auth options">
                        <button type="button" class="btn btn-secondary" id="tab-entrar">Entrar</button>
                        <button type="button" class="btn btn-secondary" id="tab-cadastro">Cadastrar</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="form-entrar">
                        <div class="form-group">
                            <label for="entrar-user">Nome de usuário ou Email</label>
                            <input type="text" class="form-control" id="entrar-user" required>
                        </div>
                        <div class="form-group">
                            <label for="entrar-senha">Senha</label>
                            <input type="password" class="form-control" id="entrar-senha" required>
                        </div>
                        <div class="form-group">
                            <label for="entrar-captcha">Captcha</label>
                            <input type="text" class="form-control" id="entrar-captcha" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Entrar</button>
                    </form>
                    <form id="form-cadastro" style="display: none;">
                        <div class="form-group">
                            <label for="cadastro-nome">Nome</label>
                            <input type="text" class="form-control" id="cadastro-nome" required>
                        </div>
                        <div class="form-group">
                            <label for="cadastro-user">Usuário</label>
                            <input type="text" class="form-control" id="cadastro-user" required>
                        </div>
                        <div class="form-group">
                            <label for="cadastro-email">Email</label>
                            <input type="email" class="form-control" id="cadastro-email" required placeholder="digite seu email ex: email@email.com">
                        </div>
                        <div class="form-group">
                            <label for="cadastro-telefone">Telefone</label>
                            <input type="text" class="form-control" id="cadastro-telefone" required>
                        </div>
                        <div class="form-group">
                            <label for="cadastro-senha">Senha</label>
                            <input type="password" class="form-control" id="cadastro-senha" required maxlength="20" placeholder="Até 20 caracteres">
                        </div>
                        <div class="form-group">
                            <label for="cadastro-conf">Confirmar Senha</label>
                            <input type="password" class="form-control" id="cadastro-conf" required placeholder="Confirme a senha digitada">
                        </div>
                        <div class="form-group">
                            <label for="cadastro-captcha">Captcha</label>
                            <input type="text" class="form-control" id="cadastro-captcha" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mensagemModal" tabindex="-1" aria-labelledby="mensagemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mensagemModalLabel">Mensagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mensagemModalBody">
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#cadastro-telefone").mask("(00) 0 0000-0000");
            $('#authModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var action = button.data('action');
                if (action === 'login') {
                    $('#tab-entrar').click();
                } else if (action === 'register') {
                    $('#tab-cadastro').click();
                }
            });

            $('#tab-entrar').on('click', function () {
                $('#form-entrar').show();
                $('#form-cadastro').hide();
                $('#tab-entrar').addClass('btn-primary').removeClass('btn-secondary');
                $('#tab-cadastro').addClass('btn-secondary').removeClass('btn-primary');
            });

            $('#tab-cadastro').on('click', function () {
                $('#form-entrar').hide();
                $('#form-cadastro').show();
                $('#tab-cadastro').addClass('btn-primary').removeClass('btn-secondary');
                $('#tab-entrar').addClass('btn-secondary').removeClass('btn-primary');
            });
            $('#form-cadastro').on('submit', function(event) {
                event.preventDefault();
                var nome = $('#cadastro-nome').val();
                var user = $('#cadastro-user').val();
                var email = $('#cadastro-email').val();
                var telefone = $('#cadastro-telefone').val();
                var senha = $('#cadastro-senha').val();
                var captcha = $('#cadastro-captcha').val();
                $.ajax({
                    url: 'ajax.php',
                    method: 'POST',
                    data: {
                        cadastro : 1,
                        nome: nome,
                        usuario: user,
                        email: email,
                        telefone: telefone,
                        senha: senha
                    },
                    success: function(response) {
                        $('#mensagemModalBody').text(response);
                        $('#mensagemModal').modal('show');
                        if (response === 'CADASTRO REALIZADO COM SUCESSO') {
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            setTimeout(function() {
                                $('#mensagemModal').modal('hide');
                            }, 3000);
                        }
                    },
                    error: function() {
                        $('#mensagemModalBody').text('Erro ao tentar fazer cadastrar.');
                        $('#mensagemModal').modal('show');
                        setTimeout(function() {
                            $('#mensagemModal').modal('hide');
                        }, 3000);
                    }
                });
            });
            $('#form-entrar').on('submit', function(event) {
                event.preventDefault();

                var user = $('#entrar-user').val();
                var senha = $('#entrar-senha').val();
                var captcha = $('#entrar-captcha').val();

                $.ajax({
                    url: 'ajax.php',
                    method: 'POST',
                    data: {
                        entrar : 1,
                        usuario: user,
                        senha: senha
                    },
                    success: function(response) {
                        $('#mensagemModalBody').text(response);
                        $('#mensagemModal').modal('show');
                        if (response === 'LOGADO COM SUCESSO') {
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            setTimeout(function() {
                                $('#mensagemModal').modal('hide');
                            }, 3000);
                        }
                    },
                    error: function() {
                        $('#mensagemModalBody').text('Erro ao tentar fazer login.');
                        $('#mensagemModal').modal('show');
                        setTimeout(function() {
                            $('#mensagemModal').modal('hide');
                        }, 3000);
                    }
                });
            });
        });
    </script>
    E;
} else {
echo <<<E
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authModalLabel">Editar Conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAccountForm">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="userName" name="name" minlenght="10" required>
                        </div>
                        <div class="mb-3">
                            <label for="userPhone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="userPhone" name="phone" required>
                        </div>
                        <input type="text" class="form-control" id="idAddress" name="idAddress" hidden>
                        <div class="mb-3">
                            <label for="userAddress" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="userAddress" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="userNumber" class="form-label">Número</label>
                            <input type="text" class="form-control" id="userNumber" name="number" required>
                        </div>
                        <div class="mb-3">
                            <label for="userNeighborhood" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="userNeighborhood" name="neighborhood" required>
                        </div>
                        <div class="mb-3">
                            <label for="userZipCode" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="userZipCode" name="zipcode" required>
                        </div>
                        <div class="mb-3">
                            <label for="userCity" class="form-label">Município</label>
                            <input type="text" class="form-control" id="userCity" name="city" required>
                        </div>
                        <div class="mb-3">
                            <label for="userState" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="userState" name="state" required>
                        </div>
                        <div class="mb-3">
                            <label for="userComplement" class="form-label">Complemento (opcional)</label>
                            <input type="text" class="form-control" id="userComplement" name="complement">
                        </div>
                        <div class="mb-3">
                            <label for="userReference" class="form-label">Referência (opcional)</label>
                            <input type="text" class="form-control" id="userReference" name="reference">
                        </div>
                        <div class="mb-3">
                            <label for="userAddressType" class="form-label">Tipo de Endereço</label>
                            <select class="form-select" id="userAddressType" name="address_type" required>
                                <option value="residencial">Residencial</option>
                                <option value="comercial">Comercial</option>
                            </select>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#userPhone").mask("(00) 0 0000-0000");
            function loadUserData() {
                $('#userName').val('$nome');
                $('#userPhone').val('$telefone');
                $.ajax({
                    url: 'ajax.php',
                    type: 'GET',
                    data: {
                    endereco: 1,
                    usuario: $user_id 
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        const address = data.address;
                        if (address) {
                            $('#idAddress').val(address.id);
                            $('#userAddress').val(address.logradouro);
                            $('#userNumber').val(address.numero);
                            $('#userNeighborhood').val(address.bairro);
                            $('#userZipCode').val(address.cep);
                            $('#userCity').val(address.municipio);
                            $('#userState').val(address.estado);
                            $('#userComplement').val(address.complemento || '');
                            $('#userReference').val(address.referencia || '');
                            $('#userAddressType').val(address.tipo_endereco);
                        }
                    },
                    error: function() {
                        alert('Erro ao carregar os dados.');
                    }
                });
            }
            $('#authModal').on('show.bs.modal', function() {
                loadUserData();
            });
            $('#editAccountForm').submit(function(event) {
                event.preventDefault();
                const formData = $(this).serialize();
                $.ajax({
                    url: 'ajax.php?user_id=$user_id',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('Informações atualizadas com sucesso!');
                        $('#authModal').modal('hide');
                    },
                    error: function() {
                        alert('Erro ao enviar os dados.');
                    }
                });
            });
        });
    </script>
E;
}