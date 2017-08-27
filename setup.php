<?php

require_once __DIR__.'/app/initialize.php';

$database = new Controllers\Database();
$database->createTables();