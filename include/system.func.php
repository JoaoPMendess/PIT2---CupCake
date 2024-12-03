<?php
session_name('_');
session_start();
if(!isset($_SESSION['LOGADO'])) {
    $_SESSION['LOGADO'] = false;
    $logado = false;
} else {
    if ($_SESSION['LOGADO']) {
        $logado = true;
    } else {
        $logado = false;
    }
}
$usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
//---- Classes/Funções ----//
include 'db.php';
function filtra($input) {
    $input = preg_replace("/[^\w@!_.,áàâãéèêíïóôõöúüçÁÀÂÃÉÈÊÍÏÓÔÕÖÚÜÇ\s]+/u", "", $input);
    $input = str_ireplace(array("SELECT", "INSERT", "UPDATE", "DELETE", "DROP", "UNION", "WHERE", "FROM", "OR", "AND", "LIKE", "IS NULL"), "", $input);
    $input = trim($input);
    $input = addslashes($input);        
    return $input;
}
function validaemail($email) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
        return false;
    }
}
function MontaTabela($obj, $cont, $tabs = 1, $user = false, $pedido = false) {
    $tabela = '';
    if (gettype($obj) == "object") {
        $obj = $obj->fetch_all();
    }
    foreach ($obj as $array) {
        $tabela .= str_repeat("\t", $tabs) . "<tr data-id='$array[0]'>\n";
        for ($i = 0; $i < $cont; $i++) {
            $tabela .= str_repeat("\t", $tabs + 1) . "<td>" . $array[$i] . "</td>\n";
        }
        if ($user){
            $permuser = $array[1] == 'ADM' ? "REMOVER" : "PERMITIR";
            $tabela .= str_repeat("\t", $tabs + 1) . "<td><button class='btn btn-primary btn-toggle-admin'>$permuser</button></td>\n";
        } else if ($pedido){
            if ($array[6] == 'PENDENTE'){
                $tabela .= str_repeat("\t", $tabs + 1) . "<td><button class='btn btn-primary btn-toggle-pedido'>PENDENTE</button></td>\n";
            } else {
                $tabela .= str_repeat("\t", $tabs + 1) . "<td><button class='btn btn-primary' disabled>FINALIZADO</button></td>\n";
            }
        }
        $tabela .= str_repeat("\t", $tabs) . "</tr>\n";
    }
    return $tabela;
}
