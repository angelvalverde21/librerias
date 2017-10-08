<?php

class carrito{
	
	function __construct(){

		session_start();

		if($_POST['seleccionados'] AND $_POST['tallas'] AND $_POST['config']){
			
			$_SESSION['CARRITO']['IDMULTIMEDIA']	= $_POST['seleccionados'];
			$_SESSION['CARRITO']['TALLAS']			= $_POST['tallas'];
			$_SESSION['CARRITO']['CONFIG']			= $_POST['config'];		
			//echo "Sesion iniciada correctamente<br />";

		}

		if(isset($_SESSION['CARRITO']['IDMULTIMEDIA']) AND isset($_SESSION['CARRITO']['TALLAS']) AND isset($_SESSION['CARRITO']['CONFIG'])){
			$this->array_items	= $_SESSION['CARRITO']['IDMULTIMEDIA'];
			$this->array_tallas	= $_SESSION['CARRITO']['TALLAS'];
			$this->array_config	= $_SESSION['CARRITO']['CONFIG'];	
			//echo "Ya se ha iniciado sesion";			
		}else{
				//echo "No hay sessiones iniciadas";	
		}

		//test_array($_SESSION);

	}
	

	function vaciar(){
		//session_start();
		//$_SESSION['CARRITO'] = array();			
	}

	function mostrar(){
		?>
			<table class="table table-bordered">
				<tbody>
					<tr class="">
						<td class="">#</td>
						<td class="">Qty</td>
						<td class="">Producto</td>
						<td class="">Talla</td>
						<td class="">Precio</td>
					</tr>	

					
						
					<?php for($i=0;$i<count($this->array_items);$i++){ ?>

					<?php $codigo = $this->array_items[$i]; ?>

					<tr class="">

						<td class=""><?php echo $codigo; ?></td>
						<td class=""><?php echo 1; ?></td>
						<td class=""><?php echo "<img width='75' src='".imagen_multimedia($codigo)."'>"; ?></td>
						<td class=""><?php echo $this->array_tallas[$codigo]; ?></td>
						<td class=""><?php echo precio_multimedia($codigo); ?></td>	

					</tr>

					<?php } ?>
				</tbody>
			</table>

		<?php		
	}

	function get_paquetes(){
	
		$key_grupo = get_key();
	
		$_SESSION['GRUPOS_MULTIMEDIA'][] = $key_grupo;
	
		$ultimo = count($_SESSION['GRUPOS_MULTIMEDIA']) - 1;
	
		for($i=0;$i<count($_POST['seleccionados']);$i++){
			$_SESSION['SELECCIONADOS'][$key_grupo][]	=	$_POST['seleccionados'][$i];
			$_SESSION['TALLAS'][$key_grupo][]			=	$_POST['tallas_seleccionadas'][$_POST['seleccionados'][$i]];
		
	
			//estas variables se borran en theme()/ajax.php
		}
	}

