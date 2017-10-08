<?php //if($_POST["type"]=="" AND $_GET["type"]==""){ header("location: ".get_option("home")."/login?type=usuario");}  

	$redirect = $_GET['redirect'];

	if($redirect=="" and login()){
		$redirect=URL_USER."/index.php";
		header("location:".$redirect);
		exit();
	}

	$pagina = new page();
?>
<html>
<head>

	<title>Login Global</title>
	<!--
	<link rel="stylesheet" href="<?php echo URL_GLOBAL; ?>/style_global.css" type="text/css" media="screen" />	
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>	
	-->
	<?php $pagina->bootstrap(); ?>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
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


			<style>


				.login{
					width: 360px;
					padding: 10px 10px 0 10px;
					margin-left: -180px;
					margin-top: -125px;
				}


				.panel-login{
					position: absolute;
					top: 50%;
					left: 50%;
				}

				.panel-login .row{
					border: 1px solid #ccc;
					padding: 10px;
					border-radius: 10px;
				}

				.container{
					width: 100%;
					height: 100%;	
					position: relative;
				}

			</style>	

	<div class="container">

			<?php 
			
				/*
			
					Todos las variables post se envian al mismo fichero desde el cual se llama a login.php
					y se redireccion al mismo
					
					Por ejemplo 
					
					Se detecta un ingreso al dominio protegido www.dominio.com/admin5241/ventas.php?IDVENTA=65320232
					
					Se mostrara la pantalla login y luego se enviara otra vez la peticion
										
				*/
		
			?>

			<div class="panel-login login">
			
			 <div class="panel panel-default">

			 	<div class="panel-heading">
   					<div class="panel-title">Bienvenido</div>

   				</div>

			 	<div class="panel-body">
					
				<form id="form_login" autocomplete="new-password" name="" action="<?php echo $redirect; ?>" method="POST" class="">
							

						<!-----------------------------  Campos de ingreso  -------------------------->
						
						<?php if($_GET['email']<>""){?>
							<label>Hemos enviado su nueva contraseña a su email<br /><br /></label>
						<?php }?>
				
				<div class="form-group">
					<div class="input-group input-group-md">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>  
						<input type="text" name="USER" class="form-control" placeholder="Username">
					</div>
				</div>

				<div class="form-group">
					<div class="input-group input-group-md">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>  
						<input type="password" name="PASSWORD" class="form-control" placeholder="Password">
					</div>
				</div>

				  <div class="form-group">
				    <div class="">
				      <button type="submit" class="btn btn-primary btn-block">Iniciar Sesion</button>
				    </div>
				  </div>

				   <div class="form-group">
				    <div class="">
				      <div class="checkbox">
				        <label>
				          <input type="checkbox"> Recordar 
				        </label>
				      </div>
				    </div>
				  </div>
						
						
					<!-----------------------------   Campos Ocultos  -------------------------->
						
					<input type="hidden" value="LOGIN" name="TIPO">
					<input type="hidden" value="<?php echo $_GET['type']; ?>" name="type">
					<input type="hidden" value="<?php echo $redirect; ?>" name="redirect">
					<input type="hidden" value="INDENTIFICARSE" name="ENVIAR">
						
					<!-----------------------------   Campos Submit  -------------------------->
						
					<!--
					<a id="identificar" href="#">Identificarse</a>
						
						
					<small><?php echo mensaje_error(); ?></small>
					<small><a href="<?php echo get_option('home');?>/restore">¿Ha olvidado su contraseña?</a></small>
					-->

					</form>
					</div>
				</div>	
					
		</div>

	</div>
</body>
</html>	