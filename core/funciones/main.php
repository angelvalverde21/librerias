<?php 

function conectarse() { 
	global $AYV;
		
	if (!($link=mysql_connect($AYV['db']['host'],$AYV['db']['user'],$AYV['db']['pass']))) 
	{ 
		echo "Error conectando a la base de datos."; 
		 exit(); 
	} 
	
	if (!mysql_select_db($AYV['db']['name'])) 
	{ 
		echo "Error seleccionando la base de datos."; 
		exit(); 
	} 
	return $link; 
} 



function theme($tipo="link"){
	//buscando el theme por defecto
	
	$theme_encontrado=0;
	if($theme_encontrado>=1){
	}else{
		$theme="default";
	}
		
	global $AYV;	
	
	if($tipo=="dir"){
		return DIR_WEB.'/themes/'.$theme;		
	}else{
		return URL_WEB.'/themes/'.$theme;		
	}

}



function login($type=""){

	global $AYV;
	$db = new mysql();

	//parametros de login
	$usuario	= post($_POST['USER']);
	$password 	= post($_POST['PASSWORD']);

	//test_array($_POST);

	//parametros con los cuales la variable $usuario se va a comparar
	//$parametros = array('EMAIL','USUARIO','CELULAR');
	$parametros = array('EMAIL','USUARIO');
	
	//estableciendo los nombres de $IDUSUARIO Y $NIVEL
	$IDUSUARIO	= 'IDUSUARIO';
	$NIVEL		= 'NIVEL';
	
	//parametros a iniciar si es que se hace login
	
	$variables = array($IDUSUARIO,$NIVEL,'IDEMPRESA','IDALMACEN','NOMBRE','NIVEL');
	
	//Formando cadena de parametros
	for($i=0;$i<count($parametros);$i++){
		$cadena .= $parametros[$i]."='".$usuario."' OR ";
	}

	$sql = quitar_ultimos_caracteres($cadena,3);
	
	//Quitar ultimos 3 caracteres
	
		if(post($_POST["TIPO"])=="LOGIN"){

			if($usuario<>""){
			
				$query = "SELECT * FROM ".PREFIX."usuarios WHERE ".$sql." LIMIT 1";		
				$result	=	$db->consulta($query);
				$user	=	$db->recuperar_array($result);	
				
				if($db->contar_consulta($result)==1){
					
					//colocando md5 a la contraseña
					$pass_md5 = md5($AYV['hash']['salt'].$password);

					if($pass_md5==$user["PASSWORD"]){
						
						//Iniciar sesiones de variables

						for($i=0;$i<count($variables);$i++){					
							$_SESSION[$variables[$i]] 	= $user[$variables[$i]];
						}

						//print_r($_SESSION);
						
						//registrar session

						$db->consulta("INSERT INTO ayv_sessiones (IDUSUARIO,FECHA,INTENTO,USER_AGENT,DISPOSITIVO,IP,IDEMPRESA) values ('".$_SESSION['IDUSUARIO']."','".fechasql()."','CORRECTO','".$_SERVER['HTTP_USER_AGENT']."','".dispositivo()."','".getIP()."','1')");

						return true;
						
					}else{
						/****** password incorrecto *****/
						header("location: ".get_option("home")."/login?type=".$_POST['type']."&caso=error&display=pass&redirect=".$_POST["redirect"]);
						exit;
					}

				}else{
					//echo $query;
					//echo md5($AYV['hash']['salt'].$_POST["login_pass"]);
					/****** No se encontro el usuario *****/
					header("location: ".get_option("home")."/login?type=".$_POST['type']."&caso=error&display=email&redirect=".$_POST["redirect"]);
					exit;
				}
			}else{
				//debe ingresar un usuario 
				header("location: ".get_option("home")."/login?type=".$_POST['type']."&".$usuario."&caso=error&display=void&redirect=".$_POST["redirect"]);
				exit;
			}
		}else{
			if(isset($_SESSION[$IDUSUARIO]) AND isset($_SESSION[$NIVEL])){
				return true;
			}else{
				return false;
			}
		}

}


	
function get_option($parametro){

	global $AYV;
	
	switch($parametro){
		case'home':
			$url = $AYV['url_global']['system']; 
		break;
		case'usuario':
			$url = URL_USUARIO; 
		break;	
		case'admin':
			$url = URL_ADMIN; 
		break;		
	}

	return $url;
}	

function redirect(){
	

	global $AYV;
	return	urlencode($AYV['url']['scheme'].$AYV['url']['domain'].$_SERVER['REQUEST_URI']);

}



function extension($filename){
	return substr(strrchr($filename, '.'), 1);
}

function test_array($parametro){
	echo"<pre>";
	print_r($parametro);
	echo"</pre>";
}


function procesar_campo($value,$parametro){

	//$tipos = array_keys($parametro);



	switch($parametro){

		case'TEXT':
				
			$cadena = short_cadena($value,$parametro);
			break;

		case'TEXT_ESTADO':
				
			$cadena = estado_venta($value);
			break;

		case'FECHA':

			break;

		case'DISTRITO':
			$value = distrito($value);
			$cadena = short_cadena($value,$parametro);
			break;

		case'TIPOPAGO':
			$cadena = tipopago($value);
			break;

		case'MEDIOPEDIDO':
			$cadena = medio_pedido($value);
			break;

		default:
			$cadena = $tipos[0].$value;
			break;

	}

	return $cadena;
}


function short_cadena($value,$tamano){
	if($tamano>0){
		if(strlen($value)>$tamano){
			$cadena = "<div title='".$value."'>".substr($value,0,$tamano)."...</div>";
		}else{
			$cadena = $value;
		}
	}else{
		$cadena = $value;
	}

	return $cadena;
}


function estado_venta($value){

	switch($value){
		case'0':
			$cadena = "<div class='venta_estado_pendiente' title='Pendiente de revision o entrega'></div>";
			//pendiente
			break;
		case'3':
			$cadena = "<div class='venta_estado_entregado' title='Entregado'></div>";
			//entregado
			break;
		case'7':
			$cadena = "<div class='venta_estado_cancelado' title='Cancelado'></div>";
			//cancelado
			break;
		case'9':
			$cadena = "<div class='venta_estado_pendiente_entrega' title='Pendiente de entrega'></div>";
			//cancelado
			break;
		default:
			$cadena = "No encontrado";
			break;
	}

	return $cadena;
}


function almacen($IDALMACEN=1){
	$db = new mysql();
	$result_almacen = $db->consulta("SELECT * FROM ".PREFIX."almacen");
	$option_almacen.="<option value='0'>Escoger</option>";
	while($row_almacen = $db->recuperar_array($result_almacen)){
		if($row_almacen["IDALMACEN"]==$IDALMACEN){
			$option_almacen.= "<option value=".$row_almacen["IDALMACEN"]." selected>".$row_almacen["NOMBRE"]."</option>";
		}else{
			$option_almacen.= "<option value=".$row_almacen["IDALMACEN"].">".$row_almacen["NOMBRE"]."</option>";
		}
	}
	return $option_almacen;
}




