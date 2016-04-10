<?php

 class base_controller_class{
 	public $objs;

	function __construct(&$objs){
	   $this->objs = $objs ;
	   $file = $_SERVER["SCRIPT_NAME"];
	   $this->request= $this->objs['request'];
	   session_start(); 
	}
	
	function error_action(){
	   header("HTTP/1.0 404 Not Found");	  
	   echo "error Method";
	}
	
	function debug($data,$label=''){
     echo "<pre>";
     if ($label !='') echo $label;
     print_r($data );
     echo "</pre>";   
	}

 }
