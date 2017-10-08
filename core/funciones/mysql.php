<?php

function insertar($config){

	$db = new mysql();

	global $AYV;
	$link = conectarse();

	$tabla = $config['TABLA'];
	$fecha = $config['FECHA'];
	
	/************ Definicion de campos extras (Opcional) *****************/
	
	$campos_extras = $config['CAMPOS_EXTRAS'];
	
	$keys_extras = array_keys($campos_extras);
	
	for($i=0;$i<count($campos_extras);$i++){

		$cadena_campos .= $keys_extras[$i].",";
		$cadena_valores .= "'".$campos_extras[$keys_extras[$i]]."',";
		
	}
	
	/********** Fin de Definicion de campos extras (Opcional) ************/
	
	
	$array = $_POST[$tabla];
	$keys = array_keys($array);
	$total_campos = count($array);
	for($i=0;$i<$total_campos;$i++){
	
		//campos
							
		//echo "-".$keys_campos[$j]."<br>";
							
		if($total_campos -1 == $i){
			$cadena_campos .= mysql_real_escape_string($keys[$i])."";
		}else{
			$cadena_campos .= mysql_real_escape_string($keys[$i]).",";
		}
							
		if($total_campos -1 == $i){
			$cadena_valores .= "'".mysql_real_escape_string($array[$keys[$i]])."'";
		}else{
			$cadena_valores .= "'".mysql_real_escape_string($array[$keys[$i]])."',";
		}						
	}	
	
	if($fecha){
		$cadena_campos .= ",FECHA";
		$cadena_valores .= ",'".fechasql()."'";
	}

	//echo $cadena_campos;
	
	$cadena_sql = "insert into ".PREFIX.$tabla." (".$cadena_campos.") values (".$cadena_valores.")";
	
	//echo $cadena_sql."<br>";
	
	$result = $db->consulta($cadena_sql);				
	if (!$result){
		//ECHO $cadena_sql,$link;
		die(mysql_error());
	}
	
	return mysql_insert_id();
}

function procesar_y_registrar_usuario(){
	
	session_start();

	$test = false;

	if($test){
		test_array($_POST);
	}else{
		//inserto usuario

		$config = array('TABLA'=>'usuarios','FECHA'=>true);
		$IDUSUARIO = insertar($config);


		//inserto direccon de envio

		$config = array('TABLA'=>'direcciones_envio','FECHA'=>true,'CAMPOS_EXTRAS'=>array('IDUSUARIO'=>$IDUSUARIO));

		$IDENVIO = insertar($config);

		$config = array('TABLA'=>'direcciones_facturacion','FECHA'=>true,'CAMPOS_EXTRAS'=>array('IDUSUARIO'=>$IDUSUARIO));

		$IDFACTU = insertar($config);
		//inserto venta

		$config = array('TABLA'=>'ventas','FECHA'=>true,'CAMPOS_EXTRAS'=>array('IDENVIO'=>$IDENVIO,'IDFACTURACION'=>$IDFACTU,'IDUSUARIO'=>$IDUSUARIO,'COSTO_ENVIO'=>$_SESSION['carrito_envio']));

		$IDVENTA = insertar($config);

		//inserto detalles de venta

		insertar_detalles_pedido_session_simple($IDVENTA);

		return $IDVENTA;
		//redireccion a pagina de pedidos generales www.aquarella.com.pe/pedidos?IDPEDIDO=XXXX
	}
}


