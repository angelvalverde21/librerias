<?php


function title_productos($parametro){
	$link=conectarse();
	$result = mysql_query("select * from ".PREFIX."productos WHERE IDPRODUCTO='".$parametro."' LIMIT 1",$link);
	$row=mysql_fetch_array($result);
	return $row['TITULO'];
}

function title_page(){

	$link=conectarse();

	if($_GET['c']==""){
		return "Bienvenidos a Aquarella Ropa y Accesorios";
	}else{
		$result = mysql_query("select * from ".PREFIX."productos WHERE IDPRODUCTO='".$_GET['c']."' LIMIT 1",$link);
		$row=mysql_fetch_array($result);
		return $row['TITULO'];
	}
}


function title_index($parametro){
	$titulo = explode('-',$parametro);
	return $titulo[0];
}

function style_web(){
	?>
	<link rel="stylesheet" href="<?php echo theme(); ?>/style/style.css" type="text/css" media="screen" />	
	<link rel="stylesheet" href="<?php echo theme(); ?>/style/style_800.css" type="text/css" media="screen" />	
	<link rel="stylesheet" href="<?php echo theme(); ?>/style/style_600.css" type="text/css" media="screen" />	
	<link rel="stylesheet" href="<?php echo theme(); ?>/style/style_480.css" type="text/css" media="screen" />	
	<link rel="stylesheet" href="<?php echo theme(); ?>/style/style_360.css" type="text/css" media="screen" />	
<?php		
}


function single_upload($parametro){
	if($parametro>0){	
		$link	=	conectarse();
		$result =	mysql_query("select * from ".PREFIX."productos WHERE IDPRODUCTO='".$parametro."' LIMIT 1",$link);
		$row	=	mysql_fetch_array($result);
		return URL_UPLOADS."/grande-".$row['FILE_UPLOAD'];		
	}else{
		return theme()."/images/banner_principal.jpg";			
	}
}

function navegador_movil(){

	// Creamos array de móviles  
	$mobiles = array("iPhone","iPod","Android","webOS","BlackBerry");  

	if ( preg_match('/('.implode('|', $mobiles).')/i', $_SERVER['HTTP_USER_AGENT']) ){
		return true;
	}else{
		return false;
	}
}

function existe_oferta(){

	global $nav;
	$_GET['IDPRODUCTO'] = $nav[1];
	$link = conectarse();

	$result = mysql_query("select * from ayv_promociones WHERE IDPRODUCTO='".$_GET['IDPRODUCTO']."'",$link);

	if(mysql_num_rows($result)>0){
		return true;
	}else{	
		return false;
	}

}



?>