<?php

function mostrar_galeria(){


	$ESTADO[1]="SI";
	$ESTADO[2]="NO";

	return $ESTADO;
}

function estados_pedidos_array(){

	/*$ESTADO[0]="Esperando Revisi&oacute;n";
	 $ESTADO[1]="Esperando Pago";
	 $ESTADO[2]="Listo para ser enviado";
	 $ESTADO[3]="Entregado";
	 $ESTADO[4]="En proceso de Empaque";
	 $ESTADO[5]="Sin stock, Contactar al Servicio al cliente";
	 $ESTADO[6]="Revisado por atencion al cliente";
	 $ESTADO[7]="Cancelado";
	 $ESTADO[8]="No se pudo contactar al cliente";*/

	$ESTADO[0]="Esperando Revisi&oacute;n";
	$ESTADO[1]="Esperando Pago";
	$ESTADO[2]="Listo para ser enviado";
	$ESTADO[3]="Entregado";
	$ESTADO[7]="Cancelado";
	$ESTADO[9]="Pendiente de entrega";
	$ESTADO[10]="Devuelto";
	return $ESTADO;
}


function tipopago($parametro=""){

	$repartidor[1]="Contraentrega";
	$repartidor[2]="Deposito Agente Bcp";
	$repartidor[3]="Tarjeta de Credito";
	$repartidor[4]="Paypal";
	$repartidor[5]="Online (Visa)";

	if($parametro>0){
		return $repartidor[$parametro];
	}else{
		return $repartidor;
	}

}


function metodopago($key=0,$mostrar=false){

	$ESTADO[1]="CONTRA ENTREGA";
	$ESTADO[2]="TRANSFERENCIA BCP";

	if($mostrar){
		return $ESTADO[$key];
	}else{
		echo"<option value='0'>ESCOGER</option>";
		for($i=1;$i<=count($ESTADO);$i++){
			if($key==$i){
				echo "<option selected value='".$i."'>".$ESTADO[$i]."</option>\n";
				$selected="";
			}else{
				echo "<option value='".$i."'>".$ESTADO[$i]."</option>\n";
			}
		}
	}
}


function enstock($key=0,$mostrar=false){

	$ESTADO[0]="NO";
	$ESTADO[1]="SI";

	if($mostrar){
		return $ESTADO[$key];
	}else{
		for($i=0;$i<count($ESTADO);$i++){
			if($key==$i){
				echo "<option selected value='".$i."'>".$ESTADO[$i]."</option>\n";
				$selected="";
			}else{
				echo "<option value='".$i."'>".$ESTADO[$i]."</option>\n";
			}
		}
	}
}


function transporte(){
	$repartidor[1]="COURIER";
	$repartidor[2]="PROPIO";
	return $repartidor;
}

function medio_pedido($parametro=""){
	$repartidor[1]="FACEBOOK";
	$repartidor[2]="WHATSAPP";
	$repartidor[3]="MERCADOLIBRE";
	$repartidor[4]="OLX";
	$repartidor[5]="RECOMENDADO";
	$repartidor[6]="OTROS";
	$repartidor[7]="REGISTRO_PROPIO";

	if($parametro>0){
		return $repartidor[$parametro];
	}else{
		return $repartidor;

	}
}

function cuenta_bcp(){
	$cuenta = "192-25029318-0-38";
	return $cuenta;
}

function cliente_personalidad(){


	$ESTADO[1]="GENTIL Y CONFIADA";
	$ESTADO[2]="GENTIL PERO DESCONFIADA";
	$ESTADO[3]="ESPESA";

	return $ESTADO;
}

function cliente_revisa(){


	$ESTADO[2]="NO";
	$ESTADO[1]="SI";

	return $ESTADO;
}

function cliente_pidio_novedades(){


	$ESTADO[2]="NO";
	$ESTADO[1]="SI";

	return $ESTADO;
}


function cliente_se_prueba(){

	$ESTADO[2]="NO";
	$ESTADO[1]="SI";

	return $ESTADO;
}


function cliente_dejo_encargado(){

	$ESTADO[2]="NO";
	$ESTADO[1]="SI";

	return $ESTADO;
}

function oversale(){


	$ESTADO[1]="SI";
	$ESTADO[2]="NO";

	return $ESTADO;
}


function showcolor(){


	$ESTADO[1]="SI";
	$ESTADO[2]="NO";

	return $ESTADO;
}


function showproducto(){


	$ESTADO[1]="SI";
	$ESTADO[2]="NO";

	return $ESTADO;
}

function estado_producto($parametro=""){

	$ESTADO[1]="Normal";
	$ESTADO[2]="Defectuoso (Vendible)";
	$ESTADO[3]="Malogrado (No vendible)";

	if($parametro==""){
		return $ESTADO;
	}else{
		return $ESTADO[$parametro];
	}

}

function existencia_producto($parametro=""){

	$ESTADO[1]="En Almacen";
	$ESTADO[0]="Fuera de Almacen";

	if($parametro==""){
		return $ESTADO;
	}else{
		return $ESTADO[$parametro];
	}

}


?>