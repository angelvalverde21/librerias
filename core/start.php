<?php

	//Carga las principales funciones del sitio
	//Abrimos el directorio del sitio

	//echo "Ingreso a Star.php Correcto -> OK";
	
	$ruta[0]=DIR_CORE."/funciones";
	$ruta[1]=DIR_CORE."/clases";


	for($i=0;$i<count($ruta);$i++){
		$dir=opendir($ruta[$i]);
		while($archivo=readdir($dir)){
			
			if($archivo !="." && $archivo != ".."){	
				$link_ruta=$ruta[$i]."/".$archivo;
				if(file_exists($link_ruta)){
					//echo"El archivo ".$link_ruta." existe <br />";
					require($link_ruta);
				}else{
					//echo"El archivo ".$link_ruta." No existe <br />";
				}
			}
		}
	
	}

	//$link=conectarse(); 
	
	include(DIR_CORE.'/end.php');
?>