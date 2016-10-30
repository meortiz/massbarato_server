<?php 

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);
header('Content-Type: application/json');

require "Producto.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $productos = json_decode(Producto::getAll());

    if ($productos) {

        $datos["estado"] = 1;
        $datos["productos"] = $productos;

        print json_encode($datos,JSON_UNESCAPED_UNICODE);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

?>