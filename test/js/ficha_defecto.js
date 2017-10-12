
		//config
		//**var nameContentId 	= 'ficha-envio'; //Es la capa donde se desarrollara este script
		//****var idPrincipal 	= 'IDENVIO'; //Es el ID pricinpal de la tabla
		//****var labelSelect 	= 'CONSIGNATARIO'; //es el campo que se mostrara en la herramienta SELECT
		//var keyParent 		= 'IDUSUARIO'; //Es el ID secundario con el que se filtra los datos (WHERE IDUSUARIO='')
		//var keyParentvalue 	= 1; //Se refiere al IDUSUARIO
		//var keyValueInicial = 18; //Se refiere al IDENVIO (IDENVIO es de la tabla primarioa o principal)

		//funciones de uso general
		var showFicha;
		var generarListado;
		var extraerValorAtributo;
		var guardarCambios;
		var iniciarFicha;

	 	generarListado = function(nameContentId,selected='',caso){

	 		var labelSelect = $("#" + nameContentId + " .labelSelect").val();
	 		var idPrincipal = $("#" + nameContentId + " .idPrincipal").val();
	 		var caso;

			$.ajax({

				type: "POST",
				url: "query.php",
				data: { 
					TABLA 				: 	$("#"+nameContentId+" .tabla").val(),
					KEY_PARENT 			: 	$("#"+nameContentId+" .keyParent").val(),
					KEY_PARENT_VALUE 	: 	$("#"+nameContentId+" .keyParentvalue").val(),
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

	 		var idPrincipal = $("#" + nameContentId + " .idPrincipal").val();

			$.ajax({

				type: "POST",
				url: "query.php",
				data: { 
					KEY_PARENT 			: 	$("#"+nameContentId+" .keyParent").val(),
					KEY_PARENT_VALUE 	: 	$("#"+nameContentId+" .keyParentvalue").val(),
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
					KEY_PARENT 	: 	$("#"+nameContentId+" .keyParent").val(),
					KEY_PARENT_VALUE : $("#"+nameContentId+" .keyParentvalue").val()
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

		$(document).on("change",".cambio-registro",function(){

			var nameContentId = $(this).data('contentid');

	 		$("#"+nameContentId+" .key_value").val($(this).val());
	 		$("#"+nameContentId+" .key_value_static").val($(this).val());
	 		showFicha(nameContentId,$(this).val(),'SHOW_REGISTRO');

	 	});

		//Click en el boton NUEVO REGISTRO

	 	$(document).on('click','.btn-nuevo-registro',function(){
			//alert('ejemplo');
			//$('#ficha-envio form').trigger('reset');
			var nameContentId = $(this).data('contentid');

			$("#"+nameContentId+" .valor").each(function(){
				//Asignando a los input su valor correspondiente que se extrae desde mysql php
				$(this).val("");
				//alert($(this).attr('name'));
			});

			$("#"+nameContentId+" .key_value").val('');
		});

			//Click en el boton EDITAR

		$(document).on('click','.editar-registro',function(){

			var nameContentId = $(this).data('contentid');
		 		
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

		$(document).on('click','.guardarCambios',function(){
			//alert(JSON.stringify(extraerValorAtributo('name','valor','content')));
			//alert(JSON.stringify(extraerValorAtributo('placeholder','valor','content')));

			var nameContentId = $(this).data('contentid');

			guardarCambios(nameContentId);

		});	

		/*	
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			|																	|
			|					BOOOT INICIO DEL SCRIPT 						|
			|																	|
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  
		*/

		iniciarFicha = function(nameContentId){

			var nameContentId;
			var keyValueInicial = $("#"+nameContentId+" .key_value_static").val();

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

		}