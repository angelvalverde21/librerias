<?php
function porcentaje_descuento($precio_lista,$precio_promocion){
	$descuento = $precio_lista-$precio_promocion;
	$porcentaje = round(($descuento*100)/$precio_lista)."%";
	return $porcentaje;
}

function aureo(){
	return 1.618033988749895;
}


	function title_short($parametro){
		$titulo = explode('-',$parametro);

		if(count($titulo)>1){
			return $titulo[0];	
		}else{
			return substr($titulo[0], 0,50)."...";		
		}
		
	}

function precio_multimedia_new($paramtro){
	$db = new mysql();

	$result = $db->consulta("SELECT * FROM ayv_productos WHERE IDPRODUCTO='".IdProductoFromIdMultimedia($parametro)."' LIMIT 1");
	$row = $db->recuperar_array($result);
	return $row['PRECIO'];
}

function formato_moneda($numero){

	//1716.949152542373
	//primero vemos si el numero tiene decimal
	// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
	// porque la posición de 'a' está en el 1° (primer) caracter.

	$pos = strpos($numero,'.');

	if($numero<>0){

		if ($pos === false) {
			//La cadena '.' no fue encontrada en la cadena '$numero';
			//entonces no existe decimal
			return "S/. ".$numero.',00';

		} else {
			$tamanocadena	=	strlen($numero);
			//La cadena '.' fue encontrada en la cadena '$numero';
			//entonces el numero tiene decimal
			//32121.651651
			//255.15
			$numerodecimales=$tamanocadena-$pos-1;

			if($numerodecimales==1){

				$nuevacadena=str_replace('.',',',$numero);
					
				return "S/. ".$nuevacadena.'0';
			}else{
				if($numerodecimales==2){
					$nuevacadena=str_replace('.',',',$numero);
					return "S/. ".$nuevacadena;
				}else{
					if($numerodecimales>2){
						return "S/. ".substr($numero,0,$post + 3);
					}
				}
			}
		}

	}else{
		$numero="S/. 0,00";
		return $numero;
	}
}

//funcion que busca elemenos repetidos en un array

function elementosrepetidos($array, $returnWithNonRepeatedItems = false){
	$repeated = array();

	foreach( (array)$array as $value ){
		$inArray = false;

		foreach( $repeated as $i => $rItem ){
			if( $rItem['value'] === $value ){
				$inArray = true;
				++$repeated[$i]['count'];
			}
		}

		if( false === $inArray ){
			$i = count($repeated);
			$repeated[$i] = array();
			$repeated[$i]['value'] = $value;
			$repeated[$i]['count'] = 1;
		}
	}

	if(!$returnWithNonRepeatedItems){
		foreach( $repeated as $i => $rItem ){
			if($rItem['count'] === 1){
				unset($repeated[$i]);
			}
		}
	}

	sort($repeated);

	return $repeated;
}

function contar_elementos_repetidos($array, $returnWithNonRepeatedItems = false){
	$repeated = array();

	foreach($array as $value ){
		$inArray = false;

		foreach( $repeated as $i => $rItem ){
			if( $rItem['value'] === $value ){
				$inArray = true;
				++$repeated[$i]['count'];
			}
		}

		if( false === $inArray ){
			$i = count($repeated);
			$repeated[$i] = array();
			$repeated[$i]['value'] = $value;
			$repeated[$i]['count'] = 1;
		}
	}

	if(!$returnWithNonRepeatedItems){
		foreach( $repeated as $i => $rItem ){
			if($rItem['count'] === 1){
				unset($repeated[$i]);
			}
		}
	}

	ksort($repeated);

	return $repeated;
}

function dias_transcurridos($fecha_i,$fecha_f){
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);
	return $dias;
}


function dispositivo(){
	$tablet_browser = 0;
	$mobile_browser = 0;
	$body_class = 'desktop';

	if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		$tablet_browser++;
		$body_class = "tablet";
	}

	if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		$mobile_browser++;
		$body_class = "mobile";
	}

	if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
		$mobile_browser++;
		$body_class = "mobile";
	}

	$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
	$mobile_agents = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','winw','xda ','xda-');

	if (in_array($mobile_ua,$mobile_agents)) {
		$mobile_browser++;
	}

	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
		$mobile_browser++;
		//Check for tablets on opera mini alternative headers
		$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
			$tablet_browser++;
		}
	}
	if ($tablet_browser > 0) {
		// Si es tablet has lo que necesites
		return 'TABLET';
	}
	else if ($mobile_browser > 0) {
		// Si es dispositivo mobil has lo que necesites
		return 'MOVIL';
	}
	else {
		// Si es ordenador de escritorio has lo que necesites
		return 'PC';
	}
}

