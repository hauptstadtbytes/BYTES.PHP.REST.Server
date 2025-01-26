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
use BytesPhp\Rest\Server\Types\Configuration as Configuration;
use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;

//the server (root) class
class Server {

    //private variable(s)
    private ApplicationContext $context;

    private $slimApp = null;

    //constructor method
    function __construct(Configuration $config = null) {

        //parse the (application) settings
        if(is_null($config)){
            $config = new Configuration();
        }

        //create a new (application) context instance
        $this->context = new ApplicationContext($this, $config);

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
        foreach($this->context->endpoints as $route => $instance){

            //register the endpoint handler(s)
            $this->slimApp->map($this->context->configuration->methods,$route,$instance);

        }

        //runs the slim app
        $this->slimApp->run();

    }

}
?>