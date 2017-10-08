<?php 
	if($_POST['USER']<>""){
		$restore = new restore_password($_POST['USER']);
		$restore->iniciar();
		
		if($restore->existe_usuario()){
			$usuario = $restore->retornar_usuario(); 
			substr($usuario,5,strlen($usuario));
			header("location:".get_option('home').'/login?caso=restore_password&email='.urlencode($usuario));
			exit();
		}
	}
?>
<html>
<head>
	<title>Login Global</title>
	<link rel="stylesheet" href="<?php echo URL_GLOBAL; ?>/style_global.css" type="text/css" media="screen" />	
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>	
</head>

<body>

	<script>
		$(document).ready(function(){
			$("#identificar").click(function(){
				$("#form_login").submit();
				//alert("formulario enviado");
				//$(this).css('background-image','url(<?php echo URL_GLOBAL; ?>/images/ajax-loader.gif)');
				$(this).css('background','#E1E1E1');
				$(this).css('color','#878787');
				$(this).unbind('click');
				return false;
			});
		});
	</script>

	<div id="content_login">
		<div id="login" class="restore">
		
			<?php 
			
				/*
			
					Todos las variables post se envian al mismo fichero desde el cual se llama a login.php
					y se redireccion al mismo
					
					Por ejemplo 
					
					Se detecta un ingreso al dominio protegido www.dominio.com/admin5241/ventas.php?IDVENTA=65320232
					
					Se mostrara la pantalla login y luego se enviara otra vez la peticion
										
				*/
		
			?>
			
		
			<form id="form_login" autocomplete="off" name="" action="<?php echo get_option('home'); ?>/restore" method="POST">
						
				<!-----------------------------  Campos de ingreso  -------------------------->
				
				<?php if($_POST['USER']<>""){ ?>
				
					<?php if($restore->existe_usuario()){?>
						<label>Hemos enviado su nueva contraseña a su correo: *****<?php $usuario = $restore->retornar_usuario(); echo substr($usuario,5,strlen($usuario)); ?> </label>
						<input id="usuario" type="text" value="" name="USER">
						<a id="identificar" href="<?php echo get_option('home');?>/restore">Volver a enviar correo</a>
					<?php }else{ ?>
						<label>No hemos encontrado su usuario<br />Indiquenos su usuario (Email o Celular)</label>
						<input id="usuario" type="text" value="" name="USER">
						<a id="identificar" href="<?php echo get_option('home');?>/restore">Volver a enviar correo</a>
					<?php } ?>
	
				<?php }else{ ?>
				
				<?php 
				
					$form = new formulario_web();
					$form->text(array('LABEL'=>'Indiquenos su usuario (Email)','NAME'=>'USER','POSICION'=>'2,-50'));
 				?>
 				
				
				
				<?php } ?>
								
				<!-----------------------------   Campos Ocultos  -------------------------->
				
				<input type="hidden" value="LOGIN" name="TIPO">
				<input type="hidden" value="<?php echo $_GET['type']; ?>" name="type">
				<input type="hidden" value="<?php echo $redirect; ?>" name="redirect">
				<input type="hidden" value="INDENTIFICARSE" name="ENVIAR">
				
				<!-----------------------------   Campos Submit  -------------------------->
				
				<?php if($_POST['USER']<>""){ ?>
				
				<?php }else{ ?>
				
				<a id="identificar" href="#">Recuperar contrase&ntilde;a</a>
				
				
				<?php } ?>

				<!-----------------------------   Sessiones   ----------------------------->
				
				<small>Recupere su contraseña aqui</small>
				<small><a id="" href="<?php echo get_option('home'); ?>/login">Cancelar y volver</a></small>
				
			</form>
		</div>
	</div>
</body>
</html>	