function getIP(){
	if( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] )) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if( isset( $_SERVER ['HTTP_VIA'] ))  $ip = $_SERVER['HTTP_VIA'];
	else if( isset( $_SERVER ['REMOTE_ADDR'] ))  $ip = $_SERVER['REMOTE_ADDR'];
	else $ip = null ;
	return $ip;
}


function get_promocion($key=0,$mostrar=false){

	$db = new mysql();

	$link = conectarse();

	$result = $db->consulta("SELECT * FROM ".PREFIX."promociones WHERE IDPRODUCTO='".$_GET["IDPRODUCTO"]."'");


	if($mostrar){
		return $row[$key];
	}else{
		echo"<option value='0'>ESCOGER</option>";
		while($row = $db->recuperar_array($result)){
			if($key==$row["IDPROMOCION"]){
				echo "<option selected value='".$row["IDPROMOCION"]."'>".$row['NOMBRE_PROMOCION']."</option>\n";
				$selected="";
			}else{
				echo "<option value='".$row["IDPROMOCION"]."'>".$row['NOMBRE_PROMOCION']."</option>\n";
			}
		}
	}

}



function categorias_seleccionadas($ID){

	$db = new mysql();

	$result=$db->consulta("select * from ".PREFIX."productos_relaciones where IDPRODUCTO='".$ID."'");

	$total=$db->contar_consulta($result);

	if($total>0){
		/*Recorrer todos las entradas */

		while($row=$db->recuperar_array($result)){
			/* Imprimir campo a mostrar*/

			$array_categorias[]=$row['IDCATEGORIA'];

		}
	}

	return $array_categorias;
}

function categorias_almacen_form($parent='0',$prefix='&nbsp;&nbsp;',$seleccion='0'){

	$db = new mysql();

	$result=$db->consulta("select * from ".PREFIX."productos_categorias where PARENT=".$parent." ORDER BY POSICION ASC");
	$total=$db->contar_consulta($result);
	if($total>0){
		/*Recorrer todos las entradas */

		while($arr=$db->recuperar_array($result)){
			/* Imprimir campo a mostrar*/
			for($i=0;$i<count($seleccion);$i++){
				if($arr['IDCATEGORIA']==$seleccion[$i]){
					$cheked=true;
					break;
				}else{
					$cheked=false;
				}
			}
			if($cheked){
				echo "<li class='select_categorias'>$prefix<input  type='checkbox' name='CATEGORIA[]' value='".$arr['IDCATEGORIA']."' checked>&nbsp;".$arr['LABEL']."</li>";
			}else{
				echo "<li class='select_categorias'>$prefix<input type='checkbox' name='CATEGORIA[]' value='".$arr['IDCATEGORIA']."'>&nbsp;".$arr['LABEL']."</li>";
			}

			/* imprimir arbol the "hijos" de este elemento*/
			categorias_almacen_form($arr['IDCATEGORIA'],$prefix.$prefix,$seleccion);
				
		}
	}
}

function completar_ceros($cadena,$largo_cadena=6){


	$total_caracteres_original = strlen($cadena);

	if($total_caracteres_original>$largo_cadena){
			
	}else{
		//completar con ceros
		$hasta = $largo_cadena - $total_caracteres_original;

		for($i=0;$i<$hasta;$i++){
			$cadena = "0".$cadena;
		}

	}

	return $cadena;
}


function quitar_ceros($cadena){

	$total_caracteres = strlen($cadena);

	for($i=0;$i<$total_caracteres;$i++){
		if(substr($cadena,$i,1)=="0"){
				
		}else{
			break;
		}
	}

	return substr($cadena,$i,$total_caracteres);

}

function stock_almacen($codigo){
	$db = new mysql();
	$link = conectarse();
	$result = $db->consulta("select * from ".PREFIX."stock WHERE IDMULTIMEDIA='".$codigo."' AND ESTADO='1'");
	return $db->contar_consulta($result);
}

function stock_total($idproducto){

	$db = new mysql();
	$result = $db->consulta("select * from ".PREFIX."stock WHERE IDPRODUCTO='".$idproducto."' AND ESTADO='1'");
	return $db->contar_consulta($result);
}

function modelos($idproducto){

	$db = new mysql();
	$result = $db->consulta("select * from ".PREFIX."multimedia WHERE IDPRODUCTO='".$idproducto."' AND TIPO='productos' LIMIT 100");

	return $db->contar_consulta($result);	
}


