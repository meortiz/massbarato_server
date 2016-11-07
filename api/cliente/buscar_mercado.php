<?php 

error_reporting(-1);
ini_set("display_errors", 1);
header('Content-Type: charset=utf-8');

include  '../../Modelo/Modelo.php';
require "../../Cliente.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $mercados = null;
    
    /** Manejar petición GET
        URL.php?cliente=xxx?
            ?productos[][nombre]=xxxx
            ?productos[][marca]=xxx
            ?productos[][presentacion]=xxx
            ?productos[][nombre]...
    */
    if (isset($_GET['productos'])) {
        
        $mercados=json_decode(Cliente::buscarMercadoCompleto($_GET['productos']));

    }
    else {
        print json_encode(array(
            "estado" => 3,
            "mensaje" => 'Url no valida'
        ));
        die;
     }

     // validamos si retorno datos
    if ($mercados) {
        $datos["estado"] = 1;
        $datos["mercados"] = $mercados;
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