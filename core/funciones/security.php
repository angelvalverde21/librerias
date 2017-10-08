<?php

function post($_Cadena) {
	$link = conectarse();
	$_Cadena = htmlspecialchars(trim(addslashes(stripslashes(strip_tags($_Cadena)))));
	$_Cadena = str_replace(chr(160),'',$_Cadena);
	
	return mysql_real_escape_string($_Cadena,$link);
}

function revisar_post($_Cadena) {
	$link = conectarse();
	$_Cadena = htmlspecialchars(trim(addslashes(stripslashes(strip_tags($_Cadena)))));
	$_Cadena = str_replace(chr(160),'',$_Cadena);
	
	return mysql_real_escape_string($_Cadena,$link);
}

function get($cadena){
	if (isset($cadena)) {
		$name = $cadena;
	} else {
		$name = "";
	}	
	
	return $name;
}

function limpiar_tags($tags){
	$tags = strip_tags($tags);
	$tags = stripslashes($tags);
	$tags = htmlentities($tags);
	return $tags;
}

function aleatorio($length=6,$uc=FALSE,$n=TRUE,$sc=FALSE)
{
	$source = 'abcdefghijklmnopqrstuvwxyz';
	if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	if($n==1) $source .= '1234567890';
	if($sc==1) $source .= '|@#~$%()=^*+&#91;&#93;{}-_';
	if($length>0){
		$rstr = "";
		$source = str_split($source,1);
		for($i=1; $i<=$length; $i++){
			mt_srand((double)microtime() * 1000000);
			$num = mt_rand(1,count($source));
			$rstr .= $source&'#91';$num-1&'#93;';
		}

	}
	return $rstr;
}

function get_key($ID=""){
	//$a=255464;
	//$a=$_GET["a"];
	//$a=10000000000000+$a;
	//formando a $a con los datos de fecha
	/*$hora	=	date("H");
	 $minutos	=	date("i");
	 $segundos	=	date("s");
	 $dia	=	date("d");
	 $mes	=	date("m");
	 $ano	=	date("Y");

	 $generakey=$segundos.$minutos.$hora.$dia.$mes.$ano;
	 $a=$generakey+$id_insertado;*/

	/************** Inicio Clave de codigo *********************/
	$key[31]	="A";
	$key[8]		="B";
	$key[18]	="C";
	$key[13]	="D";
	$key[29]	="E";
	$key[4]		="F";
	$key[17]	="G";
	$key[27]	="H";
	$key[1]		="I";
	$key[32]	="J";
	$key[15]	="K";
	$key[3]		="L";
	$key[23]	="M";
	$key[0]		="N";
	$key[22]	="O";
	$key[10]	="P";
	$key[5]		="Q";
	$key[2]		="R";
	$key[28]	="S";
	$key[30]	="T";
	$key[12]	="U";
	$key[33]	="V";
	$key[26]	="W";
	$key[11]	="X";
	$key[20]	="Y";
	$key[14]	="Z";
	$key[35]	="1";
	$key[34]	="2";
	$key[7]		="3";
	$key[24]	="4";
	$key[16]	="5";
	$key[21]	="6";
	$key[6]		="7";
	$key[19]	="8";
	$key[25]	="9";
	$key[9]		="0";
	/************** Fin Clave de codigo *********************/

	$tiempo =	explode(" ",microtime());
	$cadena	=	$tiempo[1].$tiempo[0];
	$a	=	str_replace('.','',$cadena);
	$a	=	$ID.$a;
	$b=35;

	do {
		$i=$i+1;
		$q=floor($a/$b);
		$number[$i]=$a-$q*$b;
		$a=$q;
	}
	while ($q>=$b);

	$total=count($number);
	$keyalfanumerico=$key[$q];
	for($i=0;$i<$total;$i++){
		$j=$total-$i;
		$valor=$number[$j];
		$keyalfanumerico=$keyalfanumerico.$key[$valor];
	}
	return $keyalfanumerico;
}

?>