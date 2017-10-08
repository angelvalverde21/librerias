////////// -- cordenadas aquarella -- /////////////

	if (navigator.geolocation){
		
		navigator.geolocation.getCurrentPosition(function(objPosition){

			var gps_longitud = objPosition.coords.longitude;
			var gps_latitud = objPosition.coords.latitude;
			var gps_precision = objPosition.coords.accuracy;

		}, function(objPositionError){

			switch (objPositionError.code){
				case objPositionError.PERMISSION_DENIED:
					content= "No se ha permitido el acceso a la posición del usuario.";
				break;
				case objPositionError.POSITION_UNAVAILABLE:
					content = "No se ha podido acceder a la información de su posición.";
				break;
				case objPositionError.TIMEOUT:
					content = "El servicio ha tardado demasiado tiempo en responder.";
				break;
				default:
					content = "Error desconocido.";
				break;
			}

			
			
		}, {
			maximumAge: 75000,
			timeout: 15000
		});
		
	}else{
		 
		content = "Su navegador no soporta la API de geolocalización.";
	}
	
	$("#longitud").val(gps_longitud);
	$("#latitud").val(gps_latitud);
	$("#precision_gps").val(gps_precision);
	

//////////-- fin cordenadas       -- /////////////