<?php

require_once __DIR__.'/app/initialize.php';

/*
|--------------------------------------------------------------------------
| Check Controller and Method
|--------------------------------------------------------------------------
|
| Check if the controller and the method exist.
| If they do not exists they will default to Error::notFound()
|
*/
$controller	= isset($_GET['controller'])	? $_GET['controller']	: 'Index';
$method		= isset($_GET['method'])		? $_GET['method']		: 'index';

$className = '\Controllers\\'.$controller;

if(!class_exists($className) || !method_exists($className, $method)) {
	$className = '\Controllers\Error';
	$method = 'notFound';
}

/*
|--------------------------------------------------------------------------
| Display view
|--------------------------------------------------------------------------
|
| Call the controller and method specified by the variables and
| display the result
|
*/
$class = new $className();
echo $class::$method();