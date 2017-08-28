<?php

require_once __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use Jenssegers\Blade\Blade;

/*
|--------------------------------------------------------------------------
| Register .env variables
|--------------------------------------------------------------------------
|
| Load all variables from .env file and put them in global
| variables
|
*/
$dotenv = new Dotenv(__DIR__.'/../');
$dotenv->load();

foreach($_ENV as $key => $value) {
	define($key, $value);
}

/*
|--------------------------------------------------------------------------
| Set display errors
|--------------------------------------------------------------------------
|
| Display errors if the application isn't in production
| If the application is in production it'll hide the errors
|
*/
if(ENVIRONMENT == 'production') {
	error_reporting(0);
	ini_set("display_errors", "0");
} else {
	error_reporting(E_ALL);
	ini_set("display_errors", "1");
}

/*
|--------------------------------------------------------------------------
| Register blade
|--------------------------------------------------------------------------
|
| Setup the blade templating engine
|
*/
$views = __DIR__.'/views';
$cache = __DIR__.'/cache';

$blade = new Blade($views, $cache);
$GLOBALS['blade'] = $blade;