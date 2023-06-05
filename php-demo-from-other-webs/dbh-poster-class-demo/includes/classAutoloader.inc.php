<?php

spl_autoload_register('classAutoload');

function classAutoload($className){
	$path = 'classes/';
	$extensions = '.class.php';
	$fileName = $path . strtolower($className) . $extensions;

	if(!file_exists($fileName)){
		echo 'Cound not found Files';
		var_dump($fileName);
		return false;
	}

	include_once $fileName;

}