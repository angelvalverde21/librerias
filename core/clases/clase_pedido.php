<?php 
	class pedido{

		function __construct(){

		}

		function registrar_usuario(){
			$config = array('TABLA'=>'usuarios','FECHA'=>true);
			$this->IDUSUARIO = insertar($config);
			return $IDUSUARIO;

		}

		function registrar_direccion_envio(){

			$config1 = array('TABLA'=>'direcciones_envio','FECHA'=>true,'CAMPOS_EXTRAS'=>array('IDUSUARIO'=>$this->IDUSUARIO));
			$this->IDENVIO = insertar($config1);

		}

		function registrar_direccion_facturacion(){

			$config2 = array('TABLA'=>'direcciones_facturacion','FECHA'=>true,'CAMPOS_EXTRAS'=>array('IDUSUARIO'=>$this->IDUSUARIO));
			$this->IDFACTU = insertar($config2);

		}

		function registrar_venta(){
			//inserto venta
			$config3 = array('TABLA'=>'ventas','FECHA'=>true,'CAMPOS_EXTRAS'=>array('IDENVIO'=>$this->IDENVIO,'IDFACTURACION'=>$this->IDFACTU,'IDUSUARIO'=>$this->IDUSUARIO,'ORIGEN'=>'ONLINE','IDPROMOCION'=>$_SESSION['CARRITO']['CONFIG']['IDPROMO']));
			$this->IDVENTA = insertar($config3);
			
		}

		function codigo_venta(){
			return $this->IDVENTA;
		}

		function obtener_part_number(){

		}

		function registrar_detalles_venta(){

			$db 			= new mysql();
			$IDVENTA 		= $this->IDVENTA;
			session_start();	
			$IDMULTIMEDIA 	= $_SESSION['CARRITO']["IDMULTIMEDIA"];
			$TALLA 			= $_SESSION['CARRITO']["TALLAS"];

			$total_productos = count($IDMULTIMEDIA);

			//itermoas la cantidad de productos diferentes pedidos



			for($i=0;$i<count($IDMULTIMEDIA);$i++){

				//query para la tabla multimedia
				$query_multimedia	=	"SELECT * FROM ".PREFIX."multimedia WHERE IDMULTIMEDIA='".$IDMULTIMEDIA[$i]."' LIMIT 1";
				$result_multimedia	=	$db->consulta($query_multimedia);
				$row_multimedia		=	$db->recuperar_array($result_multimedia);

				//query para la tabla productos
				$query_productos	=	"SELECT * FROM ".PREFIX."productos WHERE IDPRODUCTO='".$row_multimedia['IDPRODUCTO']."' LIMIT 1";
				$result_productos	=	$db->consulta($query_productos);
				$row_productos		=	$db->recuperar_array($result_productos);

				/********************** FIJANTDO EL MEJOR PRECIO PARA EL CLIENTE ***********************/

				if($_SESSION['CARRITO']['CONFIG']['IDPROMO']>0){

					$result_promo	= $db->consulta("SELECT * FROM ayv_promociones WHERE IDPROMOCION='".$_SESSION['CARRITO']['CONFIG']['IDPROMO']."' LIMIT 1");
					$row_promo		= $db->recuperar_array($result_promo);
					$row_productos['PRECIO_NORMAL']=redondear_dos_decimal($row_promo['PRECIOTOTAL']/$total_productos);

				}else{
	
					$precio_paquetes = $row_productos['PRECIO_PAQUETES'];
					$paquetes = explode(':', $precio_paquetes);

					for($j=0;$j<count($paquetes);$j++){
						$vector = explode('x',$paquetes[$j]);
						$precio_array 		= $vector[1];
						$cantidad_array 	= $vector[0];

						if($cantidad_array==$total_productos){
							$row_productos['PRECIO_NORMAL'] = $precio_array;
							break;
						}
					}			
				}

				/**************************************************************************************/

				$TOTAL = redondear_dos_decimal($row_productos['PRECIO_ETIQUETA']);

				//Obtener part number a partir de talla y color
				$query_part = "SELECT * FROM ayv_part_number WHERE IDPRODUCTO='".$row_multimedia['IDPRODUCTO']."' AND IDMULTIMEDIA='".$IDMULTIMEDIA[$i]."' AND TALLA='".$TALLA[$IDMULTIMEDIA[$i]]."' LIMIT 1";
				//echo $query_part."<br>";
				$result_part = $db->consulta($query_part);
				$row_part = $db->recuperar_array($result_part);
				//echo $db->contar_consulta($result_part);

				$query = "
						INSERT INTO ".PREFIX."ventas_detalles 
							(CANTIDAD,DESCRIPCION,PRECIO_ETIQUETA,PRECIO_PROMO,IDVENTA,IDPARTNUMBER,IDMULTIMEDIA,TALLA,TOTAL) 
						values 
							('1','".$row_multimedia['LABEL']."','".$row_productos['PRECIO_ETIQUETA']."','".$row_productos['PRECIO_NORMAL']."','".$IDVENTA."','".$row_part['IDPARTNUMBER']."','".$IDMULTIMEDIA[$i]."','".$TALLA[$IDMULTIMEDIA[$i]]."','".$TOTAL."')
						";

				$result=$db->consulta($query);
				if (!$result){
					//ECHO $cadena_sql,$link;
					//die(mysql_error());
				}
			}

		}

		function rapido(){

			$this->registrar_usuario();
			$this->registrar_direccion_envio();
			$this->registrar_direccion_facturacion();
			$this->registrar_venta();
			$this->registrar_detalles_venta();
		}

	}
 ?>