	function carrito_paquetes(){
		
				$paquetes = count($_SESSION["GRUPOS_MULTIMEDIA"]);
				$modo_test= false;
				
				if($paquetes>0){  
	
					//echo"<div class='mensaje_system'>Tienes ".count($_SESSION["IDMULTIMEDIA"])." productos en tu carrito</div>";

					?>

					<div class="table-responsive">

					<table class="table">
						<tbody>
							<tr>
								<td></td>
								<td>#</td>
								<td>Imagen</td>
								<td>Descripcion</td>
								<td>Talla</td>
								<td>Precio</td>
							</tr>

					<?php

				for($i=count($_SESSION["GRUPOS_MULTIMEDIA"])-1;$i>=0;$i--){
						
						echo '<input type="hidden" name="IDMULTIMEDIA[]" value="'.$_SESSION['IDMULTIMEDIA'][$i].'">';

						
						
								$key_grupal = $_SESSION["GRUPOS_MULTIMEDIA"][$i];
								
								$IDMULTIMEDIA = $_SESSION['SELECCIONADOS'][$key_grupal];
								
								$tipo_promo = tipo_promo($IDMULTIMEDIA);
								
								//echo test_array($tipo_promo);
							
								for($k=0;$k<count($IDMULTIMEDIA);$k++){
	
									$TALLAS = $_SESSION['TALLAS'][$key_grupal];
									
									if($k==0){
										$class = "icon_eliminar";
									}else{
										$class = "";	
									}	

									echo "<tr>\n";
		
										echo "<td class='eliminar_tabla'><a class='glyphicon glyphicon-trash ".$class."' data-idgrupo='".$_SESSION["GRUPOS_MULTIMEDIA"][$i]."' href=''></a></td>\n";
										echo "<td class=''>".$IDMULTIMEDIA[$k]."</td>\n";
										echo "<td class=''><a class='zoom' href='".imagen_multimedia($IDMULTIMEDIA[$k])."'><img src='".imagen_multimedia($IDMULTIMEDIA[$k])."'></a></td>\n";
										echo "<td class=''>".label_multimedia($IDMULTIMEDIA[$k])."</td>\n";
										echo "<td class=''>\n";
											echo "<select class='validar_campo' data-idgrupo='".$key_grupal."' data-posicion='".$k."' name='TALLA[]'>".tallas($IDMULTIMEDIA[$k],'','',$TALLAS[$k],false)."</select>";
										echo "</td>";
										echo "<td class=''>".formato_moneda(precio_multimedia($IDMULTIMEDIA[$k]))."</td>\n\n";
										
									echo "</tr>";
									
									$_SESSION['PRECIO_NORMAL'][$key_grupal][$k]=precio_multimedia($IDMULTIMEDIA[$k]);
									$_SESSION['PRECIO_PROMO'][$key_grupal][$k]=aplicar_promo(IdProductoFromIdMultimedia($IDMULTIMEDIA[$k]),$tipo_promo);
									$_SESSION['CANTIDAD'][$key_grupal][$k]=1;

									
								}	
									
						
	
					}

					?>
						</tbody>
					</table>
					</div>

					<?php 
					
					session_start();
					
					$_SESSION['carrito_total']		=	$this->subtotal();
					$_SESSION['carrito_descuento']	=	$this->descuento_total();
					
					?>

					<input type="hidden" id="carrito_total" name="carrito_total" value="<?php echo $this->subtotal();?>" >
					<input type="hidden" id="carrito_descuento" name="carrito_descuento" value="<?php echo $this->descuento_total();?>" >

	<?php  }else{
				echo "<div class='mensaje_system_verde'>No tienes productos en tu bolsa</div>";	
			}	
					
	}
	
	function subtotal(){
		
		for($i=count($_SESSION["GRUPOS_MULTIMEDIA"])-1;$i>=0;$i--){
		
			$key_grupal = $_SESSION["GRUPOS_MULTIMEDIA"][$i];		
			$IDMULTIMEDIA = $_SESSION['SELECCIONADOS'][$key_grupal];		
			$tipo_promo = tipo_promo($IDMULTIMEDIA);
			
			for($k=0;$k<count($IDMULTIMEDIA);$k++){
				$subtotal += precio_multimedia($IDMULTIMEDIA[$k]);
			}

		}	
		
		return $subtotal;
	}
	
	function descuentos_parciales(){
		for($i=count($_SESSION["GRUPOS_MULTIMEDIA"])-1;$i>=0;$i--){
			$key_grupal = $_SESSION["GRUPOS_MULTIMEDIA"][$i];
			$IDMULTIMEDIA = $_SESSION['SELECCIONADOS'][$key_grupal];
			$tipo_promo = tipo_promo($IDMULTIMEDIA);

			for($k=0;$k<count($IDMULTIMEDIA);$k++){
				$parcial += aplicar_promo(IdProductoFromIdMultimedia($IDMULTIMEDIA[$k]),$tipo_promo);		
			}
		}	
		
		return $parcial;
	}	
	
	function descuento_total(){
		$descuento_total = $this->subtotal() - $this->descuentos_parciales();
		return $descuento_total;
	}
	
	
	function total_paquetes(){
		$total_paquetes = count($_SESSION["GRUPOS_MULTIMEDIA"]);
		return $total_paquetes;
	}	
	
	
	function localidades(){
?>
		<div id="localidad_login" class="localidad_login">
			<div class='filas_form'>			 
				<label for="contrasena">Departamento</label>
				<select name="direcciones_envio[IDDEPARTAMENTO]" id="get_departamento" class="validar_campo"><?php get_localidades('departamentos','',$_SESSION['LOCALIDAD']['DEPARTAMENTO']); ?></select>					  
			</div>		

			<div class='filas_form'>			 
			  <label for="contrasena">Provincia</label>
			<select name="direcciones_envio[IDPROVINCIA]" id="get_provincias" class="validar_campo"><?php get_localidades('provincias',$_SESSION['LOCALIDAD']['DEPARTAMENTO'],$_SESSION['LOCALIDAD']['PROVINCIA']); ?></select>
			</div>		

			<div class='filas_form'>			 
				<label for="contrasena">Distrito</label>
				<select name="direcciones_envio[IDDISTRITO]" id="get_distritos" class="validar_campo"><?php get_localidades('distritos',$_SESSION['LOCALIDAD']['PROVINCIA'],$_SESSION['LOCALIDAD']['DISTRITO']); ?></select>
			</div>	
		</div>	
<?php 		
	}	
	
}


?>