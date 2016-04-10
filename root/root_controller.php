<?php

class root_controller extends base_controller_class{
 	public $objs;

 	function init(){	    
	   echo "init Method<br>";
 	}
	function index(){
	   echo "index Method<br>";
	}
	function test_action($someVar){
	   echo "test Method<br>";
	   echo  $someVar;
	}
 }
 
 
 

