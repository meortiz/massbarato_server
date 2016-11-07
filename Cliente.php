<?php

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

require 'Producto.php';
/**
* 
*/
class Cliente {
     
	function __construct()
    {
    }

	public static function getAll(){
		$sql = "SELECT * FROM cliente
				JOIN ciudad C
    				ON cliente.ciudad_codigo = C.ciudad_codigo
    			JOIN departamento D
    				ON C.departamento_codigo = D.departamento_codigo";
		$response = self::executeSqlConverterToArray($sql);
		return self::printResponseInJsonEncode($response); 
	}

	public static function hacerMercadoCompleto($cliente,$productos)
	{
		$suma = 0;
		$canasta = self::llenarCanasta($cliente,$productos);
		//echo "\n".$cliente." ****** \n ".var_dump($productos);

		$productosEnLaCanasta = sizeof($canasta);
		$productosEnLaLista = sizeof($productos);
		if ($productosEnLaCanasta < $productosEnLaLista) {
			$response = null;
		}else{
			$suma = self::calcularCanasta($canasta);
			$response = array('suma' => $suma,'canasta' => $canasta);
		}
		return self::printResponseInJsonEncode($response); 
	}

	public static function buscarMercadoCompleto($productos)
	{
		$clientes = json_decode(self::getAll());
		$mercados = array();
		foreach ($clientes as $key => $cliente) {
			$iteraciones++;
			$mercado = json_decode(self::hacerMercadoCompleto(
				$cliente->cliente_nombre,
				$productos));
			if ($mercado != null) {
				//echo var_dump($mercado);
				$mercados[]=$mercado;
			}
		}
		return self::printResponseInJsonEncode($mercados); 
	}

	

	private static function llenarCanasta($cliente,$productos)
	{
		$canasta = array();
		foreach ($productos as $key => $producto) {
			$producto = self::buscarProducto($cliente,$producto);
			if ($producto) {
				array_push($canasta,$producto);
			}
		}
		return $canasta;
	}

	private static function calcularCanasta($canasta){
		$suma = 0;
		if ($canasta) {
			foreach ($canasta as $key => $producto) {
				$suma += intval($producto->producto_valor);
			}
		}
		return $suma;
	}

	private static function buscarProducto($cliente,$producto)
	{
		$productos = json_decode(Producto::getForMarcaAndPresentacionAndCliente(
				$producto['nombre'],
				$producto['marca'],
				$producto['presentacion'],
				$cliente
			));
		return $productos[0];
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
		if ($response != null) {
			return json_encode($response);
		}else{
			self::nullResponse();
		}
	}

	private static function nullResponse(){
		return json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'No se obtuvo el registro'
                )
            );
	}
}

?>
