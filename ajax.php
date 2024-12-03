<?php
    include './include/system.func.php';
    if (isset($_POST['sair'])) {
        session_destroy();
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode('; ', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = $parts[0];
                setcookie($name, '', time() - 3600, '/');
            }
        }        
        http_response_code(200);
        exit();
    }
    if (isset($_POST['acao'])){
        $acao = $_POST['acao'];
        $user = intval(filtra($_POST['user_id']));
        $acao == "remover" ? DB::exQuery("UPDATE usuarios set permissoes = 0 WHERE id = ?", [$user]) : DB::exQuery("UPDATE usuarios set permissoes = 2 WHERE id = ?", [$user]);
        exit();
    }
    if (isset($_POST['address_type']) & isset($_GET['user_id'])){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId         = filtra($_GET['user_id']);
            $idAddress      = filtra($_POST['idAddress']);
            $name           = filtra($_POST['name']);
            $phone          = filtra($_POST['phone']);
            $address        = filtra($_POST['address']);
            $number         = filtra($_POST['number']);
            $neighborhood   = filtra($_POST['neighborhood']);
            $zipcode        = filtra($_POST['zipcode']);
            $city           = filtra($_POST['city']);
            $state          = filtra($_POST['state']);
            $complement     = filtra($_POST['complement']);
            $reference      = filtra($_POST['reference']);
            $address_type   = filtra($_POST['address_type']);
            if (DB::exQuery("SELECT * FROM enderecos where id = ?", [$idAddress])->num_rows > 0){
                $query =" UPDATE enderecos SET 
                logradouro      = ?,
                numero          = ?,
                bairro          = ?,
                cep             = ?,
                municipio       = ?,
                estado          = ?,
                complemento     = ?,
                referencia      = ?,
                tipo_endereco   = ? WHERE id = ? AND cliente_id = ?
            ";
                $queryusers = DB::exQuery($query, [$address, $number, $neighborhood, $zipcode, $city, $state, $complement, $reference, $address_type, $idAddress, $userId]);
            }else {
                $queryusers = DB::exQuery("INSERT INTO enderecos (cliente_id, logradouro, numero, bairro, cep, municipio, estado, complemento, referencia, tipo_endereco)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$userId, $address, $number, $neighborhood, $zipcode, $city, $state, $complement, $reference, $address_type]);
            }
            exit();
        }
    }
    if (isset($_GET['endereco'])){
        $user_id = intval(filtra($_GET['usuario']));
        $resultado = DB::fetchOne("SELECT * FROM enderecos WHERE cliente_id = ?", [$user_id]);
        echo json_encode(['address' => $resultado]);
        exit();
    }
    if(isset($_GET['criapedido']) & isset($_GET['cliente'])){
        $cliente = filtra($_GET['cliente']);
        $data = file_get_contents('php://input');
        $carrinho = json_decode($data, true);
        $clienteconsulta = DB::fetchOne("SELECT u.id AS cliente_id, e.id AS endereco_id
            FROM usuarios u
            LEFT JOIN enderecos e ON e.cliente_id = u.id
            WHERE u.id = ?", [$cliente]);
        DB::exQuery("INSERT INTO pedidos_cab (`data`, cliente_id) VALUES (NOW(), ?)", [$cliente]);
        $pedido_ID = DB::insertID();
        foreach ($carrinho as $item) {
            $idprod = intval($item['id']);
            $quantidade = intval($item['quantidade']);
            $produtoconsulta = DB::fetchOne("SELECT v.id AS produto_id, v.valor AS bruto, v.promocao, round(v.valor - v.valor * (v.promocao / 100),2) AS unitario, v.categoria
            FROM vitrine v
            WHERE v.id = ? AND v.ativo = 1", [$idprod]);
            $paramsPedido = [
                $pedido_ID,
                $produtoconsulta['produto_id'],
                $clienteconsulta['cliente_id'],
                $clienteconsulta['endereco_id'],
                $produtoconsulta['unitario'],
                $produtoconsulta['bruto'],
                $produtoconsulta['unitario'] * $quantidade,
                $produtoconsulta['promocao'],
                $quantidade,
                $produtoconsulta['categoria']
            ];
            $QueryPedido = "
                INSERT INTO pedidos (
                    pedido_id, produto_id, cliente_id, endereco_id, unitario, bruto, valor, promocao, 
                    pago, tipo_pg, data, finalizado_data, finalizado, quantidade, categoria_prod
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, 0, 1, NOW(), NULL, 0, ?, ?
                )";
            DB::exQuery($QueryPedido, $paramsPedido);
           
        }
        echo $pedido_ID;
        exit();
    }
    if(isset($_POST['finalizapedido']) & isset($_POST['id'])){
        DB::exQuery("UPDATE pedidos_cab SET finalizado = 1, data_finalizado = NOW() WHERE id = ?", [filtra($_POST['id'])]);
        DB::exQuery("UPDATE pedidos SET finalizado = 1, finalizado_data = NOW() WHERE pedido_id = ?", [filtra($_POST['id'])]);
        exit();
    }
    if(isset($_POST['entrar']) & isset($_POST['usuario']) & isset($_POST['senha'])){
        if($_SESSION['LOGADO']){
            echo "Você já está logado";
        } else {
            $usuario    = trim(filtra($_POST['usuario']));
            $senha      = trim(filtra($_POST['senha']));
            if (empty($usuario) or empty($senha)){
                echo "Há dados vazios ou inválidos";
            } else{
                if (!$senha) {
                    echo "Houve um problema ao prosseguir, tente novamente.";
                } else{
                    $resultado = DB::exQuery("SELECT id, nome, email, usuario, telefone, permissoes, ult_compra, data_cadastro, senha FROM usuarios WHERE email = ? OR usuario = ?", [$usuario, $usuario]);
                    if($resultado->num_rows > 0) {
                        $resultado = $resultado->fetch_assoc();
                        $passwd = $resultado['senha'];
                        if (password_verify($senha, $passwd)){
                            $_SESSION['id']             = $resultado['id'];
                            $_SESSION['nome']           = $resultado['nome'];
                            $_SESSION['email']          = $resultado['email'];
                            $_SESSION['telefone']       = $resultado['telefone'];
                            $_SESSION['permissao']      = $resultado['permissoes'];
                            $_SESSION['ult_compra']     = $resultado['ult_compra'];
                            $_SESSION['data_cadastro']  = $resultado['data_cadastro'];
                            $_SESSION['LOGADO']         = true;
                            $usuario_id                 = $resultado['id'];
                            echo "LOGADO COM SUCESSO";
                        } else{
                            echo "Usuário ou senha incorretos!";
                        }
                    } else {
                        echo "Usuário ou senha incorretos!";
                    }
                }
            }
        }
    } elseif (isset($_POST['cadastro']) & isset($_POST['usuario']) & isset($_POST['senha'])) {
        if($_SESSION['LOGADO']){
            echo "Você está logado!";
        } else {
            $nome       = trim(filtra($_POST['nome']));
            $usuario    = trim(filtra($_POST['usuario']));
            $email      = trim(filtra($_POST['email']));
            $telefone   = trim(filtra($_POST['telefone']));
            $senha      = trim(filtra($_POST['senha']));
            if (empty($usuario) or empty($senha) or empty($email) or empty($telefone)){
                echo "Há dados vazios ou inválidos";
            } else {
                if (!validaemail($email)){
                    echo "O email digitado é inválido!";
                } else {
                    $compara = DB::exQuery("SELECT usuario, email FROM usuarios WHERE email = ? OR usuario = ?", [$email, $usuario]);
                    if ($compara->num_rows > 0) {
                        $compara = $compara->fetch_assoc();
                        if ($compara['usuario'] == $usuario){
                            echo "O usuário inserido é inválido, por favor tente utilizar outro.";
                        } else {
                            echo "O email inserido é inválido!";
                        }
                    } else {
                        $pass = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 12]);
                        $insert = DB::exQuery("INSERT INTO `usuarios` (nome, email, usuario, telefone, senha) VALUES (?, ?, ?, ?, ?)", [$nome, $email, $usuario, $telefone, $pass]);
                        if ($insert > 0) {
                            echo "Cadastro realizado com sucesso!";
                        } else {
                            echo "Houve um problema ao finalizar o cadastro, se persistir contate nossa central!";
                        }
                    }
                }
            }
        }
    }