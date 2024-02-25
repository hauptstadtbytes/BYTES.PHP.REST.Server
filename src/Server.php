<?php

//set the namespace
namespace BytesPhp\Rest\Server;

//add namespace(s) required from 'slim' framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

//add namespace(s) required from 'BYTES.PHP' framework
use BytesPhp\IO\Helpers\IOHelper as IOHelper;

//import internal namespace(s) required
use BytesPhp\Rest\Server\Types\Settings as ApplicationSettings;
use BytesPhp\Rest\Server\Types\ApplicationContext as ApplicationContext;

//the API server (root) class
class Server{

    //private variable(s)
    private $slimApp = null;

    private ApplicationContext $context;

    //constructor method
    function __construct(ApplicationSettings $settings = null) {

        //parse the (application) settings
        if(is_null($settings)){
            $settings = new ApplicationSettings();
        }

        //create a new (application) context instance
        $this->context = new ApplicationContext($this, $settings);

        //create a new 'slim' application instance
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

        //register all endpoint extensions
        foreach($this->context->extensions["BytesPhp\Rest\APIServer\API\EndpointExtensionInterface"]["enabled"] as $extension){

            //initialize the entpoint handler class instance
            $instance = $extension->instance;
            $instance->Initialize($this->context,$extension->metadata);

            //calculate the route
            $route = "/".trim($extension->metadata->route,"/");

            if($extension->metadata->ContainsKey("workspace")){
                $route = "/".trim($extension->metadata->workspace,"/")."/".trim($extension->metadata->route,"/");
            }

            //register the endpoint handler
            $this->slimApp->map($this->context->supportedmethods,$route,$instance);

        }

        //runs the slim app
        $this->slimApp->run();

    }

}
?>