function estado_pedido($key=0,$mostrar=false){

	$ESTADO = estados_pedidos_array();

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

function enlinea($cadena){
	return str_replace("\n", "", $cadena);
}

function matriz_tabla_pedido(){
	?>
<!-- insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla-->
<?php

	$db = new mysql();
	$IDVENTA = $_GET["IDVENTA"];

	if($IDVENTA>0){

			$result = $db->consulta("
				SELECT * FROM ayv_ventas_detalles 
						INNER JOIN ayv_multimedia 
						ON ayv_ventas_detalles.IDMULTIMEDIA = ayv_multimedia.IDMULTIMEDIA
						INNER JOIN ayv_productos
					ON ayv_ventas_detalles.IDPRODUCTO = ayv_productos.IDPRODUCTO							
				WHERE IDVENTA='".$IDVENTA."'"
			);

		$index=1;

		while($row = $db->recuperar_array($result)){						
			$fila_php .= fila_tabla($index,$row);
			$index++;
		}
	
	}else{

	}
								
	$fila = fila_tabla();
	$fila = eregi_replace("[\n|\r|\n\r]", ' ', $fila);

?>

<!-- script para eliminar filas de los pedidos -->

	<script>
		$(document).on('click','.icon_eliminar',function(){
			var tr = $(this).closest('tr');
			tr.css("background-color","#6A6A6A");
			tr.fadeOut(400, function(){
			tr.remove();
			});
			return false;
		});
	</script>

						<!-- script para asignar un id a cada fila que se agregue -->

						<script>
							$(document).ready(function(){
								
								$("#insertar_producto").on('click',function(){	
									//eliminar el comportamiento por defecto del enlance
									
									var IDFILA;
									IDFILA = parseInt($("#insertar_producto").attr('data-valor'));
									//alert($("#insertar_producto").attr('data-valor'));
									$("#tabla_pedidos").append("<?php echo $fila; ?>");
									var siguiente;
									siguiente = IDFILA+1;	
									$(this).attr('data-valor',siguiente);
									return false;
								});

								//****** funcion que te devuelve el valor de cualquier input dentro de la tabla *******

								/*$(document).on('click','#tabla_pedidos tr td',function(){	
									alert($(this).find(":input").val()); 
								});*/

								//*************************************************************************************

								/*$(document).on('click','#tabla_pedidos tr td',function(){
									alert($(this).find(":input").val()); 
								});*/
							});
						</script>

					

							<table id="tabla_pedidos" class="">
								
								<tr>
									<td class='tabla_codigo'>#PARTE</td>
									<td class='tabla_descripcion'>DESCRIPCION</td>
									<td class='tabla_cant'>#COD</td>
									<td class='tabla_color'>COLOR/DISE&Ntilde;O</td>
									<td class='tabla_talla'>TALLA</td>
									<td class='tabla_cant'>CANT.</td>
									<td class='tabla_precio'>PRECIO</td>
									<td class='tabla_precio'>PRECIO PROMO</td>
									<td class='tabla_total'>TOTAL</td>
									<td class='tabla_eliminar'></td>
									<td class='tabla_reserva_stock'>STOCK</td>
								</tr>

								<?php echo $fila_php; ?>
									
								<?php //pedidos_realizados($_GET["IDVENTA"]); ?>
								
							</table>

						

						<a id="insertar_producto" data-valor="<?php if($index>0){ echo $index; }else{ echo "1";} ?>" href="">Insertar otro producto</a>

						
						<!-- FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN -->


						<!-- Inicio de tabla Ajax -->

						<script>
								
							//si usuario llena Si el usuario llena el titulo.... (*)
						
							$(document).on('keyup','.txt_p',function(){	

								//alert($(this).val()); 
							
								//////*****ID DE FILA: idfila; ******//////
								var fila;
								fila = $(this).data('fila');
								//////*****ID DE FILA: idfila; ******//////
	
								if($(this).val()==""){
									$('#rp_' + fila).hide();
								}else{
									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'productos',CADENA: $(this).val(),CAMPOS:'TITULO,DESCRIPCION',FILA: fila}
									})
									
									.done(function(msg){
										$('#rp_' + fila).show();
										$('#rp_' + fila).html(msg);
									});									
								}
								
							});


							$(document).on('keyup','.txt_id',function(){	
								var fila;
								fila = $(this).data('fila');
								//////*****ID DE FILA: idfila; ******//////
									
								if($(this).val()==""){
									$('#rp_' + fila).hide();
								}else{
									
									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'productos_unique',CADENA: $(this).val(),CAMPOS:'TITULO,DESCRIPCION',FILA: fila}
									})
									
									.done(function(msg){
										$('#rp_' + fila).show();
										$('#rp_' + fila).html(msg);
									});									
								}
							});


								

							$(document).on('click','.txt_p',function(){	
								var fila;
								fila = $(this).data('fila');
								cad = $(this).val();
								if(cad != ""){
									$('#rm_'+fila).show();
									
								}
							});

							//(*)... o en todo caso Si el usuario llena el codigo del producto

						</script>

						<style>

							.txt_t, .txt_pr{
								font-size: 10pt !important;
							}

							.txt_p{
								text-align: left !important;
								padding-left: 5px;
								font-size: 10pt !important;
							}

							.rp{
								width: 100%;
								position: absolute;
								top: 0px;
								left: 0px;
								background: #fff;
								opacity: 1;
								z-index: 10;
								border: 1px solid #ccc;
								box-shadow: 5px 5px 5px #888888;	
								overflow-x:hidden; 
								overflow-y:scroll;
								min-height: 30px;
								display: none;
								text-align: left;
							}


							.rp li a{
								display: block;
								border-bottom: 1px dashed #ccc;
								padding: 5px;	
								color: #000;
								font-size: 10pt;
							}

							.rp li a:hover{
								background: #f0f0f0;
							}
							.rp li:nth-child(2n+1){
								background: #f9f9f9;
							}

							.cp{
								position: relative;
								width: 100%;
								height: 1px;
								border: 0px solid red;
							}
						</style>

						<!-- fin de tabla Ajax -->

						<script>
							//resultados de busqueda
							$(document).on('click','.rp_ajax',function(){
								
								var fila;
								fila = $(this).data('fila');
								codigo = $(this).data('codigo');
								precio = $(this).data('precio');
								
								$("#txt_id_"+fila).val(codigo);

								$("#txt_pr_"+fila).val(precio);
								
								//asigno el valor al input correspondiente a la descripcion del producto
								$("#txt_p_" + fila).val($(this).text());
								$('#rp_' + fila).hide();

								/***********************************/
								/***********************************/
								/***** BUSCANDO COINCIDENCIAS ******/	
								/***********************************/
								/***********************************/

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'multimedia',IDPRODUCTO: codigo,FILA: fila}
									})

											
									.done(function(msg){
										$('#rm_'+fila).show();
										$('#rm_'+fila).html(msg);
										
									});		

									
									
								/*});*/

								/***********************************/
								/***********************************/
								/***** BUSCANDO COINCIDENCIAS ******/	
								/***********************************/
								/***********************************/

								return false;
							});


							//buscando producto por codigo de color

							$(document).on('keyup','.txt_im',function(){
								var fila;
								fila = $(this).data('fila');
								IDMULTIMEDIA = $(this).val();

								/*
								codigo = $(this).data('codigo');
								precio = $(this).data('precio');
								$("#txt_id_"+fila).val(codigo);
								$("#txt_pr_"+fila).val(precio);
								*/

								//asigno el valor al input correspondiente a la descripcion del producto

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'multimedia_unique',IDMULTIMEDIA: IDMULTIMEDIA,FILA: fila}
									})
											
									.done(function(msg){
										$('#rm_'+fila).show();
										$('#rm_'+fila).html(msg);
										
									});

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'multimedia_producto',IDMULTIMEDIA: IDMULTIMEDIA,FILA: fila}
									})
											
									.done(function(msg){
										$('#txt_id_'+fila).val(msg);
									});
					

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'multimedia_producto_titulo',IDMULTIMEDIA: IDMULTIMEDIA,FILA: fila}
									})
											
									.done(function(msg){
										$('#txt_p_'+fila).val(msg);
									});
					

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'multimedia_producto_precio',IDMULTIMEDIA: IDMULTIMEDIA,FILA: fila}
									})
											
									.done(function(msg){
										$('#txt_pr_'+fila).val(msg);
									});
					
					
							});

						</script>
						
						<style>
							.rm{
								width: 100%;
								position: absolute;
								top: 0px;
								left: 0px;
								background: #fff;
								opacity: 1;
								z-index: 10;
								border: 1px solid #ccc;
								box-shadow: 5px 5px 5px #888888;	
								overflow-x:hidden; 
								overflow-y:scroll;
								height: 350px;
								display: none;
								text-align: left;
							}


							.cm{
								position: relative;
								width: 100%;
								height: 1px;
								border: 0px solid red;
							}

							.txt_m{
								height: 100px;
							}
						
						</style>

						<script>
							$(document).on('click','.rm_ajax',function(){
								
								var i;
								var selector_cantidad;
								var opcion;
								var codigo;

								stock = $(this).data('stock');
								fila = $(this).data('fila');
								archivo = $(this).data('archivo');

								//verificar_stock = $(this).data('label');

								IDMULTIMEDIA = $(this).data('multimedia');

								$("#txt_im_"+fila).val(IDMULTIMEDIA);
								$('#rm_'+fila).hide();
								$('#txt_m_'+fila).html('<img height="100" src="<?php echo URL_UPLOADS; ?>/thumb-'+archivo+'">');
								
								IDALMACEN = $("#consultar_almacen").val();
								
								/********* respuesta a stock en almacen *******/

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'stock',IDMULTIMEDIA: IDMULTIMEDIA,IDALMACEN: IDALMACEN}
									})
											
									.done(function(msg){
										
										$('#select_talla_' + fila).html(msg);
										
									});		

								return false;
							});
						
						</script>

						<script>
							//reset de ventanas desplegables

							$(document).on('click','.user_info',function(){	
								var fila;

								if($('.rm').is(":visible")){
									//alert(fila);
									$('.rm').hide();
								}else{
									//alert('Invisible');
								}	
							})


							$(document).keyup(function(e) {
								if (e.keyCode == 27) { // escape key maps to keycode `27`
									if($('.rm').is(":visible")){
										//alert(fila);
										$('.rm').hide();
									}else{
										//alert('Invisible');
									}		
							
									if($('.rp').is(":visible")){
										//alert(fila);
										$('.rp').hide();
									}else{
										//alert('Invisible');
									}	
								}
							});


						

						</script>

						<script>
							/*
							$(document).on('change','.select_talla',function(){
								fila = $(this).data('fila');
								array = $(this).val();
								cantidad = array.split('-');
								var option;
								option = '<option value="0">Seleccionar</option>';
								for(i=1;i<=cantidad[1];i++){
									option = option + '<option value="'+i+'">'+i+'</option>';
								}
								$("#txt_ca_"+fila).html(option);
							});
							*/
							$(document).on('keyup','.txt_ca',function(){
								fila = $(this).data('fila');
								total = $(this).val() * $("#txt_pr_"+fila).val();
								$("#txt_t_"+fila).val(parseFloat(total).toFixed(2));
							});
						</script>
	
						<script>
							$(document).on('change','.select_almacen',function(){

								var fila;
								fila = $(this).data('fila');
								IDMULTIMEDIA = $("#txt_im_"+fila).val();
								$.ajax({
									type: "POST",
									url: "ajax.php",
									data: { PAGINA: 'AJAX', TABLA:'stock_select_almacen',IDMULTIMEDIA: IDMULTIMEDIA,IDALMACEN: $(this).val()}
								})
											
								.done(function(msg){
									
									$('#select_talla_' + fila).html(msg);
										
								});		

							});
						</script>

						<script>
							$(document).on('change','#consultar_almacen',function(){

								//esta funcion ubica los numeros de filas dados por la variable fila
								$('#tabla_pedidos tr[data-fila]').each(function() {
									var fila;
									fila = $(this).data('fila');
									//var customerId = $(this).find(".customerIDCell").html();   
									IDMULTIMEDIA = $('#txt_im_'+fila).val();
									
									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'stock_select_almacen',IDMULTIMEDIA: IDMULTIMEDIA,IDALMACEN: $("#consultar_almacen").val()}
									})
												
									.done(function(msg){
										
										$('#select_talla_' + fila).html(msg);
									});		 
								 });

							});


						</script>
<?php
}


