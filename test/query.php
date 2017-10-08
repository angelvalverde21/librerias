<?php 

    //echo session_status();
	error_reporting(4181);

	//*****************************************//
	require("../config.php");
	/* carga todas las clases y funciones necesarias para que funcione el sitio web */
	require(DIR_CORE."/start.php");

	//consultas para mostrar registros

	if($_POST['KEY_VALUE']>0){
		$result = $db->consulta("SELECT * FROM ".PREFIX.$_POST['TABLA']." WHERE ".$_POST['KEY_TABLA']."='".$_POST['KEY_VALUE']."' LIMIT 1");
		$row = $db->recuperar_array($result);
		echo json_encode($row,JSON_UNESCAPED_UNICODE);
	}else{
		if($_POST['KEY_VALUE']==""){
			if($_POST['KEY_PARENT']<>"" AND $_POST['KEY_PARENT_VALUE']>0){
				$result = $db->consulta("SELECT * FROM ".PREFIX.$_POST['TABLA']." WHERE ".$_POST['KEY_PARENT']."='".$_POST['KEY_PARENT_VALUE']."' AND DEFECTO='1' LIMIT 1");
				while($row = $db->recuperar_array($result)){
					$array[]=$row;
				}

				echo json_encode($array,JSON_UNESCAPED_UNICODE);
			}else{
				echo "Ninguna Opcion disponible";
			}
		}else{
			if($_POST['KEY_PARENT']<>"" AND $_POST['KEY_PARENT_VALUE']>0){
				$result = $db->consulta("SELECT * FROM ".PREFIX.$_POST['TABLA']." WHERE ".$_POST['KEY_PARENT']."='".$_POST['KEY_PARENT_VALUE']."' LIMIT 10");
				while($row = $db->recuperar_array($result)){
					$array[]=$row;
				}

				echo json_encode($array,JSON_UNESCAPED_UNICODE);
			}else{
				echo "Ninguna Opcion disponible";
			}			
		}
	}

?>