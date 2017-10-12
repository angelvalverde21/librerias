<?php 
    //echo session_status();
	error_reporting(4181);

	//*****************************************//
	require("../config.php");
	/* carga todas las clases y funciones necesarias para que funcione el sitio web */
	require(DIR_CORE."/start.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

	<!-- bootstrap -->

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
					
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
					
	<script src="https://code.jquery.com/jquery-latest.js"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script type="text/javascript" src="js/ficha_defecto.js"></script>
</head>
<body>

<style type="text/css">
	.panel-heading{
		overflow: hidden;
	}
	.modal-body{
		overflow: hidden;		
	}
</style>

<div class="container">


 	<!-- el ID ficha-envio determina donde actuara todo el script -->

	<div class="ficha-envio" id="ficha-envio">

	 	<div class="ficha-show">
	 		<div class="panel panel-default">
	 			<div class="panel-heading">
					<a href="#" class="btn btn-success pull-left nuevo-registro btn-nuevo-registro" data-toggle="modal" data-target="#myModal" data-contentid="ficha-envio"><span class="glyphicon glyphicon-file"></span> Nuevo Registro</a>
					<a href="#" class="btn btn-primary pull-right editar-registro" data-codigo="" data-toggle="modal" data-target="#myModal" data-contentid="ficha-envio"><span class='glyphicon glyphicon-th'></span> Editar</a>
	 			</div>
	 			<div class="panel-body">
	 				<div class="selector-direccion">
	 					<select class="cambio-registro form-control" name="direcciones_envio[IDENVIO]"  data-contentid="ficha-envio"></select>
	 				</div>
	 				<div class="respuesta-ficha">
	 				</div>
	 			</div>
	 		</div>

	 	</div>	

		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

		    <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Agregar o Actualizar Registro</h4>
					</div>
					<div class="modal-body">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	  
							<div class="row"><label>Direccion de envio Principal</label></div>
							
				        	<form class="form-horizontal" id="">

								<div class="form-group">
									<input type="text" class="valor form-control" value="" name="CONSIGNATARIO" placeholder="CONSIGNATARIO">
								</div>
								<div class="form-group">
									<input type="text" class="valor form-control" value="" name="DIRECCION" placeholder="DIRECCION">
								</div>
								<div class="form-group">
									<input type="text" class="valor form-control" value="" name="REFERENCIA" placeholder="REFERENCIA">
								</div>

								<!-- Campos ocultos -->

								<input type="hidden" class="tabla" name="TABLA" value="direcciones_envio">
								<input type="hidden" class="key_tabla" name="KEY_TABLA" value="IDENVIO">
								<input type="hidden" class="key_value" name="KEY_VALUE" value="">
								<input type="hidden" class="key_value_static" name="direcciones_envio[IDENVIO]" value="">

								<!-- Campos para configuracion -->

								<input type="hidden" class="nameContentId" name="nameContentId" value="ficha-envio">
								<input type="hidden" class="idPrincipal" name="idPrincipal" value="IDENVIO">
								<input type="hidden" class="labelSelect" name="labelSelect" value="CONSIGNATARIO">
								<input type="hidden" class="keyParent" name="keyParent" value="IDUSUARIO">
								<input type="hidden" class="keyParentvalue" name="keyParentvalue" value="1">

							</form>

						</div>
			   		</div>
			    	<div class="modal-footer">
			    		<button type="button" class="btn btn-primary guardarCambios" data-contentid="ficha-envio">Guardar Cambios</button>
			    		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    	</div>
		 		</div>

		  	</div>
		</div>
	
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			iniciarFicha('ficha-envio');			
		});
	</script>

</div>	

</body>
</html>