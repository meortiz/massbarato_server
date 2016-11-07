<?php

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

/**
* 
*/
class Producto extends Modelo{
     
	function __construct()
    {
    }
    
    public static function getForMarca($nombre,$marca){
    	$sql = "SELECT * FROM producto 
				JOIN marca M 
    				ON producto.marca_codigo 
    					= M.marca_codigo
    			JOIN presentacion P
    				ON producto.presentacion_codigo 
    					= P.presentacion_codigo
    			JOIN cliente C
    				ON producto.cliente_codigo 
    					= C.cliente_codigo
				WHERE
					UPPER(producto.producto_nombre) 
						LIKE UPPER('%$nombre%')
					AND
					UPPER(M.marca_nombre) 
						LIKE UPPER('%$marca%')";

    	$response = self::executeSqlConverterToArray($sql);
		return self::printResponseInJsonEncode($response);
    			
    }


    public static function getForMarcaAndPresentacion($nombre,$marca,$presentacion){
    	$sql = "SELECT * FROM producto 
				JOIN marca M 
    				ON producto.marca_codigo = M.marca_codigo
    			JOIN presentacion P
    				ON producto.presentacion_codigo = P.presentacion_codigo
    			JOIN cliente C
    				ON producto.cliente_codigo = C.cliente_codigo
				WHERE 
					UPPER(producto.producto_nombre) 
						LIKE UPPER('%$nombre%')
					AND
					UPPER(M.marca_nombre) 
						LIKE UPPER('%$marca%') 
					AND
					UPPER(P.presentacion_nombre) 
						LIKE UPPER('%$presentacion%')";

    	$response = self::executeSqlConverterToArray($sql);
		return self::printResponseInJsonEncode($response);
    			
    }

    public static function getForMarcaAndPresentacionAndCliente($nombre,$marca,$presentacion,$cliente)
    {
    	$sql = "SELECT * FROM producto
				JOIN marca M
    				ON producto.marca_codigo = M.marca_codigo
    			JOIN presentacion P
    				ON producto.presentacion_codigo = P.presentacion_codigo
    			JOIN cliente C
    				ON producto.cliente_codigo = C.cliente_codigo
				WHERE
					UPPER(producto.producto_nombre) LIKE UPPER('%$nombre%')
					AND
					UPPER(M.marca_nombre) LIKE UPPER('%$marca%') 
					AND 
					UPPER(P.presentacion_nombre) LIKE UPPER('%$presentacion%')
					AND
					UPPER(C.cliente_nombre) LIKE UPPER('%$cliente%')";
					
		$response = self::executeSqlConverterToArray($sql);
		return self::printResponseInJsonEncode($response);
    }
	
	public static function getAll(){
		$sql = "SELECT * FROM producto 
				JOIN marca M 
    				ON producto.marca_codigo = M.marca_codigo
    			JOIN presentacion P
    				ON producto.presentacion_codigo = P.presentacion_codigo
    			JOIN cliente C
    				ON producto.cliente_codigo = C.cliente_codigo";
		$response = self::executeSqlConverterToArray($sql);
		return self::printResponseInJsonEncode($response); 
	}

	public static function findByCategoria($categoria){
		return self::getBy('categoria',$categoria);	
	}

	public static function getBy($row,$data){
		$sql = "SELECT * FROM producto
				JOIN tipo T
					ON producto.tipo_codigo = T.tipo_codigo
				JOIN marca M 
    				ON producto.marca_codigo = M.marca_codigo
    			JOIN presentacion P
    				ON producto.presentacion_codigo = P.presentacion_codigo
    			JOIN cliente C
    				ON producto.cliente_codigo = C.cliente_codigo
				WHERE UPPER($row) LIKE UPPER('%$data%') ORDER BY $row";
		$response = self::executeSqlConverterToArray($sql);
		return self::printResponseInJsonEncode($response);
	}

}

?>
