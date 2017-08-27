<?php

require_once __DIR__.'/app/initialize.php';

$ping = new Controllers\Ping();
$ping->send();