function actualizar($config){

	$db = new mysql();
	$tabla = $config['TABLA'];
	
	/**** Esta linea se agrego porque el sistema no esta preparado para agregar arrays de uploads *****/
	/*if($_FILES["FILE_UPLOAD"]['name']<>""){
		$archivo_upload=upload_banner('FILE_UPLOAD');
		$cad_sql_upload = ",FILE_UPLOAD='".$archivo_upload."' ";
	}else{
		$cad_sql_upload = " ";
	}*/
	/**** Esta linea se agrego porque el sistema no esta preparado para agregar arrays de uploads *****/

	$campos_files = array_keys($_FILES['UPLOAD_FILE']['name'][$tabla]);

	//test_array($campos_files);

//echo $campos_files[0];

	if(count($campos_files)>0){
		for($i=0;$i<count($campos_files);$i++){
			if($_FILES["UPLOAD_FILE"]['name'][$tabla][$campos_files[$i]]<>""){
				$archivo_upload=  upload_files_array($campos_files[$i],$tabla);
				$cad_sql_upload .= ",".$campos_files[$i]."='".$archivo_upload."' ";
			}else{
				$cad_sql_upload .= " ";
			}	
		}	
	}

	//echo $cad_sql_upload;

	global $AYV;		
	$link = conectarse();		
	$campos = $_POST[$tabla];
	$keys = array_keys($campos);
	
	$total = count($campos);
	for($j=0;$j<count($campos);$j++){
		//echo $campos[$keys[$j]];
		if($total -1 == $j){
			$cadena_valores .= $keys[$j]."="."'".$campos[$keys[$j]]."'";
		}else{
			$cadena_valores .= $keys[$j]."="."'".$campos[$keys[$j]]."', ";
		}						
	}
		
	$cadena_valores = $cadena_valores.$cad_sql_upload;

	//echo $cad_sql_upload."----UPDATE ".PREFIX.$tabla." SET ".$cadena_valores." WHERE ".$_POST['KEYPADRE']."='".$_POST['KEY']."'";	
	
	//echo "UPDATE ".PREFIX.$tabla." SET ".$cadena_valores." WHERE ".$_POST['KEYPADRE']."='".$_POST['KEY']."'";

	$result=$db->query("UPDATE ".PREFIX.$tabla." SET ".$cadena_valores." WHERE ".$_POST['KEYPADRE']."='".$_POST['KEY']."'");	
		
	if (!$result){
		die(mysql_error());
	}

}



function insertar_tabla($IDVENTA){

	$db = new mysql();	

	$link = conectarse();		
	global $AYV;
	//test_array($_POST['tabla']);

	$tablas_form = $_POST['tabla'];
	$keys_campos = array_keys($_POST['tabla']['ventas_detalles']);
	$total_campos = count($_POST['tabla']['ventas_detalles']);
	for($j=0;$j<count($_POST['tabla']['ventas_detalles']['IDPRODUCTO']);$j++){
		if($_POST['tabla']['ventas_detalles']['IDPRODUCTO'][$j]<>""){
			for($i=0;$i<count($_POST['tabla']['ventas_detalles']);$i++){		
				if($total_campos -1 == $i){
					$cadena_campos .= $keys_campos[$i]."";
					$cadena_valores .= "'".$tablas_form['ventas_detalles'][$keys_campos[$i]][$j]."'";
				}else{
					$cadena_campos .= $keys_campos[$i].",";
					$cadena_valores .= "'".$tablas_form['ventas_detalles'][$keys_campos[$i]][$j]."',";
				}	
			}

			$result=$db->consulta("insert into ".PREFIX."ventas_detalles (IDVENTA,".$cadena_campos.") values ('".$IDVENTA."',".$cadena_valores.")");
			
			//echo "insert into ".PREFIX."ventas_detalles (IDVENTA,".$cadena_campos.") values ('".$IDVENTA."',".$cadena_valores.")"."<br />";
			
			if (!$result){
				die(mysql_error());
			}
		
		}
		
		//echo $cadena_campos." --- ".$cadena_valores."<br>";
		
		$cadena_campos = "";
		$cadena_valores = "";
	
	}
}

