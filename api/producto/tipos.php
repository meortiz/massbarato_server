<?php 

error_reporting(-1);
ini_set("display_errors", 1);
header('Content-Type: charset=utf-8');

include  '../../Modelo/Modelo.php';
require "../../Modelo/Tipo.php";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {    
    
    $datos = array();
    $tipos = Tipo::findAll();
    $tipos=json_decode($tipos);
     // validamos si retorno datos
    if ($tipos) {
        $datos["estado"] = 1;
        $datos["tipos"] = $tipos;
    }
    else {
       $datos['mensaje'] = 'No se encotratos datos tabla Tipos';
    }
    print json_encode($datos);
    
}
 else {
        print json_encode(array(
            "estado" => 3,
            "mensaje" => 'Url no valida'
        ));
        die;
}

 ?>