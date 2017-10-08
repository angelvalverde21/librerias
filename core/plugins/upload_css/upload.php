<?php

/*
// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], 'uploads/'.$_FILES['upl']['name'])){
		echo '{"status":"success"}';
		exit;
	}
}

echo '{"status":"error"}';
exit;

	*/
	
	include('../../../config.php');
	include(DIR_CORE."/start.php");	
	// The Demos don't save files


	// In this demo we trigger the uploadError event in SWFUpload by returning a status code other than 200 (which is the default returned by PHP)
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
		
		// Usually we'll only get an invalid upload if our PHP.INI upload sizes are smaller than the size of the file we allowed
		// to be uploaded.
		
		header("HTTP/1.1 500 File Upload Error");
		
		if (isset($_FILES["Filedata"])) {
		
			echo "error al subir";
			echo $_FILES["Filedata"]["error"];
		
		}
		
		exit(0);
	}
	
	session_start();
	$fecha 		= 	fechasql();
	switch($_GET['uploadtype']){

		case'productos':

			$link		=	conectarse();	
			$ARCHIVO	=	uploadarchivos('Filedata');
			$LABEL		=	$_FILES["Filedata"]["name"];	
			$GRUPO		=	$_GET["IDPRODUCTO"];
			$TIPO		=	$_GET["TIPO"];

			mysql_query("insert into ".PREFIX."multimedia (ARCHIVO,LABEL,IDPRODUCTO,TIPO,IDEMPRESA,FECHA) values ('$ARCHIVO','$LABEL','$GRUPO','$TIPO','".$_SESSION['IDEMPRESA']."','$fecha')",$link);	

		break;

		default:

			$link		=	conectarse();	
			$ARCHIVO	=	uploadarchivos('Filedata');
			$LABEL		=	$_FILES["Filedata"]["name"];	
			$GRUPO		=	$_GET["IDPROYECTO"];
			$TIPO		=	$_GET["TIPO"];

			mysql_query("insert into ".PREFIX."proyectos_multimedia (ARCHIVO,LABEL,IDPROYECTO,TIPO,IDEMPRESA,FECHA) values ('$ARCHIVO','$LABEL','$GRUPO','$TIPO','".$_SESSION['IDEMPRESA']."','$fecha')",$link);	

		break;

	}

	
?>