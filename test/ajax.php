<?php 

    //echo session_status();
	error_reporting(4181);

	//*****************************************//
	require("../config.php");
	/* carga todas las clases y funciones necesarias para que funcione el sitio web */
	require(DIR_CORE."/start.php");


	$campos 	= $_POST['CAMPOS'];
	$valores 	= $_POST['VALORES'];

	//El programa necesita un UPDATE
	for($i=0;$i<count($campos);$i++){

		//if($editar[$i]=="si"){
			$campos_sql 	.= $campos[$i].",";
			$valores_sql	.= "'".$valores[$i]."',";
			$update_sql 	.= $campos[$i]."='".$valores[$i]."',";
		//}
	}

	$valores_sql 	.= "'".fechasql()."'";
	$update_sql 	= $update_sql."DEFECTO='1'";


	$cadena_sql_defecto = "UPDATE ".PREFIX.$_POST['TABLA']." SET DEFECTO='0' WHERE ".$_POST['KEY_PARENT']."='".$_POST['KEY_PARENT_VALUE']."' LIMIT 100";
		
	$db->consulta($cadena_sql_defecto);


	if($_POST['KEY_VALUE']>0){

		$cadena_sql = "UPDATE ".PREFIX.$_POST['TABLA']." SET $update_sql WHERE ".$_POST['KEY_TABLA']."='".$_POST['KEY_VALUE']."' LIMIT 1";
		
		$result = $db->consulta($cadena_sql);

		if (!$result){
			//ECHO $cadena_sql,$link;
			echo '{"ESTADO":"ERROR","MENSAJE": "Hay un error en la sintaxis mysql, revisar los campos de la tabla si son correctos con los del modal o asegurese que editar=\'Si\' este activo","KEY_VALUE","undefined","CADENA SQL":"'.$cadena_sql.'","TIPO_CONSULTA":"update_error"}';
							//die(mysql_error());
		}else{
			echo '{"ESTADO":"CORRECTO","MENSAJE": "la consulta a sido un UPDATE","KEY_VALUE":"'.$_POST['KEY_VALUE'].'","TIPO_CONSULTA":"UPDATE","CADENA SQL":"'.$cadena_sql.'"}';
		}

	}else{

		$cadena_sql = "INSERT INTO ".PREFIX.$_POST['TABLA']." (".$campos_sql."FECHA,DEFECTO) VALUES ($valores_sql,'1')";

		$result = $db->consulta($cadena_sql);	

		if (!$result){
			//ECHO $cadena_sql,$link;

			echo '{"ESTADO":"ERROR","MENSAJE": "Hay un error en la sintaxis mysql, revisar los campos de la tabla si son correctos con los del modal","KEY_VALUE":"undefined","CADENA SQL":"'.$cadena_sql.'","TIPO_CONSULTA":"INSERT"}';
						//die(mysql_error());
		}else{

			
				echo '{"ESTADO":"CORRECTO","MENSAJE":"la consulta a sido un INSERT","KEY_VALUE":"'.mysql_insert_id().'","TIPO_CONSULTA":"INSERT","CADENA SQL":"'.$cadena_sql.'"}';
			
		}

	}

?>