function matriz_tabla_pedido_boot(){
	?>
<!-- insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla insertar tabla-->
<?php

	$db = new mysql();
	$IDVENTA = $_GET["IDVENTA"];

	if($IDVENTA>0){

			$result = $db->consulta("
				SELECT * FROM ayv_ventas_detalles 
						INNER JOIN ayv_multimedia 
						ON ayv_ventas_detalles.IDMULTIMEDIA = ayv_multimedia.IDMULTIMEDIA
						INNER JOIN ayv_productos
					ON ayv_ventas_detalles.IDPRODUCTO = ayv_productos.IDPRODUCTO							
				WHERE IDVENTA='".$IDVENTA."'"
			);

		$index=1;

		while($row = $db->recuperar_array($result)){						
			$fila_php .= fila_tabla($index,$row);
			$index++;
		}
	
	}else{

	}
								
	$fila = fila_tabla();
	$fila = eregi_replace("[\n|\r|\n\r]", ' ', $fila);

?>

<!-- script para eliminar filas de los pedidos -->

	<script>
		$(document).on('click','.icon_eliminar',function(){
			var tr = $(this).closest('tr');
			tr.css("background-color","#6A6A6A");
			tr.fadeOut(400, function(){
			tr.remove();
			});
			return false;
		});
	</script>

						<!-- script para asignar un id a cada fila que se agregue -->

						<script>
							$(document).ready(function(){
								
								$("#insertar_producto").on('click',function(){	
									//eliminar el comportamiento por defecto del enlance
									
									var IDFILA;
									IDFILA = parseInt($("#insertar_producto").attr('data-valor'));
									//alert($("#insertar_producto").attr('data-valor'));
									$("#tabla_pedidos").append("<?php echo $fila; ?>");
									var siguiente;
									siguiente = IDFILA+1;	
									$(this).attr('data-valor',siguiente);
									return false;
								});

								//****** funcion que te devuelve el valor de cualquier input dentro de la tabla *******

								/*$(document).on('click','#tabla_pedidos tr td',function(){	
									alert($(this).find(":input").val()); 
								});*/

								//*************************************************************************************

								/*$(document).on('click','#tabla_pedidos tr td',function(){
									alert($(this).find(":input").val()); 
								});*/
							});
						</script>

					
							<table class="table text-center table-striped table-bordered table-hover" id="tabla_pedidos">
								<tbody>
									<tr>
										<th class='tabla_codigo'>#</th>
										<th class='tabla_descripcion'>DESCRIPCION</th>
										<th class='tabla_cant'>#COD</th>
										<th class='tabla_color'>MODELO</th>
										<th class='tabla_talla'>TALLA</th>
										<th class='tabla_cant text-center'>CANT.</th>
										<th class='tabla_precio text-center'>PRECIO</th>
										<th class='tabla_precio'>PROMO</th>
										<th class='tabla_total'>TOTAL</th>
										<th class='tabla_eliminar'>Dele</th>
										<th class='tabla_reserva_stock'>Stock</th>
									</tr>
								<?php echo $fila_php; ?>																	
								</tbody>
							</table>
					
						   
						<a class="btn btn-success pull-right" id="insertar_producto" data-valor="<?php if($index>0){ echo $index; }else{ echo "1";} ?>" href=""><span class="glyphicon glyphicon-plus margin-right"></span>Agregar Item</a>

						
						<!-- FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN FIN -->


						<!-- Inicio de tabla Ajax -->

						<script>
								
							//si usuario llena Si el usuario llena el titulo.... (*)
						
							$(document).on('keyup','.txt_p',function(){	

								//alert($(this).val()); 
							
								//////*****ID DE FILA: idfila; ******//////
								var fila;
								fila = $(this).data('fila');
								//////*****ID DE FILA: idfila; ******//////
	
								if($(this).val()==""){
									$('#rp_' + fila).hide();
								}else{
									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'productos',CADENA: $(this).val(),CAMPOS:'TITULO,DESCRIPCION',FILA: fila}
									})
									
									.done(function(msg){
										$('#rp_' + fila).show();
										$('#rp_' + fila).html(msg);
									});									
								}
								
							});


							$(document).on('keyup','.txt_id',function(){	
								var fila;
								fila = $(this).data('fila');
								//////*****ID DE FILA: idfila; ******//////
									
								if($(this).val()==""){
									$('#rp_' + fila).hide();
								}else{
									
									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'productos_unique',CADENA: $(this).val(),CAMPOS:'TITULO,DESCRIPCION',FILA: fila}
									})
									
									.done(function(msg){
										$('#rp_' + fila).show();
										$('#rp_' + fila).html(msg);
									});									
								}
							});
			
							$(document).on('click','.txt_p',function(){	
								var fila;
								fila = $(this).data('fila');
								cad = $(this).val();
								if(cad != ""){
									$('#rm_'+fila).show();
									
								}
							});

							//(*)... o en todo caso Si el usuario llena el codigo del producto

						</script>

						<style>

							.txt_t, .txt_pr{
								font-size: 10pt !important;
							}

							.txt_p{
								text-align: left !important;
								padding-left: 5px;
								font-size: 10pt !important;
							}

							.rp{
								width: 100%;
								position: absolute;
								top: 0px;
								left: 0px;
								background: #fff;
								opacity: 1;
								z-index: 10;
								border: 1px solid #ccc;
								box-shadow: 5px 5px 5px #888888;	
								overflow-x:hidden; 
								overflow-y:scroll;
								min-height: 30px;
								display: none;
								text-align: left;
							}


							.rp li a{
								display: block;
								border-bottom: 1px dashed #ccc;
								padding: 5px;	
								color: #000;
								font-size: 10pt;
							}

							.rp li a:hover{
								background: #f0f0f0;
							}
							.rp li:nth-child(2n+1){
								background: #f9f9f9;
							}

							.cp{
								position: relative;
								width: 100%;
								height: 1px;
								border: 0px solid red;
							}
						</style>

						<!-- fin de tabla Ajax -->

						<script>
							//resultados de busqueda
							$(document).on('click','.rp_ajax',function(){
								
								var fila;
								fila = $(this).data('fila');
								codigo = $(this).data('codigo');
								precio = $(this).data('precio');
								
								$("#txt_id_"+fila).val(codigo);

								$("#txt_pr_"+fila).val(precio);
								
								//asigno el valor al input correspondiente a la descripcion del producto
								$("#txt_p_" + fila).val($(this).text());
								$('#rp_' + fila).hide();

								/***********************************/
								/***********************************/
								/***** BUSCANDO COINCIDENCIAS ******/	
								/***********************************/
								/***********************************/

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'multimedia',IDPRODUCTO: codigo,FILA: fila}
									})

											
									.done(function(msg){
										$('#rm_'+fila).show();
										$('#rm_'+fila).html(msg);
										
									});		

									
									
								/*});*/

								/***********************************/
								/***********************************/
								/***** BUSCANDO COINCIDENCIAS ******/	
								/***********************************/
								/***********************************/

								return false;
							});


							//buscando producto por codigo de color

							$(document).on('keyup','.txt_im',function(){
								var fila;
								fila = $(this).data('fila');
								IDMULTIMEDIA = $(this).val();

								/*
								codigo = $(this).data('codigo');
								precio = $(this).data('precio');
								$("#txt_id_"+fila).val(codigo);
								$("#txt_pr_"+fila).val(precio);
								*/

								//asigno el valor al input correspondiente a la descripcion del producto

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'multimedia_unique',IDMULTIMEDIA: IDMULTIMEDIA,FILA: fila}
									})
											
									.done(function(msg){
										$('#rm_'+fila).show();
										$('#rm_'+fila).html(msg);
										
									});

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'multimedia_producto',IDMULTIMEDIA: IDMULTIMEDIA,FILA: fila}
									})
											
									.done(function(msg){
										$('#txt_id_'+fila).val(msg);
									});
					

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'multimedia_producto_titulo',IDMULTIMEDIA: IDMULTIMEDIA,FILA: fila}
									})
											
									.done(function(msg){
										$('#txt_p_'+fila).val(msg);
									});
					

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'multimedia_producto_precio',IDMULTIMEDIA: IDMULTIMEDIA,FILA: fila}
									})
											
									.done(function(msg){
										$('#txt_pr_'+fila).val(msg);
									});
					
					
							});

						</script>
						
						<style>
							.rm{
								width: 100%;
								position: absolute;
								top: 0px;
								left: 0px;
								background: #fff;
								opacity: 1;
								z-index: 10;
								border: 1px solid #ccc;
								box-shadow: 5px 5px 5px #888888;	
								overflow-x:hidden; 
								overflow-y:scroll;
								height: 350px;
								display: none;
								text-align: left;
							}


							.cm{
								position: relative;
								width: 100%;
								height: 1px;
								border: 0px solid red;
							}

							.txt_m{
								height: 100px;
							}
						
						</style>

						<script>
							$(document).on('click','.rm_ajax',function(){
								
								var i;
								var selector_cantidad;
								var opcion;
								var codigo;

								stock = $(this).data('stock');
								fila = $(this).data('fila');
								archivo = $(this).data('archivo');

								//verificar_stock = $(this).data('label');

								IDMULTIMEDIA = $(this).data('multimedia');

								$("#txt_im_"+fila).val(IDMULTIMEDIA);
								$('#rm_'+fila).hide();
								$('#txt_m_'+fila).html('<a class="producto-galeria" data-imagen="<?php echo URL_UPLOADS; ?>/grande-'+archivo+'" data-toggle="modal" data-target="#modal-galeria-producto" href="#"><img height="100" src="<?php echo URL_UPLOADS; ?>/thumb-'+archivo+'"></a>');
								


								IDALMACEN = $("#consultar_almacen").val();
								
								/********* respuesta a stock en almacen *******/

									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'stock',IDMULTIMEDIA: IDMULTIMEDIA,IDALMACEN: IDALMACEN}
									})
											
									.done(function(msg){
										
										$('#select_talla_' + fila).html(msg);
										
									});		

								return false;
							});
						
						</script>

						<script>
							//reset de ventanas desplegables

							$(document).on('click','.user_info',function(){	
								var fila;

								if($('.rm').is(":visible")){
									//alert(fila);
									$('.rm').hide();
								}else{
									//alert('Invisible');
								}	
							})


							$(document).keyup(function(e) {
								if (e.keyCode == 27) { // escape key maps to keycode `27`
									if($('.rm').is(":visible")){
										//alert(fila);
										$('.rm').hide();
									}else{
										//alert('Invisible');
									}		
							
									if($('.rp').is(":visible")){
										//alert(fila);
										$('.rp').hide();
									}else{
										//alert('Invisible');
									}	
								}
							});


						

						</script>

						<script>
							/*
							$(document).on('change','.select_talla',function(){
								fila = $(this).data('fila');
								array = $(this).val();
								cantidad = array.split('-');
								var option;
								option = '<option value="0">Seleccionar</option>';
								for(i=1;i<=cantidad[1];i++){
									option = option + '<option value="'+i+'">'+i+'</option>';
								}
								$("#txt_ca_"+fila).html(option);
							});
							*/
							$(document).on('keyup','.txt_ca',function(){
								fila = $(this).data('fila');
								total_promo = $(this).val() * $("#txt_pr_promo_"+fila).val();
								total = $(this).val() * $("#txt_pr_"+fila).val();

								if(total>total_promo){
									$("#txt_t_"+fila).val(parseFloat(total_promo).toFixed(2));	
								}else{
									$("#txt_t_"+fila).val(parseFloat(total).toFixed(2));	
								}
								
							});		


							//ancha
								$(document).on('keyup','.txt_pr_promo',function(){

									fila = $(this).data('fila');

									total_promo = $("#txt_pr_promo_"+fila).val();
									cantidad = $("#txt_ca_"+fila).val();

									$("#txt_t_"+fila).val(parseFloat(total_promo)*parseFloat(cantidad));	
									
								});	


						</script>

						<script>
							$(document).ready(function(){
								var numerofilas = $('#tabla_pedidos > tbody > tr').length -1;
								var i;
								for(i=1;i<=numerofilas;i++){

									var precio_etiqueta = $('#txt_pr_'+i).val();
									var precio_promo = $('#txt_pr_promo_'+i).val();
									var cantidad = $('#txt_ca_'+i).val();

									//alert('etiqueta:'+precio_etiqueta);
									//alert('promo:'+precio_promo);

									if(parseFloat(precio_etiqueta)>parseFloat(precio_promo)){
										$('#txt_t_'+i).val(cantidad*precio_promo);

									}else{
										$('#txt_t_'+i).val(cantidad*precio_etiqueta);
									}

								}
							});	
						</script>
	
						<script>
							$(document).on('change','.select_almacen',function(){

								var fila;
								fila = $(this).data('fila');
								IDMULTIMEDIA = $("#txt_im_"+fila).val();
								$.ajax({
									type: "POST",
									url: "ajax.php",
									data: { PAGINA: 'AJAX', TABLA:'stock_select_almacen',IDMULTIMEDIA: IDMULTIMEDIA,IDALMACEN: $(this).val()}
								})
											
								.done(function(msg){
									$('#select_talla_' + fila).html(msg);
								});		

							});
						</script>

						<script>
							$(document).on('change','#consultar_almacen',function(){

								//esta funcion ubica los numeros de filas dados por la variable fila
								$('#tabla_pedidos tr[data-fila]').each(function() {
									var fila;
									fila = $(this).data('fila');
									//var customerId = $(this).find(".customerIDCell").html();   
									IDMULTIMEDIA = $('#txt_im_'+fila).val();
									
									$.ajax({
										type: "POST",
										url: "ajax.php",
										data: { PAGINA: 'AJAX', TABLA:'stock_select_almacen',IDMULTIMEDIA: IDMULTIMEDIA,IDALMACEN: $("#consultar_almacen").val()}
									})
												
									.done(function(msg){
										
										$('#select_talla_' + fila).html(msg);
									});		 
								 });

							});


						</script>
