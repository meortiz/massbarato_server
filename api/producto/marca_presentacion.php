<?php 

error_reporting(-1);
ini_set("display_errors", 1);
header('Content-Type: charset=utf-8');

include  '../../Modelo/Modelo.php';
require "../../Modelo/Producto.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $productos = null;
    
    // Manejar petición GET
    if ( isset($_GET['nombre'])
         AND isset($_GET['marca']) 
         AND isset($_GET['presentacion'])) {
        
        $productos = Producto::getForMarcaAndPresentacion(
                $_GET['nombre'],
                $_GET['marca'],
                $_GET['presentacion']);

        $productos=json_decode($productos);        
    }
    else {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        print json_encode(array(
            "estado" => 3,
            "mensaje" => 'Url no valida'.$actual_link
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