<?php
 class manage_controller extends base_controller_class{
 	public $objs;

 	function init(){	    
	   echo "manage init Method<br>";
 	}
	function index(){
	   echo "manage index Method<br>";
	}
	function test_action($someVar){
	   echo "manage test Method<br>";
	   echo  $someVar;
	}
  
 }
 
 
 