function insertar_detalles_pedido($IDVENTA){

	$db = new mysql();

	$link = conectarse();		

	$IDMULTIMEDIA 	= $_POST["IDMULTIMEDIA"];
	$CANTIDAD 		= $_POST["CANTIDAD"];
	$TALLA 			= $_POST["TALLA"];
	$PRECIO_PROMO 	= $_POST["PRECIO_PROMO"];
		
	//itermoas la cantidad de productos diferentes pedidos 
	for($i=0;$i<count($IDMULTIMEDIA);$i++){

		$IDSTOCK_ARRAY ="";

			//query para la tabla multimedia
			$query_multimedia = "SELECT * FROM ".PREFIX."multimedia WHERE IDMULTIMEDIA='".$IDMULTIMEDIA[$i]."' LIMIT 1";
			$result_multimedia=$db->consulta($query_multimedia);
			$row_multimedia = $db->recuperar_array($result_multimedia);

			//query para la tabla productos
			$query_productos = "SELECT * FROM ".PREFIX."productos WHERE IDPRODUCTO='".$row_multimedia['IDPRODUCTO']."' LIMIT 1";
			$result_productos=$db->consulta($query_productos);
			$row_productos = $db->recuperar_array($result_productos);


		if(($ARRAY_STOCK=comprobar_stock($IDMULTIMEDIA[$i],$TALLA[$i],$CANTIDAD[$i])) OR ($row_productos['OVERSALE']==1)){

			for($j=0;$j<count($ARRAY_STOCK);$j++){
				//antes de insertar el pedido reservo el stock para este
				reservar_producto($ARRAY_STOCK[$j]);
				//agrupo el stock para ser enviado a la base de datos
				$IDSTOCK_ARRAY .= $ARRAY_STOCK[$j].",";
			}

			//echo $query_multimedia."<br><br>";

			$IDSTOCK_ARRAY = quitar_ultimo_caracter($IDSTOCK_ARRAY);

			$TOTAL = redondear_dos_decimal($row_productos['PRECIO']*$CANTIDAD[$i]);

			$query = "
					INSERT INTO ".PREFIX."ventas_detalles 
						(CANTIDAD,DESCRIPCION,PRECIO,PRECIO_PROMO,IDVENTA,IDPRODUCTO,IDMULTIMEDIA,TALLA,TOTAL,IDSTOCK) 
					values 
						('".$CANTIDAD[$i]."','".$row_multimedia['LABEL']."','".$row_productos['PRECIO']."','".$PRECIO_PROMO[$i]."','".$IDVENTA."','".$row_multimedia['IDPRODUCTO']."','".$IDMULTIMEDIA[$i]."','".$TALLA[$i]."','".$TOTAL."','".$IDSTOCK_ARRAY."')
					";

			//echo $query."<br>";
			$result=$db->consulta($query);

		}
	}

}

function insertar_detalles_pedido_session_simple($IDVENTA){

	$db = new mysql();

	$link = conectarse();		

	$IDMULTIMEDIA 	= $_SESSION["IDMULTIMEDIA"];
	$CANTIDAD 		= $_SESSION["CANTIDAD"];
	$TALLA 			= $_SESSION["TALLA"];
	$PRECIO_PROMO 	= $_SESSION["PRECIO_PROMO"];
		
	//itermoas la cantidad de productos diferentes pedidos 
	for($i=0;$i<count($IDMULTIMEDIA);$i++){

		$IDSTOCK_ARRAY ="";

			//query para la tabla multimedia
			$query_multimedia = "SELECT * FROM ".PREFIX."multimedia WHERE IDMULTIMEDIA='".$IDMULTIMEDIA[$i]."' LIMIT 1";
			$result_multimedia=$db->consulta($query_multimedia);
			$row_multimedia = $db->recuperar_array($result_multimedia);

			//query para la tabla productos
			$query_productos = "SELECT * FROM ".PREFIX."productos WHERE IDPRODUCTO='".$row_multimedia['IDPRODUCTO']."' LIMIT 1";
			$result_productos=$db->consulta($query_productos);
			$row_productos = $db->recuperar_array($result_productos);


		
			for($j=0;$j<count($ARRAY_STOCK);$j++){

				//antes de insertar el pedido reservo el stock para este
				reservar_producto($ARRAY_STOCK[$j]);
				//agrupo el stock para ser enviado a la base de datos
				$IDSTOCK_ARRAY .= $ARRAY_STOCK[$j].",";
			}

			//echo $query_multimedia."<br><br>";

			$IDSTOCK_ARRAY = quitar_ultimo_caracter($IDSTOCK_ARRAY);

			$TOTAL = redondear_dos_decimal($row_productos['PRECIO']*$CANTIDAD[$i]);

			$query = "
					INSERT INTO ".PREFIX."ventas_detalles 
						(CANTIDAD,DESCRIPCION,PRECIO,PRECIO_PROMO,IDVENTA,IDPRODUCTO,IDMULTIMEDIA,TALLA,TOTAL,IDSTOCK) 
					values 
						('".$CANTIDAD[$i]."','".$row_multimedia['LABEL']."','".$row_productos['PRECIO']."','".$PRECIO_PROMO[$i]."','".$IDVENTA."','".$row_multimedia['IDPRODUCTO']."','".$IDMULTIMEDIA[$i]."','".$TALLA[$IDMULTIMEDIA[$i]]."','".$TOTAL."','".$IDSTOCK_ARRAY."')
					";

			//echo $query."<br>";
			$result=$db->consulta($query);

		
	}

}