<?php
}

function fila_tabla($index=0,$row=""){

	if($index>0){
		$indice = $index;

	}else{
		$indice = '"+IDFILA+"';
		$row['CANTIDAD']="1";
	}

	if($row["ARCHIVO"]<>""){
		$imagen_multimedia="<a class='producto-galeria' data-imagen='".URL_UPLOADS."/grande-".$row["ARCHIVO"]."' data-toggle='modal' data-target='#modal-galeria-producto' href='#'><img height='100' src='".URL_UPLOADS."/thumb-".$row["ARCHIVO"]."'></a>";
	}else{
		$imagen_multimedia="";
	}

	$display_multimedia = display_multimedia($indice,$row['IDPRODUCTO']);

	$tallas = tallas($row['IDMULTIMEDIA'],1,'option_stock',$row['TALLA']);

	$class_estado_stock = icono_estado_stock($row['IDSTOCK'],$row['CANTIDAD']);

	$fila = "
		<tr data-fila='$indice'>

			<td class='tabla_codigo'><input class='txt_id input-matriz input-center' type='text' value='".$row['IDPRODUCTO']."' name='IDPRODUCTO[]' id='txt_id_$indice' data-fila='$indice'></td>

			<td class='tabla_descripcion'><input type='text' value='".$row['TITULO']."' name='DESCRIPCION[]' id='txt_p_$indice' class='txt_p  input-matriz'  data-fila='$indice'>
				<div class='cp' id='cp_$indice'>
					<div class='rp' id='rp_$indice'>
					</div>
				</div>
			</td>

			<td><input type='text' value='".$row['IDMULTIMEDIA']."' name='IDMULTIMEDIA[]' id='txt_im_$indice' class='txt_im input-matriz input-center' data-fila='$indice'></td>

			<td class='tabla_color'>
				<div id='txt_m_$indice' class='txt_m'>$imagen_multimedia</div>
				<div class='cm' id='cm_$indice'>
					<div class='rm' id='rm_$indice' tabindex='1' data-fila='$indice'>$display_multimedia</div>
				</div>
			</td>

			<td class='tabla_talla'>
				<select name='TALLA[]' id='select_talla_$indice' class='validar select_talla input-matriz' data-fila='$indice'>$tallas</select>
				<div class='cm' id='cs_$indice'>
					<div class='rm' id='rs_$indice'>

					</div>
				</div>
			</td>

			<td class='tabla_cant'><input type='text' value='".$row['CANTIDAD']."' name='CANTIDAD[]' id='txt_ca_$indice' class='txt_ca input-matriz input-center' data-fila='$indice'></td>
			<td class='tabla_precio'>
					<input type='text' value='".$row['PRECIO']."' name='PRECIO[]' id='txt_pr_$indice' class='txt_pr input-matriz input-center'>
			</td>

			<td class='tabla_precio'><input type='text' value='".$row['PRECIO_PROMO']."' name='PRECIO_PROMO[]' id='txt_pr_promo_$indice' class='validar txt_pr_promo input-matriz input-center' data-fila='$indice'></td>
			<td><input type='text' name='TOTAL[]' id='txt_t_$indice' class='txt_t input-matriz input-center'></td>
			<td><a class='icon_eliminar' href='#'><span class='glyphicon glyphicon-trash'></span></a></td>
			<td><a class='$class_estado_stock' href=''></a></td>
			<input type='hidden' value='".$row['IDSTOCK']."' name='ARRAY_IDSTOCK[]'>
		</tr>";
	return $fila;

}

function display_multimedia($IDFILA,$PARAMETRO,$TIPO=""){

	$db = new mysql();

	switch($TIPO){
		case'UNIQUE':
			$cad = "select * from ayv_multimedia WHERE IDMULTIMEDIA='".$PARAMETRO."'";
			break;
		default:
			$cad = "select * from ayv_multimedia WHERE IDPRODUCTO='".$PARAMETRO."'";
			break;
	}

	$result= $db->consulta($cad);
 
	$cabecera = "<div class='table-responsive'><table class='table table-modelos'>
					<tr>
						<td>COD</td>
						<td>IMAGEN</td>
						<td class='stock_tabla'>Qty</td>
					</tr>
				";

	while($row = $db->recuperar_array($result)){

		$tabla .= "<tr>";
		$tabla .="<td>".$row['IDMULTIMEDIA']."</td>";
		$tabla .="<td><a class='rm_ajax' data-fila='".$IDFILA."' data-archivo='".$row['ARCHIVO']."' data-multimedia='".$row['IDMULTIMEDIA']."' data-codigo='".$row['IDPRODUCTO']."' data-label='".$row['LABEL']."' data-stock='".stock_almacen($row['IDMULTIMEDIA'])."' href='#'><img height='70' src='".URL_UPLOADS."/thumb-".$row['ARCHIVO']."'></a></td>";
		$tabla .="<td class='stock_tabla'>".stock_almacen($row['IDMULTIMEDIA'])."</td>";
		$tabla .= "</tr>";

	}

	$pie = "</table></div>";

	return $cabecera.$tabla.$pie;
}



function tallas($IDMULTIMEDIA,$IDALMACEN="",$option='',$seleccion="",$show_stock=true){

	$db = new mysql();

	$IDPRODUCTO = IdProductoFromIdMultimedia($IDMULTIMEDIA);

	if($IDALMACEN==""){
		$result = $db->consulta("select * from ".PREFIX."stock WHERE IDMULTIMEDIA='".$IDMULTIMEDIA."' AND ESTADO='1'");
	}else{
		$result = $db->consulta("select * from ".PREFIX."stock WHERE IDMULTIMEDIA='".$IDMULTIMEDIA."' AND IDALMACEN='".$IDALMACEN."' AND ESTADO='1'");
	}
	//(2) Obteniendo todas las tallas disponibles del modelo (IDALMACEN) en el almacen
	while($row = $db->recuperar_array($result)){
		$tallas_stock[]		= $row['TALLA'];
	}

	$result_productos = $db->consulta("SELECT * FROM ".PREFIX."productos WHERE IDPRODUCTO = '".$IDPRODUCTO."' limit 1");
	$row_productos = $db->recuperar_array($result_productos);

	//(1) obteniendo patro de tallas
	$tallas_patron = explode(',',$row_productos["TALLAS"]);

	//(3) Obtener las tallas disponibles en almacen y los correspondientes stock de cada tallas

	$tallas_array = elementosrepetidos($tallas_stock,true);

	for($i=0;$i<count($tallas_patron);$i++){

		for($j=0;$j<count($tallas_array);$j++){
			if($tallas_patron[$i]==$tallas_array[$j]['value']){
				$existe = true;
				break;
			}else{
				$existe = false;
			}
		}

		if(($tallas_patron[$i]==$seleccion)){
			$selected = "selected";
		}else{
			$selected = "";
		}

		if($existe){
			if($show_stock){
				$cantidad_stock = "(".$tallas_array[$j]['count'].")";
			}else{
				$cantidad_stock = "";
			}
		}else{
			if($row_productos["OVERSALE"]==1){
				$cantidad_stock = "";
			}else{
				$cantidad_stock = "[Agotado]";
			}
		}

		$option .= "<option $selected value='".$tallas_patron[$i]."'>".$tallas_patron[$i]." ".$cantidad_stock."</option>";

	}

	if($IDMULTIMEDIA>0){
		$desplegable ="<option value=''>Talla</option>".$option;
	}else{
		$desplegable ="<option value=''>Talla</option>";
	}
	return $desplegable;

}


