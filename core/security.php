<?php
	if(login()){
		//echo "exito";
	}else{
		//echo "error";
		header("location: ".get_option('home')."/login?redirect=".urlencode(redirect()));
		exit();
	}
?>