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

<script type="text/javascript">

	var showFicha;
	 					
	$(document).ready(function(){

	 	var nameContentId='ficha-usuario';

	 	showFicha = function(nameContentId){

			$.ajax({

				type: "POST",
				url: "query.php",
				data: { 
					TABLA 		: 	$("#"+nameContentId+" .tabla").val(),
					KEY_TABLA 	: 	$("#"+nameContentId+" .key_tabla").val(),
					KEY_VALUE 	: 	$("#"+nameContentId+" .key_value").val()
				},

				beforeSend: function () {
					console.log('Obteniendo datos...');
				},

				success:  function (response) {

					//console.log(JSON.parse(response));
					var objeto = JSON.parse(response);

					if(objeto.MENSAJE == 'undefined'){
						console.log(objeto.MENSAJE);
					}else{

						var cadena="";

						//recorriendo los campos inputs, selects del formulario
						$("#"+nameContentId+" .valor").each(function(){
														
						//Asignando a los input su valor correspondiente que se extrae desde mysql php
						cadena += "<li>" +$(this).attr('placeholder') + ": " + objeto[$(this).attr('name')] + "</li>";
								
						//alert($(this).attr('name'));
						});

						$("#"+nameContentId+" .respuesta-ficha").html(cadena); 	 

					}
				}
			});		
		}

		showFicha(nameContentId);

	});		
</script>
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

	<?php 
		$result = $db->consulta("SELECT * FROM ayv_usuarios WHERE IDUSUARIO='1' LIMIT 1");
		$row = $db->recuperar_array($result);
	 ?>
 
	 <script type="text/javascript">

	 	$(document).ready(function(){

	 		//Click en el boton NUEVO REGISTRO

	 		$(document).on('click','#ficha-usuario .btn-nuevo-registro',function(){
				//alert('ejemplo');
				//$('#ficha-usuario form').trigger('reset');

				$("#ficha-usuario .valor").each(function(){
					//Asignando a los input su valor correspondiente que se extrae desde mysql php
					$(this).val('');
					//alert($(this).attr('name'));
				});

				$('#ficha-usuario .key_value').val('');
			});


			//Click en el boton EDITAR

		 	$(document).on('click','#ficha-usuario .editar-registro',function(){
		 		
		 		var button = $(event.relatedTarget) // Boton que activo el modal
				var codigo = button.data('codigo') // Extract info from data-* attributes


		 		var nameContentId = "ficha-usuario";

				$.ajax({
					type: "POST",
					url: "query.php",
					data: { 
						TABLA 		: 	$("#"+nameContentId+" .tabla").val(),
						KEY_TABLA 	: 	$("#"+nameContentId+" .key_tabla").val(),
						KEY_VALUE 	: 	$("#"+nameContentId+" .editar-registro").data('codigo')
					},

					beforeSend: function () {
						console.log('Obteniendo datos...');
					},

					success:  function (response) {

						//console.log(JSON.parse(response));
						var objeto = JSON.parse(response);

						if(objeto.MENSAJE == 'undefined'){
							console.log(objeto.MENSAJE);
							console.log('error-boton-editar');
						}else{
							$("#ficha-usuario .valor").each(function(){
								//Asignando a los input su valor correspondiente que se extrae desde mysql php
								$(this).val(objeto[$(this).attr('name')]);
								//alert($(this).attr('name'));
							});
						}

						//$("#respuesta-ficha").html(cadena); 
					}

				});	
			});	

	 	});

	 </script>

 	<!-- el ID ficha-usuario determina donde actuara todo el script -->

	<div class="ficha-usuario" id="ficha-usuario">

	 	<div class="ficha-show">
	 		<div class="panel panel-default">
	 			<div class="panel-heading">
					<a href="#" class="btn btn-success pull-left nuevo-registro btn-nuevo-registro" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-file"></span> Nuevo Registro</a>
					<a href="#" class="btn btn-primary pull-right editar-registro" data-codigo="1" data-toggle="modal" data-target="#myModal"><span class='glyphicon glyphicon-th'></span> Editar</a>
	 			</div>
	 			<div class="panel-body">
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
						<h4 class="modal-title">Modal Header</h4>
					</div>
					<div class="modal-body">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	  

				        	<form class="form-horizontal" id="">

								<div class="form-group">
									<input type="text" class="valor form-control" value="<?php echo $row['NOMBRE'] ?>" name="NOMBRE" placeholder="Nombres">
								</div>
								<div class="form-group">
									<input type="text" class="valor form-control" value="<?php echo $row['APELLIDO'] ?>" name="APELLIDO" placeholder="Apellidos">
								</div>
								<div class="form-group">
									<input type="text" class="valor form-control" value="<?php echo $row['CELULAR'] ?>" name="CELULAR" placeholder="Telefonos">
								</div>
								<div class="form-group">
									<input type="text" class="valor form-control" value="<?php echo $row['EMAIL'] ?>" name="EMAIL" placeholder="Direccion">
								</div>

								<!-- Campos ocultos -->

								<input type="hidden" class="tabla" name="TABLA" value="usuarios">
								<input type="hidden" class="key_tabla" name="KEY_TABLA" value="IDUSUARIO">
								<input type="hidden" class="key_value" name="KEY_VALUE" value="1">

							</form>

							<div class="listado-registros">
								
							</div>
						</div>
			   		</div>
			    	<div class="modal-footer">
			    		<button type="button" class="btn btn-primary guardarCambios">Guardar Cambios</button>
			    		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    	</div>
		 		</div>

		  	</div>
		</div>
	
	</div>

