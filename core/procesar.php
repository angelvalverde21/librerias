<?php

	switch($_POST['TIPO']){
	
		case'PEDIDO':
			switch($_POST['PROCESO']){
				
				case'VERIFICAR':
					if(count($_POST['seleccionados'])>0){
						//Como hay mas de un elemento seleccionado guardo los elementos en iniciar_carrito()
						
						iniciar_carrito();
						
						if(login()){

							if(carrito()>0){
								procesar_pedido_login($_SESSION['IDUSUARIO']);
								
							}else{
								header("location: ".get_option("usuario"));
							}

						}else{
							header("location: ".get_option("home")."/login");
						}	

					}else{
						header("location: ".$_SERVER["HTTP_REFERER"]."?seleccionados=error");
					}
				break;

				case'CHECKOUT':
					
					test_array($_SESSION);
					test_array($_POST);
										
					//iniciar_carrito();
					
					$carrito = new carrito();
					
						//$IDVENTA=procesar_y_registrar_usuario();
						//test_array($_POST);
						
						$IDVENTA = procesar_y_registrar_usuario();
						//enviar_email('NUEVOPEDIDO',$IDVENTA);
						header("location: ".get_option('home')."/pedidos/".$IDVENTA."");
					
					
				break;
			}
		break;
		

		case'FORM_LOGIN':		
			switch($_POST['PROCESO']){
				case'LOGIN':
					
				break;
				case'REGISTRO':
					procesar_registro();
					header("location: ".get_option('usuario'));
				break;				
			}
		break;
	
		case'REGISTRO':

			/*if(comprobar_email($_POST["register_email"])){*/
				if(($_POST["register_pass"]<>"" AND $_POST["register_pass"]<>"" AND $_POST["register_name"]<>"") AND ($_POST["register_pass"]==$_POST["register_repass"])){
					if(comprobar_nombre($_POST["register_name"])){
						//registrando usuario
						$link = conectarse();
						mysql_query("INSERT INTO ".PREFIX."usuarios (NOMBRE,EMAIL,PASSWORD,DIRECCION_TEMP,PEDIDO_TEMP,DISPOSITIVO,IP,USER_AGENT,FECHA) values ('".$_POST['register_name']."','".$_POST['register_email']."','".$_POST['register_pass']."','".$_POST['direccion_temp']."','".$_POST['pedido_temp']."','".$_POST['dispositivo']."','".$_POST['ip']."','". $_SERVER['HTTP_USER_AGENT']."','".fechasql()."')",$link);
						$_SESSION["IDUSUARIO"] = mysql_insert_id();	
						enviar_email('REGISTRO',$_SESSION["IDUSUARIO"]);
						header("location:".get_option("usuario")."/envio?caso=nuevo");
					}
				}else{
					header("location:".get_option("home")."/login?error");
				}
			/*}*/
			
		break;
		
		case'REGISTRAR_ENVIO':
			switch($_POST["CASO"]){
				case'NUEVO':
					$config = array('TABLA'=>'direcciones_envio','FECHA'=>true);
					insertar($config);
					if($_POST["PEDIDO"]=="NUEVO"){
						header("location:".get_option('usuario')."/realizar-pedido");
					}else{
						header("location:".get_option('usuario')."/envio");
					}
				break;
			}

		break;

		case'CONFIRMARPEDIDO':
			unset($_SESSION['IDMULTIMEDIA']);
			iniciar_carrito();
			if(login()){
				if(comprobar_direccion_envio($_SESSION["IDUSUARIO"])){
					header("location:".get_option("usuario")."/realizar-pedido");
				}else{
					header("location:".get_option("usuario")."/envio?caso=nuevo");
				}
			}else{
				header("location:".get_option("home")."/login");
			}			

		break;


		case'REALIZARPEDIDO':
			$config = array('TABLA'=>'ventas','FECHA'=>true);
			$IDVENTA = insertar($config);
			enviar_email('NUEVOPEDIDO',$IDVENTA);
			insertar_tabla($IDVENTA);
			unset($_SESSION["IDMULTIMEDIA"]);
			header("location: ".get_option('usuario')."/pedidos/$IDVENTA");
		break;

		case'LOGIN':
			iniciar_carrito();
			if(login()){
				if(comprobar_carrito()>0){
					if(comprobar_direccion_envio($_SESSION["IDUSUARIO"])){
						header("location:".get_option("usuario")."/realizar-pedido");
					}else{
						header("location:".get_option("usuario")."/envio?caso=nuevo");
					}
				}else{
					header("location:".get_option("usuario"));
				}
				
			}else{
				header("location:".get_option("usuario")."/?error=1");
			}
		break;
		
		case'DISTRITOS':

			switch($_POST['CASO']){
				case'localidades':
					switch($_POST['SELECCION']){
						case'departamento':				
							//get_distritos('provincia',$_POST['ID']);					
						break;
						
						case'provincia':
							
							get_distritos('provincia',$_POST['ID']);								
						break;	

						case'distritos':
							get_distritos('distritos',$_POST['ID']);								
						break;					
					}			
				break;

			}
		break;

		case'METODOPAGOAJAX':	

			$link = conectarse();
			$result = mysql_query("select * from ".PREFIX."direcciones_envio WHERE IDENVIO='".$_POST['ID']."' LIMIT 1",$link);
			$row = mysql_fetch_array($result);

			if(($row['PROVINCIA']=="150100") OR ($row['PROVINCIA']=="070000")){
				echo "<option>Pago Contra entrega</option><option>Pago Agente Bcp / Transferencia Bcp</option>***0";

			}else{
				echo "<option>Pago Agente Bcp / Transferencia Bcp</option>***10";
			}

			
		break;

		default:
			echo"Aquarella";
		break;

	}
?>