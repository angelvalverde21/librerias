<?php


	$AYV['url']['scheme']			= 'http://';
	$AYV['url']['domain']			= '192.168.2.100';
	$AYV['url']['folder']			= '/librerias';
	$AYV['url_global']['system'] 	= $AYV['url']['scheme'].$AYV['url']['domain'].$AYV['url']['folder'];
		
	/* perfil de database */
		
	$AYV['db']['user']		=	'root';
	$AYV['db']['pass']		=	'root';
	$AYV['db']['name']		=	'test';
	$AYV['db']['host']		=	'localhost';
	
	define("PREFIX"	,'ayv_');
	
	/* carpetas del sitio */
	
	$AYV['carpeta']['admin']	=	'/admin5241';		
	$AYV['carpeta']['core']		=	'/core';		
	$AYV['carpeta']['uploads']	=	'/uploads';	
	$AYV['carpeta']['user']		=	'/usuario';		
	$AYV['carpeta']['web']		=	'/web';	
	$AYV['carpeta']['plugin']	=	'/plugins';	
	$AYV['carpeta']['global']	=	$AYV['carpeta']['core'].'/global';	

	/* url absolutas del sistema */
	
	define("URL_ADMIN"	, $AYV['url_global']['system'].$AYV['carpeta']['admin']);
	define("URL_USER"	, $AYV['url_global']['system'].$AYV['carpeta']['user']);
	define("URL_CORE"	, $AYV['url_global']['system'].$AYV['carpeta']['core']);
	define("URL_UPLOADS", $AYV['url_global']['system'].$AYV['carpeta']['uploads']);
	define("URL_WEB"	, $AYV['url_global']['system'].$AYV['carpeta']['web']);	
	define("URL_PLUGIN"	, $AYV['url_global']['system'].$AYV['carpeta']['core'].$AYV['carpeta']['plugin']);	
	define("URL_GLOBAL"	, $AYV['url_global']['system'].$AYV['carpeta']['global']);	

	/* carpetas absolutas del sistema */
	
	
	$AYV['carpeta_global']['system'] 	=	$_SERVER["DOCUMENT_ROOT"].$AYV['url']['folder'];
	
	define("DIR_ADMIN"	, $AYV['carpeta_global']['system'].$AYV['carpeta']['admin']	);
	define("DIR_USER"	, $AYV['carpeta_global']['system'].$AYV['carpeta']['user']);
	define("DIR_CORE"	, $AYV['carpeta_global']['system'].$AYV['carpeta']['core']);
	define("DIR_PLUGIN"	, $AYV['carpeta_global']['system'].$AYV['carpeta']['core'].$AYV['carpeta']['plugin']);
	define("DIR_UPLOADS", $AYV['carpeta_global']['system'].$AYV['carpeta']['uploads']);	
	define("DIR_WEB"	, $AYV['carpeta_global']['system'].$AYV['carpeta']['web']);	
	define("DIR_GLOBAL"	, $AYV['carpeta_global']['system'].$AYV['carpeta']['global']);	

	$AYV['hash']['salt']	= '97424'; /* puede ser cualquier cadena o numero */

	/* perfil del sitio */
	
	$AYV['maintenance']= 0;	
?>