function select_mostrar($key=0,$mostrar=false){

	$ESTADO = mostrar_galeria();

	if($mostrar){
		return $ESTADO[$key];
	}else{
		echo"<option value='0'>ESCOGER</option>";
		for($i=1;$i<=count($ESTADO);$i++){
			if($key==$i){
				echo "<option selected value='".$i."'>".$ESTADO[$i]."</option>\n";
				$selected="";
			}else{
				echo "<option value='".$i."'>".$ESTADO[$i]."</option>\n";
			}
		}
	}

}


function total_resumen($envio){
	
	session_start();
	$subtotal		=	$_SESSION['carrito_total'];
	$descuentos		=	$_SESSION['carrito_descuento'];	
	
	if($envio=="" OR $envio==0){
		$array_envio = array('COSTO ENVIO :'=>'GRATIS');
	}else{		
		$array_envio = array('COSTO ENVIO :'=>formato_moneda($envio));
	}


	if($descuentos > 0){
		$array_descuentos = array('DESCUENTOS :'=>'- '.formato_moneda($descuentos));
	}else{
		$array_descuentos = array('CERO'=>formato_moneda(0));
	}


	$array_sub_total = array('SUB TOTAL :'=>formato_moneda($subtotal));

	$array_total = array('TOTAL A PAGAR:'=>formato_moneda($subtotal-$descuentos+$envio));

	$pagos = array_merge($array_sub_total,$array_descuentos,$array_envio,$array_total);

	return $pagos;

}


function calculos_car($envio){

	session_start();
	
	$paquetes = new carrito();
	
	$_SESSION['carrito_envio']		=	$envio;
	$_SESSION['carrito_total']		=	$_SESSION['carrito_total'];
	$_SESSION['carrito_descuento']	=	$paquetes->descuento_total();
	
	session_start();
	
	$pagos = total_resumen($envio);
	
	unset($pagos['CERO']);
	
	//$pagos = json_encode($pagos);
		
	$campos = array_keys($pagos);

	$html = "<table class='table'>";
	for($i=0;$i<count($campos);$i++){

		$html .=  "<tr><td id='' class=''>".$campos[$i]."</td><td> ".$pagos[$campos[$i]]."</td></tr>";
	}
	$html .= "<table>";
		
	//$pagos;

	$carrito['html']				=	$html;
	$carrito['carrito_total']		=	$_SESSION['carrito_total'];
	$carrito['carrito_envio']		=	$envio;
	$carrito['carrito_descuento']	=	$_SESSION['carrito_descuento'];
		
	$array = json_encode($carrito);

	return $array;
	
}

function fechasql(){
	date_default_timezone_set('America/Lima');
	return date('Y-m-d H:i:s');
}


function quitar_ultimo_caracter($cad){
	$tamano = strlen($cad);
	$tamano_cortado = $tamano - 1;
	$cortado = substr($cad,0,$tamano_cortado);
	return $cortado;
}

function redondear_dos_decimal($valor) {
	$float_redondeado=round($valor * 100) / 100;
	return $float_redondeado;
}

function restringir_caracteres($cad,$caracteres_maximo_permitidos=3){
	$tamano = strlen($cad);
	if($tamano>$caracteres_maximo_permitidos){
		$cad = substr($cad,0,3).".";
	}
	return $cad;
}

function obtener_url($url) {
	// Tranformamos todo a minusculas
	$url = strtolower($url);
	//Rememplazamos caracteres especiales latinos
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
	$repl = array('a', 'e', 'i', 'o', 'u', 'n');
	$url = str_replace ($find, $repl, $url);
	// Añaadimos los guiones
	$find = array(' ', '&', '\r\n', '\n', '+');
	$url = str_replace ($find, '-', $url);
	// Eliminamos y Reemplazamos demás caracteres especiales
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);
	return $url;
}

 
function existe_imagen($url)
{
    if(getimagesize($url)){
    	return $url;
    }else{
    	return URL_UPLOADS."/imagen-no-disponible.jpg";
 }
}

function obtener_extencion($nombre_archivo){
	$archivo = $nombre_archivo;
	$extension = end( explode('.', $archivo) );
	return $extension;
}

function venta_total($IDVENTA){
	$db = new mysql();

	$resultado = $db->query("SELECT * FROM ".PREFIX."ventas_detalles WHERE IDVENTA='".$IDVENTA."' LIMIT 100");

	while($row = $db->recuperar_array($resultado)){
		$total += $row['PRECIO_PROMO'];	
	}

	return $total;

}

?>
