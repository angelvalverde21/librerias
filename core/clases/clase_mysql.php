<?php 

	class mysql{
		function __construct(){
			$this->link = conectarse();
		}

		function consulta($consulta){

			return mysql_query($consulta,$this->link);

		}

		function query($consulta){
			return mysql_query($consulta,$this->link);
		}

		function consulta_mysql($consulta){
			return mysql_query($consulta,$this->link);
		}	

		function recuperar_array($result){
			return mysql_fetch_array($result);
		}

		function contar_consulta($result){
			return mysql_num_rows($result);
		}

		function ultimo_id_insertado(){
			return mysql_insert_id();
		}
	}
?>