<?php

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);


/**
* 
*/
class Tipo extends Modelo{
     
	function __construct()
    {
    }
    
    public static function findAll(){
    	$sql = "SELECT DISTINCT tipo_nombre FROM tipo";

    	$response = self::executeSqlConverterToArray($sql);
		return self::printResponseInJsonEncode($response);
    	
    }

}

?>