function tallas_web($IDMULTIMEDIA,$IDALMACEN="",$option='',$seleccion="",$show_stock=true){

	$db = new mysql();

	$IDPRODUCTO = IdProductoFromIdMultimedia($IDMULTIMEDIA);

	if($IDALMACEN==""){
		$result = $db->consulta("select * from ".PREFIX."stock WHERE IDMULTIMEDIA='".$IDMULTIMEDIA."' AND ESTADO='1'");
	}else{
		$result = $db->consulta("select * from ".PREFIX."stock WHERE IDMULTIMEDIA='".$IDMULTIMEDIA."' AND IDALMACEN='".$IDALMACEN."' AND ESTADO='1'");
	}
	//(2) Obteniendo todas las tallas disponibles del modelo (IDALMACEN) en el almacen
	while($row = $db->recuperar_array($result)){
		$tallas_stock[]		= $row['TALLA'];
	}

	$result_productos = $db->consulta("SELECT * FROM ".PREFIX."productos WHERE IDPRODUCTO = '".$IDPRODUCTO."' limit 1");
	$row_productos = $db->recuperar_array($result_productos);

	//(1) obteniendo patro de tallas
	$tallas_patron = explode(',',$row_productos["TALLAS"]);

	//(3) Obtener las tallas disponibles en almacen y los correspondientes stock de cada tallas

	$tallas_array = elementosrepetidos($tallas_stock,true);

	for($i=0;$i<count($tallas_patron);$i++){

		for($j=0;$j<count($tallas_array);$j++){
			if($tallas_patron[$i]==$tallas_array[$j]['value']){
				$existe = true;
				break;
			}else{
				$existe = false;
			}
		}

		if(($tallas_patron[$i]==$seleccion)){
			$selected = "selected";
		}else{
			$selected = "";
		}

		if($existe){
			if($show_stock){
				$cantidad_stock = "(".$tallas_array[$j]['count'].")";
			}else{
				$cantidad_stock = "";
			}

			$option .= "<option $selected value='".$tallas_patron[$i]."'>".$tallas_patron[$i]." ".$cantidad_stock."</option>";
			
		}else{
			if($row_productos["OVERSALE"]==1){
				$cantidad_stock = "";
			}else{
				$cantidad_stock = "[Agotado]";
			}
		}

		

	}

	if($IDMULTIMEDIA>0){
		$desplegable ="<option value=''>Talla</option>".$option;
	}else{
		$desplegable ="<option value=''>Talla</option>";
	}
	return $desplegable;

}


function IdProductoFromIdMultimedia($IDMULTIMEDIA){

	$db = new mysql();
	$result = $db->consulta("select * from ".PREFIX."multimedia WHERE IDMULTIMEDIA='".$IDMULTIMEDIA."' limit 1");
	$row = $db->recuperar_array($result);
	return $row["IDPRODUCTO"];
}


function icono_estado_stock($array_stock,$cantidad){

	//$array_stock: stock de la base de datos

	//$cantidad: cantidad que esta en la base de datos

	if($array_stock==0 or $array_stock==""){
		$total_codigos_stock=0;
		$array_stock="";
	}else{
		$IDSTOCK = explode(',',$array_stock);
		$total_codigos_stock = count($IDSTOCK);
	}

	//verificamos si hay stock
	if($total_codigos_stock==$cantidad and $total_codigos_stock>0){
		$class_estado_stock="icon_reserva CANTIDAD_INPUT-".$cantidad." STOCK_MYSQL-".$total_codigos_stock;
	}else{
		//verificamos si hay menos o no hay
		//verificamos si hay menos
		if((($total_codigos_stock>0) AND ($total_codigos_stock<$cantidad)) OR ($cantidad==0)){
			$class_estado_stock="icon_alerta_reserva CANTIDAD_INPUT-".$cantidad." STOCK_MYSQL-".$total_codigos_stock;
		}else{
			//verificamos si no hay
			if($total_codigos_stock==0){
				$class_estado_stock="icon_fuera_reserva CANTIDAD_INPUT-".$cantidad." STOCK_MYSQL-".$total_codigos_stock;
			}
		}
	}

	return $class_estado_stock;
}

function select_envio($IDUSUARIO,$SELECCION=""){

	$db = new mysql();
	$result = $db->consulta("select * from ".PREFIX."direcciones_envio WHERE IDUSUARIO='".$IDUSUARIO."'");

	while($row=$db->recuperar_array($result)){
		if($row["IDENVIO"]==$SELECCION){
			$option .= "<option selected value='".$row["IDENVIO"]."'>".$row["CONSIGNATARIO"]." --- ".$row["DIRECCION"]."</option>";
		}else{
			$option .= "<option value='".$row["IDENVIO"]."'>".$row["DIRECCION"]." --- ".$row["CONSIGNATARIO"]."</option>";
		}
	}

	return $option;
}


function show_datos_envio($IDENVIO){

	$db = new mysql();

	$query ="
				SELECT * FROM ayv_direcciones_envio
					INNER JOIN ayv_localidad_distritos
						ON ayv_direcciones_envio.IDDISTRITO = ayv_localidad_distritos.IDDISTRITO
					INNER JOIN ayv_localidad_provincias
						ON ayv_direcciones_envio.IDPROVINCIA = ayv_localidad_provincias.IDPROVINCIA
					INNER JOIN ayv_localidad_departamentos
						ON ayv_direcciones_envio.IDDEPARTAMENTO = ayv_localidad_departamentos.IDDEPARTAMENTO
					WHERE IDENVIO='".$IDENVIO."'
				limit 1
	";

	$result_envio = $db->consulta($query) or die(mysql_error());

	$row= $db->recuperar_array($result_envio);



	echo "<p><strong>CONSIGNATARIO: ".$row["CONSIGNATARIO"]."</strong></p>";
	echo "<p><strong>DNI: </strong>".$row["DNI"]."</p>";
	echo "<p><strong>DIRECCION: </strong>".$row["DIRECCION"]."</p>";
	echo "<p><strong></strong>".$row["NOMBREDISTRITO"]."</p>";
	echo "<p><strong></strong>".$row["NOMBREPROVINCIA"]."</p>";
	echo "<p><strong></strong>".$row["NOMBREDEPARTAMENTO"]."</p>";
	echo "<p><strong>REFERENCIA: </strong>".$row["REFERENCIA"]."</p>";
	echo "<p><strong>TELEFONO / CELULAR: </strong>".$row["TELEFONO"]." / ".$row["CELULAR"]."</p>";
	echo "<p><strong>COORDENADAS: </strong>".$row["COORDENADAS"]."</p>";
}

function show_datos_factu($IDFACTURACION){

	$db = new mysql();

	$query ="
				SELECT * FROM ayv_direcciones_facturacion
					WHERE IDFACTURACION='".$IDFACTURACION."'
				limit 1
	";


	$result_envio = $db->consulta($query) or die(mysql_error());

	$row= $db->recuperar_array($result_envio);

	echo "<p><strong>RAZON SOCIAL: ".$row["RAZONSOCIAL"]."</strong></p>";
	echo "<p><strong>RUC / DNI: </strong>".$row["RUC"]."</p>";
	echo "<p><strong>DIRECCION: </strong>".$row["DIRECCION"]."</p>";
	echo "<p><strong></strong>".$row["NOMBREDISTRITO"]."</p>";
	echo "<p><strong></strong>".$row["NOMBREPROVINCIA"]."</p>";
	echo "<p><strong></strong>".$row["NOMBREDEPARTAMENTO"]."</p>";

}

function select_factu($IDUSUARIO,$SELECCION=""){

	$db = new mysql();
	$result = $db->consulta("select * from ".PREFIX."direcciones_facturacion WHERE IDUSUARIO='".$IDUSUARIO."'");

	while($row=$db->recuperar_array($result)){
		if($row["IDENVIO"]==$SELECCION){
			$option .= "<option selected value='".$row["IDENVIO"]."'>".$row["CONSIGNATARIO"]."</option>";
		}else{
			$option .= "<option value='".$row["IDFACTURACION"]."'>".$row["RAZONSOCIAL"]."</option>";
		}
	}

	return $option;
}

function horain(){

	for($i=10;$i<22;$i++){
		$hora["$i:00:00"]="$i:00:00";
	}

	return $hora;
}

function repartidor($ID=''){
	$db = new mysql();

	if($ID>0){
		$result = $db->consulta("select * from ayv_repartidores WHERE IDREPARTIDOR='$ID' LIMIT 1");
		$row = $db->recuperar_array($result);
		return $row;
	}else{
		$result = $db->consulta("select * from ayv_repartidores limit 20");
		while($row = $db->recuperar_array($result)){
			$repartidor[$row['IDREPARTIDOR']]=$row['NOMBRE_REPARTIDOR'];
		}
		return $repartidor;
	}
}


function imagen_principal($IDPRODUCTO,$IDMULTIMEDIA='',$tipo){
	$db = new mysql();
	if($IDMULTIMEDIA>0){
		$result=$db->consulta("select * from ".PREFIX."multimedia WHERE IDMULTIMEDIA='".$IDMULTIMEDIA."'LIMIT 1");
	}else{
		$result=$db->consulta("select * from ".PREFIX."multimedia WHERE IDPRODUCTO='".$IDPRODUCTO."' AND DEFECTO='1' LIMIT 1");
	}

	$row = $db->recuperar_array($result);

	switch($tipo){
		case'thumb':
			return URL_UPLOADS."/thumb-".$row['ARCHIVO'];
			break;
		case'mediano':
			return URL_UPLOADS."/mediano-".$row['ARCHIVO'];
			break;
		case'grande':
			return URL_UPLOADS."/grande-".$row['ARCHIVO'];
			break;
		default:
			return URL_UPLOADS."/mediano-".$row['ARCHIVO'];
			break;
	}
}



