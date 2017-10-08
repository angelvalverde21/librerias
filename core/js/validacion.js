		var campos_iniciales = new Array();

		$(".validar_campo").each(function(indice){	
			
			campos_iniciales[indice] = $(this).val();		
			
		});

		//alert(campos_iniciales.length);

		for(j=0;j<campos_iniciales.length;j++){
			//alert(campos_iniciales[j]);
		}

		//elimino la etiqueta si se hace click
		$(".validar_campo").click(function(){
			for(j=0;j<campos_iniciales.length;j++){
				if($(this).val()==campos_iniciales[j]){
					$(this).val("");
					break;
				}	
			}
		});

		$(".validar_campo").focusout(function(){	

			//alert(campos_iniciales.length);
			//alert($(this).index());
			//alert($(".validar_campo").size() + ' : ' +$(this).index());
			
			for(j=0;j<campos_iniciales.length;j++){
				//alert(j +'=='+ $(this).index());
				
				if($(this).val()=="" && j==$(".validar_campo").index(this)){
					$(this).val(campos_iniciales[j]);
				}	
			}
		});