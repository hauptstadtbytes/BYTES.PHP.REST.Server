<?php

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

//add namespace(s) required from "bytes.php.rest" framework
use BytesPhp\Rest\Server\Server as Server;
use BytesPhp\Rest\Server\Types\Configuration as Configuration;

//add namespace(s) required from 'BYTES.PHP' framework
use BytesPhp\IO\FolderInfo as FolderInfo;

//embed the composer auto-loading
require (__DIR__.'/../vendor/autoload.php'); //adjust this line to match your project structure

//create a new server configuration
$config = new Configuration();

$config->searchPaths = [__DIR__."/CookBook/Endpoints",__DIR__."/CookBook/Services",__DIR__."/../src/Implementations/Middleware",__DIR__."/../src/Implementations/ErrorHandler"];

$config->endpoints["/v1/hello"] = "BytesPhp\Rest\Server\Tests\CookBook\Endpoints\HelloEndpoint";
$config->endpoints["/v1/hello/{id}"] = "BytesPhp\Rest\Server\Tests\CookBook\Endpoints\HelloEndpoint"; //re-assign the endpoint with "id" route argument, see "https://www.slimframework.com/docs/v2/routing/params.html" for details
$config->endpoints["/v1/secure"] = "BytesPhp\Rest\Server\Tests\CookBook\Endpoints\SecureEndpoint"; //a reference implementation of a "header-secured" endpoint

$config->endpoints["/v1/dbitems"] = "BytesPhp\Rest\Server\Tests\CookBook\Endpoints\DBItemsEndpoint";

$config->services["db"] = "BytesPhp\Rest\Server\Tests\CookBook\Services\DBService";
$config->services["auth"] = "BytesPhp\Rest\Server\Tests\CookBook\Services\AuthService"; //a sample service for the "header-secured" endpoint

$config->middlewares = ["BytesPhp\Rest\Server\Implementations\Middleware\TrailingSlashMiddleware","BytesPhp\Rest\Server\Implementations\Middleware\CORSMiddleware"]; //enable i.e. the CORs middleware

$config->methods = ["GET","POST","PUT","PATCH","DELETE","OPTIONS"];

$config->arguments["db"] = ["host" => "localhost", "collection" => "d0429d27", "user" => "d0429d27", "password" => "ogUZwy9WbDnvmesqZEBJ"];
$config->arguments["cors"] = ["origin" => "*", "headers" => "X-Requested-With, Content-Type, Accept, Origin, Authorization"]; //setup CORS

//add (custom) files required
foreach($config->searchPaths as $searchPath) {

    foreach(FolderInfo::ListFiles($searchPath) as $file) {
        require_once($file);
    }

}

//create a new server instance
$server = new Server($config);

//runt the server/ handle the request
$server->run();

?>