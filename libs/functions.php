<?php

//recursive function that collects data regarding routes from
//controller files
function detachment_builder($path='..',$cdir,$data=array(), $ctrllist='',$ns='', $level=0){
	$classFile="$path/$cdir/$cdir"."_controller.php";
	$classFile=preg_replace('/^(\/+)/','',$classFile);
	
	if (file_exists($classFile)) {
		$level++;
		include($classFile);
		$lc = new ReflectionClass($cdir.'_controller');
		
		$methods= $lc->getMethods();
			
		$doit=0;
		if ($lc->HasMethod('init')){
		    $staticvars=$lc->GetMEthod('init')->getStaticVariables();			
				if(in_array( "pathpart", $staticvars)){
					$doit=1;
					$ns.=$staticvars["pathpart"].'/';	
				}
		}
        if ($doit==0){ ($cdir != "root") ? $ns.=$cdir.'/': $ns.=""; }
		$ctrllist.=$cdir.'/';

		if ($lc->HasMethod('init')){
		    if ($lc->GetMEthod('init')->getDeclaringClass()->name == $cdir."_controller"){
		        $nr=$lc->GetMEthod('init')->getNumberofParameters();
			    for($i=0;$i<$nr;$i++){$ns.='([^/]*)/';  }
			}
		}
		
		if ($lc->HasMethod('index')){
		    if ($lc->GetMEthod('index')->getDeclaringClass()->name == $cdir."_controller"){
				$nr=$lc->GetMEthod('index')->getNumberofParameters();
				$nstmp=$ns;
				for($i=0;$i<$nr;$i++){$nstmp.='([^/]*)/';  }
				array_push($data,array('level'=>$level, 'ctrl'=>substr($ctrllist,0,-1),'method'=>"index",'url'=>substr($nstmp,0,-1)));
			}
		}
		$classdata=array();
		foreach ($methods as $method){
		    if ($method->getDeclaringClass()->name == $cdir."_controller"){
				if (in_array($method->name, array('init','index'))){
				    $classdata[$method->name]=$method->getNumberofParameters();
					 $data[-1][substr($ctrllist,0,-1)]=$classdata;
				}
				if (strpos($method->name,'_action')!==false){
				    $classdata[substr($method->name,0,-7)]=$method->getNumberofParameters();
					
				    $tmpns=$ns.substr($method->name,0,-7).'/';	
					$nr=$method->getNumberofParameters();
					if ($nr>0){
						for($i=0;$i<$nr;$i++){$tmpns.='[^/]*/';  }
					}
					$data[-1][substr($ctrllist,0,-1)]=$classdata;
					
					array_push($data,array('level'=>$level,'method'=>substr($method->name,0,-7),'ctrl'=>substr($ctrllist,0,-1),'url'=>substr($tmpns,0,-1)));
				}
		    }
		}
	}  else	{ echo "ERROR: $classFile Class does not exist or dir structure compromised!"; die(); }
    
    $newdir=$path."/".$cdir;
    $newdir=preg_replace('/^(\/+)/','',$newdir);
    
    foreach (new DirectoryIterator($newdir) as $file) {
        $tdir=$newdir."/".$file;
        $tdir=preg_replace('/^(\/+)/','',$tdir);
		if (is_dir($tdir)){
		    if (strcmp($file, 'model')==0 || strcmp($file, 'view')==0 || strcmp($file, '.')==0 || strcmp($file, '..')==0  || strcmp($file, '.svn')==0  ) continue;
			$data=detachment_builder($path.'/'.$cdir,$file,$data,$ctrllist,$ns, $level);
		}
    }
	return $data;
}

