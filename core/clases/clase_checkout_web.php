<?php
	class checkout{
		function __construct(){
			
		}

		function form_pedido_registro(){
			
		}

		function metodos_pago(){
			?>
				<div class='form-group filas_form'>		
					<div class="col-xs-12">	 
					  <label for="contrasena">Tipo de pago</label>
						<select name="ventas[TIPOPAGO]" id="" class="form-control validar_campo">
							<option value="0">Seleccione medio de pago</option>
							<option value="1">Pago en efectivo (Contraentrega)</option>
							<option value="3">Tarjeta Credito o Debito (Contraentrega)</option>
							<option value="5">Pagar Ahora Online (Visa)</option>
						</select>
					</div>	
				</div>	
			<?php

		}

		function form_envio_facturacon(){
			?>

				<script>
					$("#register_nombre").keyup(function(){
						$("#RAZONSOCIAL_FACTU").val($(this).val());
					});

					$("#register_direccion").keyup(function(){
						$("#DIRECCION_FACTU").val($(this).val());
					});

					$("#register_dni").keyup(function(){
						$("#RUC_FACTU").val($(this).val());
					});
					
					$("#register_celular").keyup(function(){
						$("#register_telefono_envio").val($(this).val());
						$("#register_celular_envio").val($(this).val());
					});
					
				</script>
				
				
				<!-- <div class="label_sin_registro">
					<input id="crear_usuario" class="register_invitado" type="checkbox" name="registro_usuario" value="1"><span id="icon_bolsa_regalo">¿Desea crear su usuario?</span>
				</div> -->
				
				<!----- si el usuario quiere registrarse -->

				
				<input type="hidden" name="direcciones_facturacion[DEFECTO]" value="1">
				<input ID="RAZONSOCIAL_FACTU" type="hidden" name="direcciones_facturacion[RAZONSOCIAL]" value="">
				<input ID="DIRECCION_FACTU" type="hidden" name="direcciones_facturacion[DIRECCION]" value="">
				<input ID="RUC_FACTU" type="hidden" name="direcciones_facturacion[RUC]" value="">
				<input class="" id="" type="hidden" value="<?php echo dispositivo(); ?>" name="ventas[DISPOSITIVO]">
				
					<!----- codigos multimedia -->

					<div class='mensaje_system_rojo'></div>
					<!------ codigos multimedia -->
						
					<!-- <div class="totales_pedido">
							<ul>
								<li><label>Sub Total:</label><span>S/. <input class="input_totales" id="input_sub_total" type="text" value="<?php echo $costo_sub_total; ?>" name="ventas[PEDIDO_SUB_TOTAL]"></span></li>
								<li><label>Costos de envio:</label><span>S/. <input class="input_totales" id="input_envio" type="text" value="0,00" name="ventas[PEDIDO_ENVIO]"></span></li>
								<li><label>Pago Total:</label><span>S/. <input class="input_totales" id="input_total" type="text" value="<?php echo $costo_sub_total; ?>" name="ventas[PEDIDO_TOTAL]"></span></li>
							</ul>
					</div>-->


					<!-- Parametros internos -->

					<input type="hidden" name="TIPO" value="PEDIDO">
					<input type="hidden" name="PROCESO" value="CHECKOUT">
					<div id="btn_registrar" class="boton_form_claro">
						<a  class="btn btn-primary col-sm-3 col-lg-2 col-xs-12" href="#"><span class='glyphicon glyphicon-shopping-cart'></span> Generar Pedido</a>
						<!-- <a id="btn_test" href="#">TEST</a> internos -->
					</div>

					<!---------------->

					<input id="register_telefono_envio" type="hidden" name="direcciones_envio[TELEFONO]" value=''>
					<input id="register_celular_envio" type="hidden" name="direcciones_envio[CELULAR]" value=''>
					
					<!---------------->
			<?php
		}
	}

	function register_quick(){
		?>
			<div id="show_pass">	
				<input id="register_email" class="input_login" type="text" name="usuarios[EMAIL]" value="" rel="Indiquenos su email">
				<div id="show_user"></div>
				<label>Ahora elija una contraseña</label>
				<input id="register_pass" class="input_login" type="password" name="usuarios[PASS]">
				<label>Confirmar contraseña</label>
				<input id="register_repass" class="input_login" type="password" value="" name="RE_PASS">
			</div>	
		<?php
	}
?>