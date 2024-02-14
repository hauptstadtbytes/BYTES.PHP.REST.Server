<?php

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

//add namespace(s) required from "slim" framework
use BytesPhp\Rest\APIServer as ApiServer;

//embed the composer auto-loading
require __DIR__ . '/../vendor/autoload.php';

$server = new ApiServer();
$server->run();

?>