function insertar_detalles_pedido_session($IDVENTA){

	$db = new mysql();

	$link = conectarse();
	
	for($k=0;$k<count($_SESSION['GRUPOS_MULTIMEDIA']);$k++){
		
		$KEYGRUPO = $_SESSION['GRUPOS_MULTIMEDIA'][$k];

		$IDMULTIMEDIA = $_SESSION['SELECCIONADOS'][$KEYGRUPO];
		$CANTIDAD = $_SESSION["CANTIDAD"][$KEYGRUPO];
		$TALLA = $_SESSION["TALLAS"][$KEYGRUPO];
		$PRECIO_PROMO = $_SESSION["PRECIO_PROMO"][$KEYGRUPO];
		$PRECIO_NORMAL = $_SESSION["PRECIO_NORMAL"][$KEYGRUPO];

	
		//itermoas la cantidad de productos diferentes pedidos
		for($i=0;$i<count($IDMULTIMEDIA);$i++){
	
			$IDSTOCK_ARRAY ="";
	
			//query para la tabla multimedia
			$query_multimedia = "SELECT * FROM ".PREFIX."multimedia WHERE IDMULTIMEDIA='".$IDMULTIMEDIA[$i]."' LIMIT 1";
			$result_multimedia=$db->consulta($query_multimedia);
			$row_multimedia = $db->recuperar_array($result_multimedia);
	
			//query para la tabla productos
			$query_productos = "SELECT * FROM ".PREFIX."productos WHERE IDPRODUCTO='".$row_multimedia['IDPRODUCTO']."' LIMIT 1";
			$result_productos=$db->consulta($query_productos);
			$row_productos = $db->recuperar_array($result_productos);
	
	
			if(($ARRAY_STOCK=comprobar_stock($IDMULTIMEDIA[$i],$TALLA[$i],$CANTIDAD[$i])) OR ($row_productos['OVERSALE']==1)){
				for($j=0;$j<count($ARRAY_STOCK);$j++){
	
					//antes de insertar el pedido reservo el stock para este
					reservar_producto($ARRAY_STOCK[$j]);
					//agrupo el stock para ser enviado a la base de datos
					$IDSTOCK_ARRAY .= $ARRAY_STOCK[$j].",";
				}
	
				//echo $query_multimedia."<br><br>";
	
				$IDSTOCK_ARRAY = quitar_ultimo_caracter($IDSTOCK_ARRAY);
	
				$TOTAL = redondear_dos_decimal($row_productos['PRECIO']*$CANTIDAD[$i]);
	
				$query = "
						INSERT INTO ".PREFIX."ventas_detalles
							(CANTIDAD,DESCRIPCION,PRECIO,PRECIO_PROMO,IDVENTA,IDPRODUCTO,IDMULTIMEDIA,TALLA,TOTAL,IDSTOCK)
						values
							('".$CANTIDAD[$i]."','".$row_multimedia['LABEL']."','".$PRECIO_NORMAL[$i]."','".$PRECIO_PROMO[$i]."','".$IDVENTA."','".$row_multimedia['IDPRODUCTO']."','".$IDMULTIMEDIA[$i]."','".$TALLA[$i]."','".$CANTIDAD[$i]*$PRECIO_PROMO[$i]."','".$IDSTOCK_ARRAY."')
						";
	
				//echo $query."<br>";
				$result=$db->consulta($query);
	
			}
		}
	
	}

}

