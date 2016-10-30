<?php 
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);
header('Content-Type: application/json');

require "Marca.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $marcas = json_decode(Marca::getAll());

    if ($marcas) {

        $datos["estado"] = 1;
        $datos["marcas"] = $marcas;

        echo json_encode($datos,JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

?>