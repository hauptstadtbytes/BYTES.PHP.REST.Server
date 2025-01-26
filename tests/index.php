<?php

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

//add namespace(s) required from "bytes.php.rest" framework
use BytesPhp\Rest\Server\Server as Server;
use BytesPhp\Rest\Server\Types\Configuration as Configuration;

//add namespace(s) required from 'BYTES.PHP' framework
use BytesPhp\IO\Helpers\IOHelper as IOHelper;

//embed the composer auto-loading
require (__DIR__.'/../vendor/autoload.php'); //adjust this line to match your project structure

//create a new server configuration
$config = new Configuration();

$config->searchPaths[] = __DIR__."/CookBook/Endpoints";
$config->endpoints["/v1/hello"] = "BytesPhp\Rest\Server\Tests\CookBook\Endpoints\HelloEndpoint";
$config->methods = ["GET","POST","PUT","PATCH","DELETE","OPTIONS"];

//add (custom) files required
foreach(IOHelper::Files($config->searchPaths) as $file) {
    require_once($file);
}


//create a new server instance
$server = new Server($config);

//runt the server/ handle the request
$server->run();

?>