function insertar_detalles_campana($IDCAMPANA){

	$db = new mysql();

	$link = conectarse();		

	$IDMULTIMEDIA = $_POST["IDMULTIMEDIA"];
	$CANTIDAD = $_POST["CANTIDAD"];
	$TALLA = $_POST["TALLA"];
	$PRECIO_PROMO = $_POST["PRECIO_PROMO"];
	
	//itermoas la cantidad de productos diferentes pedidos 
	
	for($i=0;$i<count($IDMULTIMEDIA);$i++){
	
		if($IDMULTIMEDIA[$i]>0){
			
			//query para la tabla multimedia
			$query_multimedia = "SELECT * FROM ".PREFIX."multimedia WHERE IDMULTIMEDIA='".$IDMULTIMEDIA[$i]."' LIMIT 1";
			$result_multimedia=$db->consulta($query_multimedia);
			$row_multimedia = $db->recuperar_array($result_multimedia);

			//query para la tabla productos
			$query_productos = "SELECT * FROM ".PREFIX."productos WHERE IDPRODUCTO='".$row_multimedia['IDPRODUCTO']."' LIMIT 1";
			$result_productos=$db->consulta($query_productos);
			$row_productos = $db->recuperar_array($result_productos);

			$TOTAL = redondear_dos_decimal($row_productos['PRECIO']*$CANTIDAD[$i]);

			$query = "
					INSERT INTO ".PREFIX."campanas_detalles
						(CANTIDAD,DESCRIPCION,PRECIO,PRECIO_PROMO,IDCAMPANA,IDPRODUCTO,IDMULTIMEDIA,TALLA,TOTAL) 
					values 
						('".$CANTIDAD[$i]."','".$row_multimedia['LABEL']."','".$row_productos['PRECIO']."','".$PRECIO_PROMO[$i]."','".$IDCAMPANA."','".$row_multimedia['IDPRODUCTO']."','".$IDMULTIMEDIA[$i]."','".$TALLA[$i]."','".$TOTAL."')
					";
			//echo $query."<br>";
			$result=$db->consulta($query);
			//die(mysql_error());
			
		}
		
	}

}

function insertar_detalles_promo($IDPROMO){

	$db = new mysql();

	$link = conectarse();		

	$IDMULTIMEDIA = $_POST["IDMULTIMEDIA"];
	$CANTIDAD = $_POST["CANTIDAD"];
	$TALLA = $_POST["TALLA"];
	$PRECIO_PROMO = $_POST["PRECIO_PROMO"];
		
	//itermoas la cantidad de productos diferentes pedidos 
	
	for($i=0;$i<count($IDMULTIMEDIA);$i++){
		
	
		
		if($IDMULTIMEDIA[$i]>0){
			
			//query para la tabla multimedia
			$query_multimedia = "SELECT * FROM ".PREFIX."multimedia WHERE IDMULTIMEDIA='".$IDMULTIMEDIA[$i]."' LIMIT 1";
			$result_multimedia=$db->consulta($query_multimedia);
			$row_multimedia = $db->recuperar_array($result_multimedia);

			//query para la tabla productos
			$query_productos = "SELECT * FROM ".PREFIX."productos WHERE IDPRODUCTO='".$row_multimedia['IDPRODUCTO']."' LIMIT 1";
			$result_productos=$db->consulta($query_productos);
			$row_productos = $db->recuperar_array($result_productos);

			$TOTAL = redondear_dos_decimal($row_productos['PRECIO']*$CANTIDAD[$i]);

			$query = "
					INSERT INTO ".PREFIX."promociones_detalles
						(CANTIDAD,DESCRIPCION,PRECIO,PRECIO_PROMO,IDPROMOCION,IDPRODUCTO,IDMULTIMEDIA,TALLA,TOTAL) 
					values 
						('".$CANTIDAD[$i]."','".$row_multimedia['LABEL']."','".$row_productos['PRECIO']."','".$PRECIO_PROMO[$i]."','".$IDPROMO."','".$row_multimedia['IDPRODUCTO']."','".$IDMULTIMEDIA[$i]."','".$TALLA[$i]."','".$TOTAL."')
					";
			//echo $query."<br>";
			$result=$db->consulta($query);
			//die(mysql_error());
			
		}
		
	}

}

