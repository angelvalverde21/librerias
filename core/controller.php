<?php
	//Detectando caso

	define('DIR_THEME',theme('dir'));
	
	switch($nav[0]){

		//*****  paginas de configuracion ******/
			
			case 'login':
				require(DIR_GLOBAL.'/login.php');
			break;
			
			case 'restore':
				require(DIR_GLOBAL.'/restore_password.php');
			break;
			
			case'logout':
				unset($_SESSION["IDMULTIMEDIA"]);
				unset($_SESSION["IDUSUARIO"]);
				header("location: ".get_option("home"));
				break;
			
			case'procesar':
				require(DIR_CORE.'/procesar.php');
			break;			
			case'procesar_post':
				require(DIR_CORE.'/procesar_post.php');
			break;

		//*****  Paginas admin ******/
			
			case 'usuario':
				require(DIR_USER.'/index.php');
			break;
		
		//*****  Paginas de usuario ******/

		

		//***** Paginas front end (public html) ******/
		
			//pagina de productos
			
			case 'item':
					
				//validando producto

				$post = new productos(quitar_ceros($nav[1]));
			
				if($post->comprobar_item()){
					//test_array($single->campo());
					require(DIR_THEME.'/single.php');
				}else{
					header("location: ".get_option('home')."/producto-no-encontrado");
				}
					
				break;		

			case 'checkout':
				require(DIR_THEME.'/checkout.php');
			break;				

			case 'pedidos':
				require(DIR_THEME.'/pedidos.php');
			break;
			
			case 'search':
				require(DIR_THEME.'/search.php');
			break;

			case 'promo':
				require(DIR_THEME.'/promo.php');
			break;
			
			case 'ticket':
				require(DIR_THEME.'/ticket.php');
				break;			
			
			case 'cart':
				require(DIR_THEME.'/carrito.php');
			break;		
			
			case 'ver':
				require(DIR_THEME.'/mas.php');
			break;	

			case 'ajax':
				require(DIR_THEME.'/ajax.php');
			break;		
						
			case 'ajax_modal_web':
				require(DIR_THEME.'/ajax_modal_web.php');
			break;		
			
			case 'test':
				require(DIR_THEME.'/test.php');
			break;

			case 'comprar':
				require(DIR_THEME.'/comprar.php');
			break;
					
			default:
				if($nav[0]==""){
					require(DIR_THEME.'/index.php');
				}else{
					require(DIR_THEME.'/single.php');
				}
			break;
		
	}

	
	
?>