function imagen_proyecto($IDPROYECTO,$IDMEDIA='',$tipo){
	$db = new mysql();
	if($IDMEDIA>0){
		$result=$db->consulta("select * from ".PREFIX."proyectos_multimedia WHERE IDMEDIA='".$IDMEDIA."'LIMIT 1");
	}else{
		$result=$db->consulta("select * from ".PREFIX."proyectos_multimedia WHERE IDPROYECTO='".$IDPROYECTO."' AND DEFECTO='1' LIMIT 1");
	}

	$row = $db->recuperar_array($result);

	switch($tipo){
		case'thumb':
			return URL_UPLOADS."/thumb-".$row['ARCHIVO'];
			break;
		case'mediano':
			return URL_UPLOADS."/mediano-".$row['ARCHIVO'];
			break;
		case'grande':
			return URL_UPLOADS."/grande-".$row['ARCHIVO'];
			break;
		default:
			return URL_UPLOADS."/mediano-".$row['ARCHIVO'];
			break;
	}
}

function SkuFromID($parametro){
	//para generar un sku de producto usare el mes y el dia que se publico el producto
	$db = new mysql();
	
	$result = $db->consulta("SELECT IDPRODUCTO,FECHA FROM ".PREFIX."productos WHERE IDPRODUCTO='".$parametro."' LIMIT 1");
	$row = $db->recuperar_array($result);	
	$sku = $row['PRESKU'].$parametro;
	return $sku;
}

function IDFromSku($parametro){
	$ID = substr($parametro,3,strlen($parametro));
	return $ID;
}

function carrito(){
	return count($_SESSION['IDMULTIMEDIA']);
}


function aplicar_promo($IDPRODUCTO,$tipo_promo){
	
	$db = new mysql();	
	
	switch($tipo_promo['TIPO_PROMO']){
		
		case'SINGLE':
			$result 		 = $db->consulta("SELECT * FROM ".PREFIX."productos WHERE IDPRODUCTO='".$IDPRODUCTO."' LIMIT 1");
			$row 			 = $db->recuperar_array($result);
			$precio_x_unidad = $row['PRECIO'];
		break;
		
		case'PROMOCION':
			$result = $db->consulta("SELECT * FROM ".PREFIX."promociones WHERE IDPRODUCTO='' LIMIT 1");
		break;
		
		case'PAQUETE':
			$result = $db->consulta("SELECT * FROM ".PREFIX."productos WHERE IDPRODUCTO='".$IDPRODUCTO."' LIMIT 1");
			$row = $db->recuperar_array($result);
			
			$paquetes_totales = $row['PRECIO_PAQUETES'];
			
			$paquetes_individuales = explode(':',$paquetes_totales);
			
			for($i=0;$i<count($paquetes_individuales);$i++){
				$elementos = explode('x',$paquetes_individuales[$i]);
				if($elementos[0]==$tipo_promo['CANTIDAD']){
					$precio_x_unidad = $elementos[1];
					break;
				}else{
					$precio_x_unidad = false;
				}
			}
			
			if($precio_x_unidad==false){
				$precio_x_unidad =$row['PRECIO'];
			}
			
		break;
	}
	

	return $precio_x_unidad;
	
}

function tipo_promo($IDMULTIMEDIA){

	$total_item_sub_fila = count($IDMULTIMEDIA);
		
	if($total_item_sub_fila==1){
		$tipo_paquete = 'SINGLE';
	}else{
		if($total_item_sub_fila>1){
			
			$patron = IdProductoFromIdMultimedia($IDMULTIMEDIA[0]);
			
			for($i=0;$i<count($IDMULTIMEDIA);$i++){
				if($patron == IdProductoFromIdMultimedia($IDMULTIMEDIA[$i])){
					
					//echo IdProductoFromIdMultimedia($IDMULTIMEDIA[$i]);
					
					$nose_repite = true;
				}else{
					$nose_repite = false;
					break;
				}
			}

			if($nose_repite){
				$tipo_paquete = 'PAQUETE';
			}else{
				$tipo_paquete = 'PROMOCION';
			}
				
		}
	}
	
	
	$array = array('TIPO_PROMO'=>$tipo_paquete,'CANTIDAD'=>$total_item_sub_fila);

	return $array;
}

function bolsa(){

	session_start();

	$total_seleccionados = count($_POST['seleccionados']);
	$total_en_bolsa = count($_SESSION['IDMULTIMEDIA']);

	//si enviamos mediante post
	if($total_seleccionados>0){
		if($total_en_bolsa>0){
			//la bolsa tiene elementos
				
			$k = $total_en_bolsa;
			for($i=0;$i<$total_seleccionados;$i++){
				$_SESSION['IDMULTIMEDIA'][$k]=$_POST['seleccionados'][$i];
				$k++;
			}
		}else{
			//la bolsa esta vacia
			$_SESSION['IDMULTIMEDIA']=$_POST['seleccionados'];
		}
	}

	$_SESSION['IDMULTIMEDIA'] = array_values(array_unique($_SESSION['IDMULTIMEDIA']));

	//test_array($_SESSION['IDMULTIMEDIA']);

}



function jquery_depas(){
	?>

<script>
						$(document).ready(function(){
							
							$('#get_departamento').change(function(){
								
								//$('#get_provincias').html("cadenadetext");
								
								//cambiar_localidad_ajax('session_departamento',$(this).val());
								
								$.ajax({
									type: "POST",
									url: "<?php echo get_option('home'); ?>/procesar/",
									data: { TIPO: 'DISTRITOS', CASO:'localidades',ID: $(this).val(), SELECCION: 'provincia' }
								})
								
								.done(function(msg){
									$('#get_provincias').prop('selectedIndex',0);
									$('#get_distritos').prop('selectedIndex',0);
									$('#get_provincias').html(msg);
								})

								.fail(function( jqXHR, textStatus, errorThrown) {
									alert(jqXHR.status);
								});
								
								
								
							})
							
							$('#get_provincias').change(function(){
								
								//cambiar_localidad_ajax('session_provincia',$(this).val());		
									
								$.ajax({
									type: "POST",
									url: "<?php echo get_option('home'); ?>/procesar",
									data: { TIPO: 'DISTRITOS', CASO:'localidades',ID: $(this).val(), SELECCION: 'distritos' }
								})
								
								.done(function(msg){
									$('#get_distritos').prop('selectedIndex',0);
									$('#get_distritos').html(msg);
								});
								
							})					
						});
					</script>

<?php

}


function carrito_compras(){
	?>
		<script>
						
			$(document).on('click','.icon_eliminar',function(){
			
				$.ajax({
					type: "POST",
					url: "<?php echo theme(); ?>/ajax.php",
					data: { PAGINA: 'AJAX', TABLA:'elimiar_elemento_carrito',FILA: $(this).data('idfila')}
				})
										
				.done(function(msg){
					$('.mensaje_system').html(msg);
				});	

				var tr = $(this).closest('ul');
				tr.css("background-color","#6A6A6A");
				tr.fadeOut(400, function(){
					tr.remove();
				}); 
					
				return false;

			});

		</script>

		<?php 

			$carrito = count($_SESSION["IDMULTIMEDIA"]);
			
			if($carrito>0){ 

				//echo"<div class='mensaje_system'>Tienes ".count($_SESSION["IDMULTIMEDIA"])." productos en tu carrito</div>";

				echo "<div class='table_cart'>";
		
					//<td class='descripcion_tabla'>Descripcion</td>
					echo"
						<ul>

							<li class='eliminar_tabla'>Del</li>
							<li class='codigo_tabla'>#</li>
							<li class='codigo_tabla'>#</li>
							<li class='cantidad_tabla'>Cant.</li>
							<li class='imagen_tabla'></li>
							<li class='descripcion_tabla'>Descripcion</li>
							<li class='talla_tabla'>Talla</li>
							
							<li class='precio_tabla'>Precio</li>
						</ul>
					";

					echo "<div class='separador'>";
					
				for($i=0;$i<count($_SESSION["IDMULTIMEDIA"]);$i++){

					echo '<input type="hidden" name="IDMULTIMEDIA[]" value="'.$_SESSION['IDMULTIMEDIA'][$i].'">';
					echo "<ul>";					
						echo "<li class='eliminar_tabla'><a class='icon_eliminar' data-idfila='".$_SESSION['IDMULTIMEDIA'][$i]."'href=''></a></li>";
						echo "<li class='codigo_tabla text_descripcion_tabla'>".$_SESSION["IDMULTIMEDIA"][$i]."</li>";
						echo "<li class='codigo_tabla text_descripcion_tabla'>".IdProductoFromIdMultimedia($_SESSION["IDMULTIMEDIA"][$i])."</li>";
						echo "<li class='cantidad_tabla'><input type='text' name='CANTIDAD[]' value='1'></li>";
						echo "<li class='imagen_tabla'><a class='zoom' href='".imagen_multimedia($_SESSION["IDMULTIMEDIA"][$i])."'><img src='".imagen_multimedia($_SESSION["IDMULTIMEDIA"][$i])."'></a></li>";
						
						echo "<li class='descripcion_tabla text_descripcion_tabla'>".label_multimedia($_SESSION['IDMULTIMEDIA'][$i])."</li>";
						echo "<li class='talla_tabla'>";
							echo "<select class='talla_multimedia validar_campo' data-IDMULTIMEDIA='".$_SESSION['IDMULTIMEDIA'][$i]."' name='TALLA[]'>".tallas($_SESSION['IDMULTIMEDIA'][$i],'','','',false)."</select>";
						echo "</li>";
						echo "<li class='precio_tabla'>".formato_moneda(precio_multimedia($_SESSION["IDMULTIMEDIA"][$i]))."</li>";
					echo "</ul>";

					$total_cart += precio_multimedia($_SESSION["IDMULTIMEDIA"][$i]);
					
					$numero_parte[] = IdProductoFromIdMultimedia($_SESSION["IDMULTIMEDIA"][$i]);
				}	

				echo "</div>";
				
				echo "</div>";
			}
			
			
			test_array($_SESSION["IDMULTIMEDIA"]);
			test_array(contar_elementos_repetidos($numero_parte,true));	
		

		?>
<?php
}


