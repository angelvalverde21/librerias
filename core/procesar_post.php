<?php 

switch ($_POST['TIPO']) {
	
	case 'PEDIDO_RAPIDO':

		$pedido = new pedido();	
		$pedido->rapido();
		header("location: ".get_option('home')."/pedidos/".$pedido->codigo_venta()."");

	break;
	
	default:
		# code...
	break;
}

 ?>