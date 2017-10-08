<?php 


	class Inventario{
		function __construct(){
			$this->db = new mysql();
		}

		function agregar(){
			$this->db->consulta("UPDATE ayv_stock SET ESTADO='VENDIDO', IDVENTA='".$_POST['KEY']."' WHERE IDPARTNUMBER='".$_POST['IDPARTNUMBER'][$i]."' AND ESTADO='RESERVADO' AND IDVENTA='".$_POST['KEY']."' LIMIT 1");
		}

		function reservar(){

		}


		function levantar_reserva(){

		}

		function salida_almacen(){

		}

		function Stock($IDPARTNUMBER){

			$result = $this->db->consulta("SELECT * FROM ayv_stock WHERE IDPARTNUMBER='".$IDPARTNUMBER."' AND ESTADO='ENALMACEN'");

			return $this->db->contar_consulta($result);
		}


		function Stock_por_almacen($IDPARTNUMBER,$IDALMACEN){

			$result = $this->db->consulta("SELECT * FROM ayv_stock WHERE IDPARTNUMBER='".$IDPARTNUMBER."' AND IDALMACEN='".$IDALMACEN."' AND ESTADO='ENALMACEN'");

			return $this->db->contar_consulta($result);			
		}	

	}
	
	class almacen{
		function __construct(){

			$this->db = new mysql();
			$this->table = 'stock';

		}

		function part_number(){

		}

		function serie(){
			
		}


		function ingresar_item(){
			//Marca el ingreso de algun producto en almacen
		}

		function salida_item(){
			//Marca la salida de los productos en almacen, sin esto no se podra vender nada

		}

		function reservar_item(){
			
		}		

		function reporte(){

		}

		function comprobar_existencia($config){
			//ejemplo de $config
			//$array('KEY'=>'IDMULTIMEDIA','VALUE'=>'7')
			$result = $this->db->consulta("SELECT EXISTENCIA FROM ".PREFIX.$this->table." WHERE ".$config['KEY']."='".$config['VALUE']."' LIMIT 1");
			$row = $this->db->recuperar_array($result);
			if($row['EXISTENCIA']==1){
				return true;
			}else{
				return false;
			}

		}

		function nombres($valor){
			$result_almacen = $this->db->consulta("SELECT * FROM ayv_almacen");
			while($row_almacen = $this->db->recuperar_array($result_almacen)){
				if($valor==$row_almacen['IDALMACEN']){
					$option = $option."<option selected value='".$row_almacen['IDALMACEN']."''>".$row_almacen['NOMBRE']."</option>";
				}else{
					$option = $option."<option value='".$row_almacen['IDALMACEN']."''>".$row_almacen['NOMBRE']."</option>";
				}
				
			} 	
			return $option;	
		}

	}
?>