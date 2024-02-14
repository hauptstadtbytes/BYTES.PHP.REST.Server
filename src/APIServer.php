<?php

//set the namespace
namespace BytesPhp\Rest;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

//the API server (root) class
class APIServer{

    //protected variable(s)
    protected $slimApp = null;

    //constructor method
    function __construct() {

        $this->slimApp = AppFactory::create();
        
    }


    //runs the (slim) server
    function run():void {

        //set the base path (for supporting sub directory locations), see 'https://akrabat.com/running-slim-4-in-a-subdirectory/' for more details
        $this->slimApp->setBasePath((function () {
            $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
            $uri = (string) parse_url('http://a' . $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
            if (stripos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
                return $_SERVER['SCRIPT_NAME'];
            }
            if ($scriptDir !== '/' && stripos($uri, $scriptDir) === 0) {
                return $scriptDir;
            }
            return '';
        })());

        $this->slimApp->get('/test', function (Request $request, Response $response, $args) {
            $response->getBody()->write("Hello world for testing from inside!");
            return $response;
        });
        
        $this->slimApp->get('/', function (Request $request, Response $response, $args) {
            $response->getBody()->write("Root level from inside");
            return $response;
        });

        //runs the slim app
        $this->slimApp->run();

    }

}
?>