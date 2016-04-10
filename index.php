<?php

date_default_timezone_set('America/Vancouver');
$config_name='config.php'; 
 
//setup local overrides for dev puproposes 
if (file_exists('config_local.php')) $config_name='config_local.php';

include $config_name;
$tf = new base_class();

