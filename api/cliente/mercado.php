<?php 

error_reporting(-1);
ini_set("display_errors", 1);
header('Content-Type: charset=utf-8');

include  '../../Modelo/Modelo.php';
require "../../Cliente.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $mercado = null;
    
    /** Manejar petición GET
        URL.php?cliente=xxx?
            ?productos[][nombre]=xxxx
            ?productos[][marca]=xxx
            ?productos[][presentacion]=xxx
            ?productos[][nombre]...
    */
    if (isset($_GET['cliente']) && isset($_GET['productos'])) {
        
        $mercado=json_decode(Cliente::hacerMercadoCompleto($_GET['cliente'],$_GET['productos']));

    }
    else {
        print json_encode(array(
            "estado" => 3,
            "mensaje" => 'Url no valida'
        ));
        die;
     }

     // validamos si retorno datos
    if ($mercado) {
        $datos["estado"] = 1;
        $datos["mercado"] = $mercado;
        print json_encode($datos);
    } 
    else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => 'No se encontraron resultados'
        ));
    }
     
    
}

 ?>