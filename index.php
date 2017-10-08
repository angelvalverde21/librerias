<?php


//************* Reporte de errores php  *********//;
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL);
error_reporting(4181);

session_start();
//*****************************************//;
//incluyendo clases y objetos
if(!(include("config.php"))){echo"Fallo de inclusion de config.php";}

/* carga todas las clases y funciones necesarias para que funcione el sitio web */

if(!(include(DIR_CORE."/start.php"))){echo"Fallo de inclusion de start.php"; exit;}

/********** manejando todas las direcciones **********/
$nav=explode('/',$_GET["nav"]);
/*****************************************************/

//*************** Acceso sin Clave *******************//
if(!(include(DIR_CORE."/controller.php"))){echo"Fallo de inclusion de controller.php"; exit;}


//******************************//
/*
 * $nav[0] = /0
 * $nav[1] = /ejemplo0/1
 * $nav[2] = /ejemplo0/ejemplo2/2
 * 
 * 
 */
?>