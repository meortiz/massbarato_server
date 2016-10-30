<?php

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

/**
* 
*/
class Producto {
     
	function __construct()
    {
    }
    
    public static function getForMarcaAndPresentacion($marca,$presentacion){
    	$sql = "SELECT * FROM producto 
    			JOIN marca M 
    				ON producto.idmarcap = M.idmarca
    			JOIN presentacion U
    				ON producto.idpresentacionp = U.idpresentacion
    			JOIN supermercado S
    				ON producto.idsupermercadop = S.idsupermercado
				WHERE 
					UPPER(M.nommarca) LIKE UPPER('%$marca%') 
					AND 
					UPPER(U.unida) LIKE UPPER('%$presentacion%')";

    	$response = self::executeSqlConverterToArray($sql);
		return self::printResponseInJsonEncode($response);
    			
    }
	
	public static function getAll(){
		$sql = "SELECT * FROM producto 
				JOIN marca M 
    				ON producto.idmarcap = M.idmarca
    			JOIN presentacion U
    				ON producto.idpresentacionp = U.idpresentacion
    			JOIN supermercado S
    				ON producto.idsupermercadop = S.idsupermercado";
		$response = self::executeSqlConverterToArray($sql);
		return self::printResponseInJsonEncode($response); 
	}

	public static function findByCategoria($categoria){
		return self::getBy('categoria',$categoria);	
	}

	public static function getBy($row,$data){
		$sql = "SELECT * FROM producto WHERE UPPER($row) LIKE UPPER('%$data%') ORDER BY $row";
		$response = self::executeSqlConverterToArray($sql);
		return self::printResponseInJsonEncode($response);
	}


	private static function executeSqlConverterToArray($sql){
		$cadena = self::createConnectionDataBase();
		$query = pg_query($cadena,$sql);
		return self::converterResponseQueryToArray($query);
	}

	private static function createConnectionDataBase(){
		$conectar='host=localhost user=postgres password=kaoz1993 port=5432 dbname=Masbarato';
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
