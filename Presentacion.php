<?php

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

/**
* 
*/
class Presentacion
 {
     
	function __construct()
    {
    }

	
	public static function getAll(){
		$sql = "SELECT DISTINCT unida FROM presentacion";
		$response = self::executeSqlConverterToArray($sql);
		return self::printResponseInJsonEncode($response); 
	}

	private static function executeSqlConverterToArray($sql){
		$cadena = self::createConnectionDataBase();
		$query = pg_query($cadena,$sql);
		return self::converterResponseQueryToArray($query);
	}

	private static function createConnectionDataBase(){
		$conectar='host=localhost user=postgres password=kaoz1993 port=5432 dbname=cm_massbarato';
		$cadena= pg_connect ($conectar) or die ("Error de conexion".pg_last_error());
		return $cadena;
	}

	/**
     * Realizar la consulta retorna datos en variable tipo array
     *
     * @param $query Objeto pg_query
     * @return Regresa array con el $index y value, y nombre row y value
     */
	private static function converterResponseQueryToArray($query){
		$response;
		while ($row=pg_fetch_array($query)) {
				$response[] = $row;
        }
        return $response;
	}


	private static function printResponseInJsonEncode($response){
		if ($response) {
			return json_encode($response);
		}else{
			self::nullResponse();
		}
	}

	private static function nullResponse(){
		print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'No se obtuvo el registro'
                )
            );
	}
}

?>
