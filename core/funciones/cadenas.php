<?php
function quitar_ultimos_caracteres($cad,$cantidad_caracteres=1){
	$tamano = strlen($cad);
	$tamano_cortado = $tamano - $cantidad_caracteres;
	$cortado = substr($cad,0,$tamano_cortado);
	return $cortado;
}

function cadena_recta($cadena){
	return eregi_replace("[\n|\r|\n\r]", ' ', $cadena);
}

?>