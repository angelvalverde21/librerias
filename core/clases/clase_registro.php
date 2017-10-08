<?php 

class registro{

		function __construct(){
			
		}
		
		function login(){
			?>
				<a href="#ancla2" id="ancla2"></a>
				
				<div id="login_usuario">		
					<div id="content_login_usuario">		
					
						<h2>Inicia sesion aqui</h2>
						<input id="login_email" class="input_login" type="text" name="usuarios[EMAIL]" value="" rel="Indiquenos su email">
						
						<input id="login_pass" class="input_login" type="password" name="usuarios[PASS]" VALUE="" rel="XXXXXXXXXXXXXXXXXXXXXXX">
						
						<div class="boton_form_claro inline">
							<a id="registrar_pedido" href="#" class=''>Iniciar sesion</a>
						</div>
						
						<p><a id="link_register" class="link_register" href="#">&oacute; Registrate aqui</a></p>
					</div>
				</div>
			<?php 					
		}
		
		function nuevo_usuario(){
			?>
			
			<a href="#ancla1" id="ancla1"></a>
		
				<div class="form-group">
					<div class="col-xs-12">
						<div class="input-group input-group-md">
						<span class="input-group-addon"><span class="icon-user"></span></span>  
							<input id="register_nombre" class="form-control input_login validar_campo" type="text" name="usuarios[NOMBRE]" value="" Completos" placeholder="Nombres y Apellidos Completos">
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-xs-12">
					<div class="input-group input-group-md">
						<span class="input-group-addon"><span class="icon-mobile"></span></span>  
						<input id="register_celular" class="form-control input_login validar_campo" type="number" name="usuarios[CELULAR]" placeholder="Celular de contacto" value="" placeholder="Celular de contacto" >
						</div>
					</div>
				</div>

				<input type="hidden" name="usuarios[USER_AGENT]" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>">

				<div class="form-group">
					<div class="col-xs-12">
						<div class="input-group input-group-md">
							<span class="input-group-addon"><span class="icon-home"></span></span>  
							<input id="register_direccion" class="form-control input_login validar_campo" type="text" name="direcciones_envio[DIRECCION]" value="" placeholder="Direccion de entrega" >
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-xs-12">
						<div class="input-group input-group-md">
							<span class="input-group-addon"><span class="icon-level-up"></span></span>  
							<input id="register_referencia" class="form-control input_login validar_campo" type="text" name="direcciones_envio[REFERENCIA]" value="" placeholder="Referencia de su direccion" >
						</div>
					</div>
				</div>

				<div id="localidad_login">
					<div class='form-group filas_form'>	
						<div class="col-xs-12">		 
					  <label for="contrasena">Departamento</label>
					  <select name="direcciones_envio[IDDEPARTAMENTO]" id="get_departamento" class="form-control validar_campo"><?php get_localidades('departamentos','',$_SESSION['LOCALIDAD']['DEPARTAMENTO']); ?></select>					  
					</div>		
					</div>		

					<div class='form-group filas_form'>		
					<div class="col-xs-12">	 
					  <label for="contrasena">Provincia</label>
						<select name="direcciones_envio[IDPROVINCIA]" id="get_provincias" class="form-control validar_campo"><?php get_localidades('provincias',$_SESSION['LOCALIDAD']['DEPARTAMENTO'],$_SESSION['LOCALIDAD']['PROVINCIA']); ?></select>
					</div>		
					</div>		

					<div class='form-group filas_form'>		
					<div class="col-xs-12">	 
					  <label for="contrasena">Distrito</label>
						<select name="direcciones_envio[IDDISTRITO]" id="get_distritos" class="form-control validar_campo"><?php get_localidades('distritos',$_SESSION['LOCALIDAD']['PROVINCIA'],$_SESSION['LOCALIDAD']['DISTRITO']); ?></select>
					</div>	
					</div>	
				</div>	
				
				<!---------------->

				<div id="show_dni">
				
					<div class="form-group">
						<div class="col-xs-12">
							<div class="input-group input-group-md">
								<span class="input-group-addon"><span class="icon-v-card"></span></span>  
								<input id="register_dni" class="form-control input_login" type="number" name="direcciones_envio[DNI]" value="" placeholder="DNI (Es Necesario para el envio)"  rel="DNI (Es Necesario para el envio)">
							</div>
						</div>
					</div>

				</div>
			
				<!-- Parametros de navegacion del usuario -->

				<input type="hidden" name="usuarios[DISPOSITIVO]" value="<?php echo dispositivo(); ?>">
				<input type="hidden" name="usuarios[IP]" value="<?php echo getIP(); ?>">
				<input type="hidden" name="IDSESSION" value="<?php echo session_id(); ?>">
				<input type="hidden" name="usuarios[USER_AGENT]" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>">
				<input type="hidden" name="direcciones_envio[DEFECTO]" value="1">

				<!-- <p><a id="link_login" href="#">&oacute; Iniciar sesion aqui</a></p> -->
		
			<?php 	
		}
		
		
		
	}

 ?>