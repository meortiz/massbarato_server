<?php 

error_reporting(-1);
ini_set("display_errors", 1);
header('Content-Type: charset=utf-8');

include  '../../Modelo/Modelo.php';
require "../../Modelo/Producto.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $productos = null;
    
    if (isset($_GET['row'])) {
        $productos = json_decode( Producto::getBy($_GET['row'],$_GET['data']) );
    }
    else {
        print json_encode(array(
            "estado" => 3,
            "mensaje" => 'Url no valida'
        ));
     }

     // validamos si retorno datos
    if ($productos) {
        $datos["estado"] = 1;
        $datos["Productos"] = $productos;
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