function distritos_permitidos($PROVINCIA,$EXCLUIDOS=""){

	$db = new mysql();

	$result = $db->consulta("SELECT * FROM ".PREFIX."localidad_provincias WHERE NOMBREPROVINCIA='".$PROVINCIA."' LIMIT 1");

	$row = $db->recuperar_array($result);
	$result_distritos = $db->consulta("SELECT * FROM ".PREFIX."localidad_distritos WHERE IDPROVINCIA='".$row["IDPROVINCIA"]."'");

	while($row_distritos = $db->recuperar_array($result_distritos)){

		for($i=0;$i<count($EXCLUIDOS);$i++){
			if($EXCLUIDOS[$i]==$row_distritos["IDDISTRITO"]){
				$existe = true;
				break;
			}else{
				$existe = false;
			}
		}

		if($existe){
			$array .= '';

		}else{
			$array .= '"'.$row_distritos["IDDISTRITO"].'",';
		}


	}

	return substr($array, 0, -1);

}


function imagen_multimedia($ID,$tipo='thumb'){

	global $AYV;

	$db = new mysql();

	$result=$db->consulta("select * from ".PREFIX."multimedia WHERE IDMULTIMEDIA='".$ID."' LIMIT 1");

	$row=$db->recuperar_array($result);

	switch($tipo){
		case'thumb':
			return URL_UPLOADS."/thumb-".$row['ARCHIVO'];
			break;
		case'mediano':
			return URL_UPLOADS."/mediano-".$row['ARCHIVO'];
			break;
		case'grande':
			return URL_UPLOADS."/grande-".$row['ARCHIVO'];
			break;
		default:
			return URL_UPLOADS."/".$row['ARCHIVO'];
			break;
	}

}

function label_multimedia($ID){

	global $AYV;
	$db 		= 	new mysql();
	$result 	= 	$db->consulta("select * from ".PREFIX."multimedia WHERE IDMULTIMEDIA='".$ID."' LIMIT 1");
	$row 		= 	$db->recuperar_array($result);
	return $row['LABEL'];

}

function precio_multimedia($IDMULTIMEDIA){
	$db = new mysql();
	$IDPRODUCTO = IdProductoFromIdMultimedia($IDMULTIMEDIA);
	$result 	= $db->consulta("select * from ".PREFIX."productos WHERE IDPRODUCTO='".$IDPRODUCTO."' limit 1");
	$row 		= $db->recuperar_array($result);
	return $row["PRECIO"];
}

function get_distritos($caso,$ID='',$SELECTED=''){

	global $AYV;
	$db = new mysql();

	switch($caso){
		case'departamento':
			$result=$db->consulta("select * from ".PREFIX."localidad_departamentos");
			while($row=$db->recuperar_array($result)){
				$array[$row['IDDEPARTAMENTO']]=$row['NOMBREDEPARTAMENTO'];
			}
			break;

		case'provincia':

			$result=$db->consulta("select * from ".PREFIX."localidad_provincias WHERE IDDEPARTAMENTO='".$ID."'");
			while($row=$db->recuperar_array($result)){
				$array[$row['IDPROVINCIA']]=$row['NOMBREPROVINCIA'];
			}
				
			//print_r($array);
			break;

		case'distritos':
			$result=$db->consulta("select * from ".PREFIX."localidad_distritos WHERE IDPROVINCIA='".$ID."'");
			while($row=$db->recuperar_array($result)){
				$array[$row['IDDISTRITO']]=$row['NOMBREDISTRITO'];
			}
			break;
	}

	//echo $db->contar_consulta($result);

	echo "<option value=''>Seleccione</option>".generar_lista_departamento($array,$SELECTED);

}

function get_localidades($caso,$ID='',$SELECTED=''){

	global $AYV;
	
	$db = new mysql();

	switch($caso){
		case'departamentos':
			$result=$db->consulta("select * from ".PREFIX."localidad_departamentos");
			while($row=$db->recuperar_array($result)){
				$array[$row['IDDEPARTAMENTO']]=$row['NOMBREDEPARTAMENTO'];
			}
			//print_r($array);
		break;

		case'provincias':

			$result=$db->consulta("select * from ".PREFIX."localidad_provincias WHERE IDDEPARTAMENTO='".$ID."'");
			while($row=$db->recuperar_array($result)){
				$array[$row['IDPROVINCIA']]=$row['NOMBREPROVINCIA'];
			}

			//print_r($array);
		break;

		case'distritos':
			$result=$db->consulta("select * from ".PREFIX."localidad_distritos WHERE IDPROVINCIA='".$ID."'");
			while($row=$db->recuperar_array($result)){
				$array[$row['IDDISTRITO']]=$row['NOMBREDISTRITO'];
			}
		break;
	}

	//echo $db->contar_consulta($result);

	echo "<option value=''>Seleccione</option>".generar_lista_departamento($array,$SELECTED);

}

function generar_lista_departamento($array,$selected=''){


	$keys= array_keys($array);
	$k=0;

	foreach($array as $campo){

		if($selected==$keys[$k]){
			$options.="<option selected value='".$keys[$k]."'>".$array[$keys[$k]]."</option>";
		}else{
			$options.="<option value='".$keys[$k]."'>".$array[$keys[$k]]."</option>";
		}

		$k++;

	}

	return $options;
}


function cargar_archivos_directorio($ruta,$url){
	//echo $ruta[0];
	//$ruta = array(DIR_CORE.'/funciones',DIR_CORE.'/clases');
	
	/*
	$ruta[0]=DIR_CORE."/funciones";
	$ruta[1]=DIR_CORE."/clases";
	*/
	
	for($i=0;$i<count($ruta);$i++){
	
		$dir=opendir($ruta[$i]);
		while(false !== ($archivo=readdir($dir))){
			if($archivo !="." && $archivo != ".."){
				$link=$ruta[$i]."/".$archivo;
				if(file_exists($link)){
					$archivos[] = $url[$i]."/".$archivo;
				}else{
					echo"El archivo ".$link." No existe <br />";
				}
			}
		}
	
	}
	
	sort($archivos);
	
	return $archivos;
}



function the_permanlink($parametro,$adicional=''){
	$link	=	conectarse();
	$result =	$db->consulta("select * from ".PREFIX."productos WHERE IDPRODUCTO='".$parametro."' LIMIT 1");
	$row	=	$db->recuperar_array($result);
	//return get_option('home')."/".$row['URL']."/".$parametro;
	if($adicional<>""){
		return get_option('home')."/".$adicional."/".$parametro;
	}else{
		
		$fecha 		= $row['FECHA'];
		$fecha_hora = explode(' ',$fecha);
		
		$fecha 		= $fecha_hora[0];
		$hora 		= $fecha[1];
		
		$array_fecha 	= explode('-',$fecha);
		$array_hora 	= explode(':',$hora);
	
		return get_option('home')."/item/".$parametro;
	}
}

function costos_envio($defecto="22.50",$distrito){
		$link 	= conectarse();
		$result = $db->consulta("SELECT * FROM ".PREFIX."localidad_distritos WHERE IDDISTRITO='".$distrito."' LIMIT 1");
		$row 	= $db->recuperar_array($result);
		
		if($row>0){
			return $row['COSTO_ENVIO'];
		}else{
			return $defecto;
		}
}

function tamanos_imagenes(){
	$imagen['thumb']=150;
	$imagen['mediano']=300;
	$imagen['grande']=800;
	return $imagen;
}


function uploadarchivos($fileupload,$opcional=''){

	// obtenemos los datos del archivo

	global $AYV;

	$tamano 	= $_FILES[$fileupload]['size'];
	$tipo		= $_FILES[$fileupload]['type'];
	$archivo	= $_FILES[$fileupload]['name'];

	if($opcional<>""){
		$prefijo	= $opcional."-".substr(md5(uniqid(rand())),0,6);
	}else{
		$prefijo	= substr(md5(uniqid(rand())),0,6);
	}

	$extencion	=	extension($archivo);
	$nombrereal	=	str_replace(".".$extencion,"",$archivo);
	$archivo	=	obtener_url($nombrereal);
	$archivo	=	$archivo.".".$extencion;

	if ($archivo != ""){
		// guardamos el archivo a la carpeta files
		$destino =  DIR_UPLOADS."/";
		$url_global = URL_UPLOADS."/";
		//echo"<br>$destino<br>";
		if (move_uploaded_file($_FILES[$fileupload]['tmp_name'],$destino.$prefijo."_".$archivo)) {
			//http://localhost/almacen/uploads/1d24e0_chrysanthemum.jpg
			//  C:xampp ???mpphpC666.tmp
				
			if(copy(get_option('home')."/core/r.php?anchura=150&hmax=150&imagen=".$url_global.$prefijo."_".$archivo,$destino."/thumb-".$prefijo."_".$archivo)){
				echo"Copiado";
				if(copy(get_option('home')."/core/r.php?anchura=200&hmax=200&imagen=".$url_global.$prefijo."_".$archivo,$destino."/mediano-200-".$prefijo."_".$archivo)){
					if(copy(get_option('home')."/core/r.php?anchura=250&hmax=250&imagen=".$url_global.$prefijo."_".$archivo,$destino."/mediano-250-".$prefijo."_".$archivo)){
						if(copy(get_option('home')."/core/r.php?anchura=300&hmax=300&imagen=".$url_global.$prefijo."_".$archivo,$destino."/mediano-".$prefijo."_".$archivo)){
							echo"Copiado";
							if(copy(get_option('home')."/core/r.php?anchura=800&hmax=800&imagen=".$url_global.$prefijo."_".$archivo,$destino."/grande-".$prefijo."_".$archivo)){
								echo"Copiado";
							}
						}
					}
				}
			}
				
				
				
			return $prefijo."_".$archivo;
				
			//$text = get_option('home')."/core/r.php?anchura=150&hmax=150&imagen=".$AYV['url_global']['uploads'].$prefijo."_".$archivo;
				
			//return $text;
				
		} else {
			//echo"Fracaso, Archivo no copiado.<br><br>";
			//$men="N1";
			//return $destino.$prefijo."_".$archivo;
			return false;
		}
	} else {
		//$men="N2";
		//return $men;
		return false;
	}
}


