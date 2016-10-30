<?php 

error_reporting(-1);
ini_set("display_errors", 1);
header('Content-Type: charset=utf-8');

require "../../Modelo/Producto.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $productos = null;
    
    // Manejar petición GET
    if ( isset($_GET['nombre'])
         AND isset($_GET['marca']) 
         AND isset($_GET['presentacion'])
         AND isset($_GET['cliente'])) {
        
        $productos = Producto::getForMarcaAndPresentacionAndCliente(
                $_GET['nombre'],
                $_GET['marca'],
                $_GET['presentacion'],
                $_GET['cliente']);

        $productos=json_decode($productos);        
    }
    else {
        print json_encode(array(
            "estado" => 3,
            "mensaje" => 'Url no valida'
        ));
        die;
     }

     // validamos si retorno datos
    if ($productos) {
        $datos["estado"] = 1;
        $datos["productos"] = $productos;
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