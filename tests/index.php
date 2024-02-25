<?php

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

//add namespace(s) required from "bytes.php.rest" framework
use BytesPhp\Rest\Server\Server as ApiServer;
use BytesPhp\Rest\Server\Types\Settings as ApplicationSettings;

//add namespace(s) required from 'BYTES.PHP' framework
use BytesPhp\IO\Helpers\IOHelper as IOHelper;

//embed the composer auto-loading
require (__DIR__.'/../vendor/autoload.php');

//create new server settings
$settings = new ApplicationSettings(["SearchPaths" => [__DIR__."/CookBook/Endpoints"]]);

foreach(IOHelper::Files($settings->SearchPaths) as $file) {
    require_once($file);
}

//create a new server instance
$server = new ApiServer($settings);

//runt the server/ handle the request
$server->run();

?>