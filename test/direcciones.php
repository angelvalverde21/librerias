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

<script type="text/javascript">
	 					
	$(document).ready(function(){
	
		//config

		var nameContentId 	= 'ficha-envio';
		var idPrincipal 	= 'IDENVIO';
		var labelSelect 	= 'CONSIGNATARIO';
		var keyParent 		= 'IDUSUARIO';
		var keyParentvalue 	= 1; //Se refiere al IDUSUARIO
		var keyValueInicial = 18; //Se refiere al IDENVIO (IDENVIO es de la tabla primarioa o principal)

		//funciones de uso general

		var showFicha;
		var generarListado;
		var extraerValorAtributo;
		var guardarCambios;

	 	generarListado = function(nameContentId,selected='',caso){

	 		var caso;

			$.ajax({

				type: "POST",
				url: "query.php",
				data: { 
					TABLA 				: 	$("#"+nameContentId+" .tabla").val(),
					KEY_PARENT 			: 	keyParent,
					KEY_PARENT_VALUE 	: 	keyParentvalue,
					CASO 				: 	caso
				},

				beforeSend: function () {
					console.log('Obteniendo listado...');
				},

				success:  function (response_listado) {

					//console.log(JSON.parse(response));
					var objeto_listado = JSON.parse(response_listado);

					console.log(objeto_listado);

					//alert(objeto_listado);

					var option_listado ="";

		 			if(selected==''){

						for(var i=0;i<objeto_listado.length;i++){
												
							if(objeto_listado[i][idPrincipal]==selected || objeto_listado[i]['DEFECTO']=='1'){
								option_listado = option_listado + '<option selected value="'+objeto_listado[i][idPrincipal]+'">'+objeto_listado[i][labelSelect]+'</option>';

							}else{
								option_listado = option_listado + '<option value="'+objeto_listado[i][idPrincipal]+'">'+objeto_listado[i][labelSelect]+'</option>';

							}
							
						}

		 			}else{

						for(var i=0;i<objeto_listado.length;i++){
												
							if(objeto_listado[i][idPrincipal]==selected){
								option_listado = option_listado + '<option selected value="'+objeto_listado[i][idPrincipal]+'">'+objeto_listado[i][labelSelect]+'</option>';

							}else{
								option_listado = option_listado + '<option value="'+objeto_listado[i][idPrincipal]+'">'+objeto_listado[i][labelSelect]+'</option>';

							}
							
						}
		 			}


					$("#"+nameContentId+" .selector-direccion .cambio-registro").html(option_listado);
									
				}
			});		
	 	}

	 	showFicha = function(nameContentId,selected='',caso){

			$.ajax({

				type: "POST",
				url: "query.php",
				data: { 
					KEY_PARENT 			: 	keyParent,
					KEY_PARENT_VALUE 	: 	keyParentvalue,
					TABLA 				: 	$("#"+nameContentId+" .tabla").val(),
					KEY_TABLA 			: 	$("#"+nameContentId+" .key_tabla").val(),
					KEY_VALUE 			: 	$("#"+nameContentId+" .key_value_static").val(),
					CASO 				: 	caso
				},

				beforeSend: function () {
					console.log('Obteniendo datos...');
				},

				success:  function (response) {

					console.log(response);

					//console.log(JSON.parse(response));

					var objeto = JSON.parse(response);

					var cadena="";

					for(var i=0;i<objeto.length;i++){
						//recorriendo los campos inputs, selects del formulario
						$("#"+nameContentId+" .valor").each(function(){

							//Asignando a los input su valor correspondiente que se extrae desde mysql php
							cadena += "<li>" +$(this).attr('placeholder') + ": " + objeto[i][$(this).attr('name')] + "</li>";
													
							//alert($(this).attr('name'));
						});

						$("#"+nameContentId+" .respuesta-ficha").html(cadena); 	 
						
							$("#"+nameContentId+" .key_value").val(objeto[i][idPrincipal]);
							$("#"+nameContentId+" .key_value_static").val(objeto[i][idPrincipal]);
						
											
					}
					
				}
			});		
		}

		extraerValorAtributo = function(nameContentId,atributo=""){

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

		guardarCambios = function(nameContentId){

			$.ajax({

				type: "POST",
				url: "ajax.php",
				data: { 
					CAMPOS 		: 	extraerValorAtributo(nameContentId,'name'),
					VALORES 	: 	extraerValorAtributo(nameContentId),
					TABLA 		: 	$("#"+nameContentId+" .tabla").val(),
					KEY_TABLA 	: 	$("#"+nameContentId+" .key_tabla").val(),
					KEY_VALUE 	: 	$("#"+nameContentId+" .key_value").val(),
					KEY_PARENT 	: 	keyParent,
					KEY_PARENT_VALUE : keyParentvalue
				},

				beforeSend: function () {
					console.log('Obteniendo datosx...');
				},

				success:  function (response) {
					//console.log(response); 
					objeto = JSON.parse(response);

					$("#"+nameContentId+" .key_value").val(objeto.KEY_VALUE);
					$("#"+nameContentId+" .key_value_static").val(objeto.KEY_VALUE);

					if(objeto.TIPO_CONSULTA == 'INSERT' || objeto.TIPO_CONSULTA == 'UPDATE'){
						showFicha(nameContentId,objeto.KEY_VALUE,'SHOW_REGISTRO');
						generarListado(nameContentId,'','SHOW_LISTA_FILTRADO');

					}else{
						$("#respuesta").html(response); 
					}

					//se asigna el codigo de referencia

					
					console.log(response); 	
							
				}

			});				
		}

		//Generar listado al hacer click en cambiar de direccion

		$(document).on("change","#" +nameContentId +" .cambio-registro",function(){
	 		$("#"+nameContentId+" .key_value").val($(this).val());
	 		$("#"+nameContentId+" .key_value_static").val($(this).val());
	 		showFicha(nameContentId,$(this).val(),'SHOW_REGISTRO');
	 	});

		//Click en el boton NUEVO REGISTRO

	 	$(document).on('click','#'+nameContentId+' .btn-nuevo-registro',function(){
			//alert('ejemplo');
			//$('#ficha-envio form').trigger('reset');

			$("#"+nameContentId+" .valor").each(function(){
				//Asignando a los input su valor correspondiente que se extrae desde mysql php
				$(this).val("");
				//alert($(this).attr('name'));
			});

			$("#"+nameContentId+" .key_value").val('');
		});

			//Click en el boton EDITAR

		$(document).on('click','#'+nameContentId+' .editar-registro',function(){
		 		
		 	//var button = $(event.relatedTarget); // Boton que activo el modal
			//var codigo = button.data('codigo'); // Extract info from data-* attributes

			$.ajax({
				type: "POST",
				url: "query.php",
				data: { 
					TABLA 		: 	$("#"+nameContentId+" .tabla").val(),
					KEY_TABLA 	: 	$("#"+nameContentId+" .key_tabla").val(),
					KEY_VALUE 	: 	$("#"+nameContentId+" .key_value_static").val(),
					CASO 		: 	'SHOW_REGISTRO'
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
						$("#"+nameContentId+" .valor").each(function(){
							for(var i=0;i<objeto.length;i++){
								//Asignando a los input su valor correspondiente que se extrae desde mysql php
								$(this).val(objeto[i][$(this).attr('name')]);
								//alert($(this).attr('name'));
							}
						});
					}
						//$("#respuesta-ficha").html(cadena); 
				}

			});	
		});

		// Evento GUARDAR CAMBIOS 

		$("#"+nameContentId+" .guardarCambios").click(function(){
			//alert(JSON.stringify(extraerValorAtributo('name','valor','content')));
			//alert(JSON.stringify(extraerValorAtributo('placeholder','valor','content')));

			guardarCambios(nameContentId);

		});	

		/*	
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			|																	|
			|					BOOOT INICIO DEL SCRIPT 						|
			|																	|
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  
		*/

		if(keyValueInicial>0){

			
			$("#"+nameContentId+" .key_value").val(keyValueInicial);
			$("#"+nameContentId+" .key_value_static").val(keyValueInicial);
			showFicha(nameContentId,'','SHOW_REGISTRO');

			/**** inicio de listado ***/
			generarListado(nameContentId,keyValueInicial,'SHOW_LISTA_FILTRADO');

	 	}else{

			showFicha(nameContentId,'','SHOW_REGISTRO_DEFECTO');	

			/**** inicio de listado ***/
			generarListado(nameContentId,'','SHOW_LISTA_FILTRADO');		

	 	}

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


 	<!-- el ID ficha-envio determina donde actuara todo el script -->

	<div class="ficha-envio" id="ficha-envio">

	 	<div class="ficha-show">
	 		<div class="panel panel-default">
	 			<div class="panel-heading">
					<a href="#" class="btn btn-success pull-left nuevo-registro btn-nuevo-registro" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-file"></span> Nuevo Registro</a>
					<a href="#" class="btn btn-primary pull-right editar-registro" data-codigo="" data-toggle="modal" data-target="#myModal"><span class='glyphicon glyphicon-th'></span> Editar</a>
	 			</div>
	 			<div class="panel-body">
	 				<div class="selector-direccion">
	 					<select class="cambio-registro form-control" name="direcciones_envio[IDENVIO]"></select>
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

							</form>

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

</body>
</html>