function uploadfiles($fileupload,$opcional=''){

	
	$imagen = tamanos_imagenes();
	// obtenemos los datos del archivo

	global $AYV;

	$tamano 	= $_FILES['UPLOAD_FILE']['size'][$fileupload];
	$tipo		= $_FILES['UPLOAD_FILE']['type'][$fileupload];
	$archivo	= $_FILES['UPLOAD_FILE']['name'][$fileupload];
	$temp		= $_FILES['UPLOAD_FILE']['tmp_name'][$fileupload];

	if($opcional<>""){
		$prefijo	= $opcional."-".substr(md5(uniqid(rand())),0,6);
	}else{
		$prefijo	= date('Ymd').substr(md5(uniqid(rand())),0,10);
	}

	$extencion	=	extension($archivo);
	$nombrereal	=	str_replace(".".$extencion,"",$archivo);
	$archivo	=	obtener_url($nombrereal);
	$archivo	=	$archivo.".".$extencion;

	if ($archivo != ""){
		// guardamos el archivo a la carpeta files
		$destino =  DIR_UPLOADS."/";
		$url_global = URL_UPLOADS."/";
		//echo"<br>$destino<br>";
		if (copy($temp,$destino.$prefijo."_".$archivo)) {
			//http://localhost/almacen/uploads/1d24e0_chrysanthemum.jpg
			//  C:xampp ???mpphpC666.tmp
				
			if(copy(get_option('home')."/core/r.php?anchura=".$imagen['thumb']."&hmax=".$imagen['thumb']."&imagen=".$url_global.$prefijo."_".$archivo,$destino."/thumb-".$prefijo."_".$archivo)){
				//echo"Copiado";
				if(copy(get_option('home')."/core/r.php?anchura=".$imagen['mediano']."&hmax=".$imagen['mediano']."&imagen=".$url_global.$prefijo."_".$archivo,$destino."/mediano-".$prefijo."_".$archivo)){
					//echo"Copiado";
					if(copy(get_option('home')."/core/r.php?anchura=".$imagen['grande']."&hmax=".$imagen['grande']."&imagen=".$url_global.$prefijo."_".$archivo,$destino."/grande-".$prefijo."_".$archivo)){
						//echo"Copiado";
					}
				}
			}
				
				
				
			return $prefijo."_".$archivo;
				
			//$text = get_option('home')."/core/r.php?anchura=150&hmax=150&imagen=".$AYV['url_global']['uploads'].$prefijo."_".$archivo;
				
			//return $text;
				
		} else {
			//echo"Fracaso, Archivo no copiado.<br><br>";
			//$men="N1";
			//return $destino.$prefijo."_".$archivo;
			return false;
		}
	} else {
		//$men="N2";
		//return $men;
		return false;
	}
}

function upload_files_array($fileupload,$tabla,$opcional=''){

	$imagen = tamanos_imagenes();
	// obtenemos los datos del archivo

	global $AYV;

	$tamano 	= $_FILES['UPLOAD_FILE']['size'][$tabla][$fileupload];
	$tipo		= $_FILES['UPLOAD_FILE']['type'][$tabla][$fileupload];
	$archivo	= $_FILES['UPLOAD_FILE']['name'][$tabla][$fileupload];
	$temp		= $_FILES['UPLOAD_FILE']['tmp_name'][$tabla][$fileupload];

	if($opcional<>""){
		$prefijo	= $opcional."-".substr(md5(uniqid(rand())),0,6);
	}else{
		$prefijo	= date('Ymd').substr(md5(uniqid(rand())),0,10);
	}

	$extencion	=	extension($archivo);
	$nombrereal	=	str_replace(".".$extencion,"",$archivo);
	$archivo	=	obtener_url($nombrereal);
	$archivo	=	$archivo.".".$extencion;

	if ($archivo != ""){
		// guardamos el archivo a la carpeta files
		$destino =  DIR_UPLOADS."/";
		$url_global = URL_UPLOADS."/";
		//echo"<br>$destino<br>";
		if (copy($temp,$destino.$prefijo."_".$archivo)) {
			//http://localhost/almacen/uploads/1d24e0_chrysanthemum.jpg
			//  C:xampp ???mpphpC666.tmp
				
			if(copy(get_option('home')."/core/r.php?anchura=".$imagen['thumb']."&hmax=".$imagen['thumb']."&imagen=".$url_global.$prefijo."_".$archivo,$destino."/thumb-".$prefijo."_".$archivo)){
				//echo"Copiado";
				if(copy(get_option('home')."/core/r.php?anchura=".$imagen['mediano']."&hmax=".$imagen['mediano']."&imagen=".$url_global.$prefijo."_".$archivo,$destino."/mediano-".$prefijo."_".$archivo)){
					//echo"Copiado";
					if(copy(get_option('home')."/core/r.php?anchura=".$imagen['grande']."&hmax=".$imagen['grande']."&imagen=".$url_global.$prefijo."_".$archivo,$destino."/grande-".$prefijo."_".$archivo)){
						//echo"Copiado";
					}
				}
			}
				
				
				
			return $prefijo."_".$archivo;
				
			//$text = get_option('home')."/core/r.php?anchura=150&hmax=150&imagen=".$AYV['url_global']['uploads'].$prefijo."_".$archivo;
				
			//return $text;
				
		} else {
			//echo"Fracaso, Archivo no copiado.<br><br>";
			//$men="N1";
			//return $destino.$prefijo."____".$archivo;
			//$men="N1";
			//return $men;
			return false;
		}
	} else {
		//$men="N2";
		//return $men;
		return false;
	}
}


function comprobar_stock($IDMULTIMEDIA,$TALLA,$CANTIDAD=1){
	$db = new mysql();

	$cad = "SELECT * FROM ".PREFIX."stock WHERE ESTADO='1' AND IDMULTIMEDIA='".$IDMULTIMEDIA."' AND TALLA='".$TALLA."'LIMIT ".$CANTIDAD;

	$result = $db->consulta($cad);

	$enstock = $db->contar_consulta($result);

	//echo $enstock;
	if($enstock>0){
		while($row = $db->recuperar_array($result)){
			$ARRAY_STOCK[]=$row["IDSTOCK"];
		}
		return $ARRAY_STOCK;
	}
	else{
		return false;
	}
}

function reservar_producto($IDSTOCK){
	$db = new mysql();
	$db->consulta("UPDATE ".PREFIX."stock SET ESTADO='RESERVADO' WHERE IDSTOCK='".$IDSTOCK."' LIMIT 1");
}

function liberar_reserva_producto($IDSTOCK){
	$db = new mysql();
	$db->consulta("UPDATE ".PREFIX."stock SET ESTADO='1' WHERE IDSTOCK='".$IDSTOCK."' LIMIT 1");
}

function distrito($ID){
	$db = new mysql();
	$result = $db->consulta("select * from ".PREFIX."localidad_distritos WHERE IDDISTRITO='$ID' LIMIT 1");
	$row = $db->recuperar_array($result);
	return $row['NOMBREDISTRITO'];
}


function provincia($ID){
	$db = new mysql();
	$result = $db->consulta("select * from ".PREFIX."localidad_provincias WHERE IDPROVINCIA='$ID' LIMIT 1");
	$row = $db->recuperar_array($result);
	return $row['NOMBREPROVINCIA'];
}

function departamento($ID){
	$db = new mysql();
	$result = $db->consulta("select * from ".PREFIX."localidad_departamentos WHERE IDDEPARTAMENTO='$ID' LIMIT 1");
	$row = $db->recuperar_array($result);
	return $row['NOMBREDEPARTAMENTO'];
}


function categorias_form($parent='0',$prefix='-',$seleccion='0'){

	$db 		= new mysql();
	$result 	= $db->consulta("select * from ".PREFIX."productos_categorias where PARENT=".$parent." ORDER BY POSICION");

	$total=$db->contar_consulta($result);

	if($total>0){
		/*Recorrer todos las entradas */

		while($arr=$db->recuperar_array($result)){
			/* Imprimir campo a mostrar*/

			if($arr['IDCATEGORIA']==$seleccion){
				echo"<option selected value='".$arr['IDCATEGORIA']."'>".$prefix.$arr['LABEL']."</option>";
			}else{
				echo"<option value='".$arr['IDCATEGORIA']."'>".$prefix.$arr['LABEL']."</option>";
			}

			/* imprimir arbol the "hijos" de este elemento*/
			categorias_form($arr['IDCATEGORIA'],$prefix.$prefix,$seleccion);
		}
	}
}

function get_id_categoria_padre($ID){
	
	$db 	= new mysql();
	$result = $db->consulta("SELECT * FROM ".PREFIX."productos_categorias WHERE IDCATEGORIA='".$ID."' LIMIT 1");	
	$row 	= $db->recuperar_array($result);
	return $row['PARENT'];
}

function get_label_categoria_padre($ID){

	$db 	= new mysql();
	$result = $db->consulta("SELECT * FROM ".PREFIX."productos_categorias WHERE IDCATEGORIA='".$ID."' LIMIT 1");
	$row 	= $db->recuperar_array($result);
	return $row['LABEL'];
}


function formato_fecha($fecha,$tipo=''){

	$cad = explode(" ",$fecha);
	$fecha = explode("-",$cad[0]);
	
	switch($tipo){
		case'mes':
			switch($fecha[1]){
				case'01':
					$mes = "Enero";
				break;		
				case'02':
					$mes = "Febrero";
				break;		
				case'03':
					$mes = "Marzo";
				break;		
				case'04':
					$mes = "Abril";
				break;		
				case'05':
					$mes = "Mayo";
				break;		
				case'06':
					$mes = "Junio";
				break;		
				case'07':
					$mes = "Julio";
				break;		
				case'08':
					$mes = "Agosto";
				break;		
				case'09':
					$mes = "Setiembre";
				break;		
				case'10':
					$mes = "Octubre";
				break;		
				case'11':
					$mes = "Noviembre";
				break;		
				case'12':
					$mes = "Diciembre";
				break;
			}
			
			return $fecha[2]." de ".$mes." del ".$fecha[0];		
		break;
		default:
			return $fecha[2]."-".$fecha[1]."-".$fecha[0];
		break;
	}
	
}	

?>