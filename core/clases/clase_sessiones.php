<?php 

class session_usuario{
	function __construct($IDUSUARIO){

		$db = new mysql();

		$result = $db->consulta("SELECT * FROM ayv_usuarios WHERE IDUSUARIO='".$IDUSUARIO."' LIMIT 1");
		$this->row 	= $db->recuperar_array($result);

	}

	function codigo(){
		return $this->row['IDUSUARIO'];
	}

	function nombre(){
		return $this->row['NOMBRE'];
	}

	function apellidos(){
		return $this->row['APELLIDOS'];
	}

	function email(){
		return $this->row['EMAIL'];
	}

	function celular(){
		return $this->row['CELULAR'];
	}	

	function dni(){
		return $this->row['DNI'];
	}	

	function nivel(){
		return $this->row['NIVEL'];
	}



}	

?>