function insertar_ciudades_promo($IDPROMO){

	$db = new mysql();

	$link = conectarse();		

	$IDDEPARTAMENTO = $_POST["IDDEPARTAMENTO"];
	$IDPROVINCIA = $_POST["IDPROVINCIA"];
	$IDDISTRITO = $_POST["IDDISTRITO"];
	
		
	//itermoas la cantidad de productos diferentes pedidos 
	
	for($i=0;$i<count($_POST["IDDEPARTAMENTO"]);$i++){
		
			$query = "
					INSERT INTO ".PREFIX."promociones_ciudades
						(IDPROMOCION,IDDEPARTAMENTO,IDPROVINCIA,IDDISTRITO) 
					values 
						('".$IDPROMO."','".$IDDEPARTAMENTO[$i]."','".$IDPROVINCIA[$i]."','".$IDDISTRITO[$i]."')
					";
			//echo $query."<br>";
			$result=$db->consulta($query);
			//die(mysql_error());

	}
}

function insertar_pedido($IDVENTA){

	$db = new mysql();
	
	$link = conectarse();		
	global $AYV;
	//test_array($_POST['tabla']);

	if($_POST["elementos_comprar"]){
	
		$elementos = $_POST["elementos_comprar"];
		
		for($i=0;$i<count($elementos);$i++){

			$cad = "SELECT * FROM ayv_stock
					INNER JOIN ayv_productos
						ON ayv_stock.IDPRODUCTO = ayv_productos.IDPRODUCTO
					WHERE ayv_stock.IDSTOCK = '".$elementos[$i]." LIMIT 1'	
				";
			$result = $db->consulta($cad);
				
			$row = $db->recuperar_array($result);
			
			$cad2 = "
					INSERT INTO ".PREFIX."ventas_detalles 
						(IDVENTA,IDPRODUCTO,IDMULTIMEDIA,TALLA,IDSTOCK,DESCRIPCION,PRECIO,TOTAL) 
					values 
						('".$IDVENTA."','".$row['IDPRODUCTO']."','".$row['IDMULTIMEDIA']."','".$row['TALLA']."','".$row['IDSTOCK']."','".$row['TITULO']."','".$row['PRECIO']."','".$row['PRECIO']."')
					";
			$result2=$db->consulta($cad2);
		}

	}else{
		//comprobando stock en almacen

		//cuando el cliente hace un pedido

		$cad_2 = "SELECT * FROM ayv_ventas_detalles WHERE IDVENTA = '".$IDVENTA."'";
		
		$result=$db->consulta($cad_2);

		while($row=$db->recuperar_array($result)){
			
			$result_stock = $db->consulta("SELECT * FROM ayv_stock WHERE IDMULTIMEDIA='".$row['IDMULTIMEDIA']."'");

			while($row_stock = $db->recuperar_array($result_stock)){

				if(comprobar_reserva($row_stock["IDSTOCK"])){

				}else{
					$db->consulta("UPDATE ayv_ventas_detalles SET IDSTOCK='".$row_stock["IDSTOCK"]."' WHERE IDDETALLE='".$row["IDDETALLE"]."' limit 1");
					break;
				}
			}
		}
	}
}


function comprobar_reserva($IDSTOCK){

	$db = new mysql();

	$link = conectarse();
	$result = $db->consulta("SELECT * FROM ayv_ventas_detalles WHERE IDSTOCK='$IDSTOCK'");
	if($db->recuperar_array($result)==1){
		return true;
	}else{
		return false;
	}
}
					

function compruebo_stock($IDMULTIMEDIA){
	$db = new mysql();	
	$link = conectarse();
	$result = $db->consulta("SELECT * FROM ayv_stock WHERE IDMULTIMEDIA = '".$IDMULTIMEDIA."'");
}