</div>	

	<script type="text/javascript">

		$(document).ready(function(){

			function extraerValorAtributo(nameContentId,atributo=""){

				var arrayAtributo = new Array();

				if(atributo==""){
					$("#"+nameContentId+" .valor").each(function(){
						arrayAtributo.push($(this).val()); // Extrae los valores correspondientes de los nombres
					});	
				}else{
					$("#"+nameContentId+" .valor").each(function(){
						arrayAtributo.push($(this).attr(atributo)); // Extrae los valores correspondientes de los nombres
					});				
				}

				return arrayAtributo;

			}

			function guardarCambios(nameContentId){
				
				var nameContentId;

				$.ajax({

					type: "POST",
					url: "ajax.php",
					data: { 
						CAMPOS 		: 	extraerValorAtributo(nameContentId,'name'),
						VALORES 	: 	extraerValorAtributo(nameContentId),
						TABLA 		: 	$("#"+nameContentId+" .tabla").val(),
						KEY_TABLA 	: 	$("#"+nameContentId+" .key_tabla").val(),
						KEY_VALUE 	: 	$("#"+nameContentId+" .key_value").val()

					},

					beforeSend: function () {
						console.log('Obteniendo datosx...');
					},

					success:  function (response) {
						//console.log(response); 
						objeto = JSON.parse(response);
						if(objeto.TIPO_CONSULTA == 'INSERT'){
							$("#"+nameContentId+" .key_value").val(objeto.KEY_VALUE);
							showFicha(nameContentId);
						}else{
							if(objeto.TIPO_CONSULTA == 'UPDATE'){
								$("#"+nameContentId+" .key_value").val(objeto.KEY_VALUE);
								showFicha(nameContentId);
							}else{ 
								$("#respuesta").html(response); 
								
							}
							
						}

						//se asigna el codigo de referencia

						$("#"+nameContentId+" .editar-registro").data('codigo',objeto.KEY_VALUE);
						console.log(response); 	
							
					}

				});				
			}


			// Evento GUARDAR CAMBIOS 

			$("#ficha-usuario .guardarCambios").click(function(){
				//alert(JSON.stringify(extraerValorAtributo('name','valor','content')));
				//alert(JSON.stringify(extraerValorAtributo('placeholder','valor','content')));

				guardarCambios('ficha-usuario');

			

			});

		});	
			


	</script>

	<pre>
		<div id="respuesta"></div>
	</pre>
</body>
</html>