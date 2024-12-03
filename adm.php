<?php
include './include/system.func.php';
http://localhost/PIT/adm.php
if (!isset($_SESSION['LOGADO'])){
    header('location: index.php');
    exit();
} else{
    if(!$_SESSION['LOGADO']){
        header('location: index.php');
        exit();
    }elseif ($_SESSION['permissao'] < 1) {
        header('location: index.php');
        exit();
    }
}
$page = !isset($_GET['pagina']) ? 'inicio' : $page = $_GET['pagina'];
if(!file_exists('adm/' . $page . '.php'))	$page = 'notfound';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loja de Cupcakes</title>
  <link href="./css/bootstrap.css" rel="stylesheet">  
  <link href="./css/adm.css" rel="stylesheet">
  <script src="./js/jquery.js"></script>
</head>
<body id="page-top">
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand d-logo" href="index.php?pagina=inicio">CupCake Store</a>
                    <div class="dropdown mobile-nav-dropdown">
                        <button class="btn btn-dark dropdown-toggle" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M3 12.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="mobileMenuButton">
                            <li><a class="dropdown-item" href="?pagina=inicio">Inicio</a></li>
                            <li><a class="dropdown-item" href="?pagina=pedidos">Pedidos</a></li>
                            <li><a class="dropdown-item" href="?pagina=vitrine">Vitrine</a></li>
                            <li><a class="dropdown-item" href="?pagina=usuarios">Usuários</a></li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center u-navbar">
                        <a class="nav-link text-white d-flex align-items-center" href="index.php" id="deslogar"><span>Sair</span></a>
                    </div>
                </div>
            </nav>
            <nav class="col-sm-3 d-sm-block sidebar">
                <div class="sidebar-sticky pt-3">
                    <a href="?pagina=inicio">Inicio</a>
                    <a href="?pagina=Pedidos">Pedidos</a>
                    <a href="?pagina=vitrine">Vitrine</a>
                    <a href="?pagina=usuarios">Usuários</a>
                </div>
            </nav>
            <main class="col-sm-9 content" id="main">
<?php include 'adm/'.$page.'.php';?>
            </main>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="./js/bootstrap.js"></script>    
</body>