function insertar_pedido_externo($IDVENTA){
	
	$db = new mysql();		
	$link = conectarse();		
	global $AYV;
	//test_array($_POST['tabla']);

	if($_POST["elementos_comprar"]){
	
	$elementos = $_POST["elementos_comprar"];
	
	for($i=0;$i<count($elementos);$i++){

		$cad = "SELECT * FROM ayv_multimedia
					INNER JOIN ayv_productos
					ON ayv_multimedia.IDPRODUCTO = ayv_productos.IDPRODUCTO
				WHERE ayv_multimedia.IDMULTIMEDIA = '".$elementos[$i]." LIMIT 1'	
			";

		$result = $db->consulta($cad);
			
		$row = $db->recuperar_array($result);
		
		$cad2 = "
				INSERT INTO ".PREFIX."ventas_detalles 
					(IDVENTA,IDPRODUCTO,IDMULTIMEDIA,TALLA,COLOR,IDSTOCK,DESCRIPCION,PRECIO,TOTAL) 
				values 
					('".$IDVENTA."','".$row['IDPRODUCTO']."','".$row['IDMULTIMEDIA']."','".$_POST["TALLAS_SOLICITADAS"][$i]."','".$row['COLOR']."','".$row['IDSTOCK']."','".$row['LABEL']."','".$row['PRECIO']."','".$row['PRECIO']."')
				";
		$result2=$db->consulta($cad2);
	}
	
	
	}
}

function tallas_select($IDMULTIMEDIA){


	$db = new mysql();	

	$link = conectarse();

	$cad = "SELECT * FROM ayv_multimedia
				INNER JOIN ayv_productos
				ON ayv_multimedia.IDPRODUCTO = ayv_productos.IDPRODUCTO
			WHERE ayv_multimedia.IDMULTIMEDIA = '".$IDMULTIMEDIA." LIMIT 1'	
	";

	$result = $db->consulta($cad);

	$row = $db->recuperar_array($result);

	$tallas = explode(",",$row['TALLAS']);

	for($i=0;$i<count($tallas);$i++){
		echo'<option value="'.$tallas[$i].'">'.$tallas[$i].'</option>';
	}
	
}


function borrar_datos_tabla($IDVENTA){
	$db = new mysql();		
	global $AYV;
	$link = conectarse();
	$db->consulta("DELETE FROM ".PREFIX."ventas_detalles WHERE IDVENTA='".$IDVENTA."'");
	//test_array($KEY);
	/*for($i=0;$i<count($KEY);$i++){
		//echo $KEY[$i];
		mysql_query("DELETE FROM ayv_ventas_detalles WHERE IDVENTA='".$IDVENTA."'",$link);
	}*/
}

function borrar_datos_tabla_promo($IDPROMO){

	$db = new mysql();		
	global $AYV;
	$link = conectarse();
	$db->consulta("DELETE FROM ".PREFIX."promociones_detalles WHERE IDPROMOCION='".$IDPROMO."'");
	//test_array($KEY);
	/*for($i=0;$i<count($KEY);$i++){
		//echo $KEY[$i];
		mysql_query("DELETE FROM ayv_ventas_detalles WHERE IDVENTA='".$IDVENTA."'",$link);
	}*/
}

function borrar_ciudades_promo($IDPROMO){

	$db = new mysql();		
	global $AYV;
	$link = conectarse();
	$db->consulta("DELETE FROM ".PREFIX."promociones_ciudades WHERE IDPROMOCION='".$IDPROMO."'");
	//test_array($KEY);
	/*for($i=0;$i<count($KEY);$i++){
		//echo $KEY[$i];
		mysql_query("DELETE FROM ayv_ventas_detalles WHERE IDVENTA='".$IDVENTA."'",$link);
	}*/
}


function borrar_datos_tabla_campana($IDCAMPANA){
	
	$db = new mysql();	
	global $AYV;
	$link = conectarse();
	$db->consulta("DELETE FROM ".PREFIX."campanas_detalles WHERE IDCAMPANA='".$IDCAMPANA."'");
	//test_array($KEY);
	/*for($i=0;$i<count($KEY);$i++){
		//echo $KEY[$i];
		mysql_query("DELETE FROM ayv_ventas_detalles WHERE IDVENTA='".$IDVENTA."'",$link);
	}*/
}

function insertar_categorias($array,$IDPRODUCTO){

	$db = new mysql();		
	$link=conectarse();
	$db->consulta("DELETE FROM ".PREFIX."productos_relaciones WHERE IDPRODUCTO='".$IDPRODUCTO."'");

	for($i=0;$i<count($array);$i++){
		$db->consulta("INSERT INTO ".PREFIX."productos_relaciones (IDPRODUCTO,IDCATEGORIA) values ('".$IDPRODUCTO."','".$array[$i]."')");
	}
}




?>