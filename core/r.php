<?php
	$wmax		=	$_GET['anchura']; 
	$hmax		=	$_GET['hmax']; 
	$nombre		=	$_GET["imagen"]; 
	
	
	//obteniendo los datos de la imagen
	
	$datos		=	getimagesize($_GET["imagen"]); 

	if($datos[2]==1){
		$img = @imagecreatefromgif($nombre);
	} 
	if($datos[2]==2){
		$img = @imagecreatefromjpeg($nombre);
	} 
	if($datos[2]==3){
		$img = @imagecreatefrompng($nombre);
	} 
	
	
	//ancho y alto de la imagen original
	$ancho	= $datos[0];
	$alto	= $datos[1];

	//se obtiene el coeficiente de conversion (ratio)
	
	$ratio		=	$ancho / $alto; 
	
	if($alto>=$ancho){
		$nueva_altura			=	$hmax;
		$nuevo_ancho			=	$ratio*$hmax;
		$posicion_horizontal	=	abs($wmax - $nuevo_ancho)/2;
		$posicion_vertical	=	0;
	}else{
		$nuevo_ancho		=	$wmax;
		$nueva_altura		=	$hmax/$ratio;
		$posicion_vertical	=	abs($nueva_altura - $hmax)/2;
		$posicion_horizontal	=	0;
	}

	//tratando de hacer un cuadrado
	
	$thumb = imagecreatetruecolor($wmax,$hmax); 
	$white = imagecolorallocate($thumb, 255, 255, 255);
	imagefill($thumb, 0, 0, $white);

	
	imagecopyresampled($thumb, $img, $posicion_horizontal, $posicion_vertical, 0, 0, $nuevo_ancho,$nueva_altura, $datos[0], $datos[1]); 
	if($datos[2]==1){header("Content-type: image/gif"); imagegif($thumb);} 
	if($datos[2]==2){header("Content-type: image/jpeg");imagejpeg($thumb);} 
	if($datos[2]==3){header("Content-type: image/png");imagepng($thumb); } 
	
	imagedestroy($thumb);
?>
<?php
	/*$anchura	=	$_GET['anchura']; 
	$hmax		=	$_GET['hmax']; 
	$nombre		=	$_GET["imagen"]; 
	$datos		=	getimagesize($_GET["imagen"]); 

	if($datos[2]==1){
		$img = @imagecreatefromgif($nombre);
	} 
	if($datos[2]==2){
		$img = @imagecreatefromjpeg($nombre);
	} 
	if($datos[2]==3){
		$img = @imagecreatefrompng($nombre);
	} 

	$ratio		=	($datos[0] / $anchura); 
	$altura		=	($datos[1] / $ratio); 
	
	if($altura>$hmax){
		$anchura2	=	$hmax*$anchura/$altura;
		$altura		=	$hmax;
		$anchura	=	$anchura2;
	} 
	
	$thumb = imagecreatetruecolor($anchura,$altura); 
	imagecopyresampled($thumb, $img, 0, 0, 0, 0, $anchura, $altura, $datos[0], $datos[1]); 
	if($datos[2]==1){header("Content-type: image/gif"); imagegif($thumb);} 
	if($datos[2]==2){header("Content-type: image/jpeg");imagejpeg($thumb);} 
	if($datos[2]==3){header("Content-type: image/png");imagepng($thumb); } 
	
	imagedestroy($thumb);*/
?>