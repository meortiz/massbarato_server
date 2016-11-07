<?php 

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);
header('Content-Type: application/json');

include  '../../Modelo/Modelo.php';
require "../../Cliente.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $clientes = json_decode(Cliente::getAll());

    if ($clientes) {

        $datos["estado"] = 1;
        $datos["clientes"] = $clientes;

        print json_encode($datos,JSON_UNESCAPED_UNICODE);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

?>