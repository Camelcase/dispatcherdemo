<?php
    require_once("libs/base_controller_class.php");
    class base_class{
		private static $a_map ="";
		private static $cpath ="";
		
        function __construct(){
			 self::$a_map=detachment_builder('','root');
			 $this->url_deconstruct();
        }
        function url_deconstruct(){
			$url_parts = array();
			$url='';	
			if (isset($_REQUEST['uri'])) $url=$_REQUEST['uri'];	  
			$url_parts = explode('/', $url);
			$valid=-1;
	
			for ($i=0;$i<(count(self::$a_map)-1);$i++){
				$regex='#^'.self::$a_map[$i]['url'].'(/|)+$#i';
				if (preg_match($regex,$url)) $valid=$i;		
			}
			if ($valid==-1) {	   
				self::$cpath='root';                  
				$obj=new root_controller($this->objs);         
				$obj->error_action();
			} else {
				$cmr=self::$a_map[$valid]['level'];
				$contr=explode('/',self::$a_map[$valid]['ctrl']);
				$contr_path='';
				$param_count=-1;
				for ($i=0;$i<count($contr);$i++){
				   $param_count++;
				   if ($i>0) $contr_path.='/';
				   $contr_path.=$contr[$i];
				   
				   self::$cpath=$contr_path;
				   $classname=$contr[$i].'_controller';
				   $obj=new $classname($this->objs);
				   $lastc=$i;
	   
				   if (self::$a_map[-1][$contr_path]){				
					  if (in_array('init',self::$a_map[-1][$contr_path])) {
						 $args=array();
						 for ($j=0;$j<self::$a_map[-1][$contr_path]['init'];$j++){
							$param_count++;
							$args[$j]=$url_parts[$param_count-1];
						 }
						 call_user_func_array(array($obj,'init'),$args);
					  }
				   }			
				}
				$method=self::$a_map[$valid]['method'];
				if ($method!='init'){
				   $args=array();
				   if ($method=='index') $param_count--;
				   for ($j=0;$j<self::$a_map[-1][$contr_path][$method];$j++){
					  $param_count++;
					  $args[$j]=$url_parts[$param_count];
				   }
				   if ($method!='index') $method.='_action';
				   call_user_func_array(array($obj,$method),$args);
				}
			}
		}
	
		function debug($data){
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
	 
		public static function autoloader($className) {     
		   $dclassname = $className;
		   $className = strtolower($className);
		   
		   if (strpos($className,'_controller') != false) $classFile=self::$c_map[$className]['file'];
		   if (file_exists($classFile)) {
				 include($classFile);
		   }  else	{
			  die(print_r("Autoload ERROR: $className not found!"));
		   }
		}
    }