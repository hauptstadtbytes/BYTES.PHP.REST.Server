<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types\Context;

//add namespace(s) required from 'Slim' framework
use Psr\Http\Message\ResponseInterface as Response;

//add namespace(s) required from 'BYTES.PHP' framework
use BytesPhp\Reflection\Extensibility\PluginsManager as PluginsManager;
use BytesPhp\IO\FolderInfo as FolderInfo;

//import internal namespace(s) required
use BytesPhp\Rest\Server\Server as Server;
use BytesPhp\Rest\Server\Types\Configuration as Configuration;

//the application context class
class ApplicationContext {

    //private properties
    private Server $server;
    private Configuration $config;

    private array $exInterfaces = ["BytesPhp\Rest\Server\API\IEndpointExtension","BytesPhp\Rest\Server\API\IServiceExtension","BytesPhp\Rest\Server\API\IMiddlewareExtension","BytesPhp\Rest\Server\API\IErrorhandlerExtension"];
    private array $extensions = [];

    //constructur method
    public function __construct(Server $server, Configuration $config) {

        //set the properties
        $this->server = $server;
        $this->config = $config;

        //load the extensions
        $this->loadPlugins($this->config->searchPaths);

    }

    //(public) getter (magic) method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "configuration":
                return $this->config;
                break;

            //case "log":
                //return $this->server->app->getContainer()->get('LoggerInterface::class');
                //break;

            case "extensions":
                return $this->extensions;
                break;

            case "endpoints":
                return $this->getEntpoints();
                break;

            case "services":
                return $this->getServices();
                break;

            case "middlewares":
                return $this->getMiddlewares();
                break;

            case "errorhandler":
                return $this->getErrorHandler();
                break;
                
            default:
                return null;
            
        }
        
    }

    //returns a newly created response object
    public function createNewResponse(): Response {

        return $this->server->app->getResponseFactory()->createResponse();

    }

    //load all plugins found
    private function loadPlugins(array $searchPaths):void {

        //extend the search paths
        $extendedSearchPaths = [];

        foreach($searchPaths as $searchPath) {

            $extendedSearchPaths[] = $searchPath;

            $extendedSearchPaths = array_merge($extendedSearchPaths,FolderInfo::ListFolders($searchPath));
            
        }

        //load the plugins
        $pluginsManager = new PluginsManager(); //create a new plugins manager class instance

        $output = [];

        foreach($this->exInterfaces as $interface){ //loop for each interface known

            $output[$interface] = $pluginsManager->GetPlugins($extendedSearchPaths,$interface);

        }

        $this->extensions = $output;

    }

    //get all enabled endpoint extensions
    private function getEntpoints() {

        $output = [];

        foreach($this->config->endpoints as $route => $className) { //loop for each endpoint definition in the configuration

            foreach($this->extensions["BytesPhp\Rest\Server\API\IEndpointExtension"] as $extension) { //loop for each extension found (in search paths)

                if($extension->name == $className) { //the class names are matching

                    //initialize the entpoint handler class instance
                    $instance = $extension->instance;
                    $instance->Initialize($this,$extension->metadata);

                    //clean the route
                    $cleanRoute = "/".trim($route,"/");

                    //add extension to output
                    $output[$cleanRoute] = $instance;

                }

            }

        }

        return $output;

    }

    //get all enabled services
    private function getServices() {

        $output = [];

        foreach($this->config->services as $name => $className) { //loop for each service definition in the configuration

            foreach($this->extensions["BytesPhp\Rest\Server\API\IServiceExtension"] as $extension) { //loop for each extension found (in search paths)

                if($extension->name == $className) { //the class names are matching

                    //initialize the entpoint handler class instance
                    $instance = $extension->instance;
                    $instance->Initialize($this,$extension->metadata);

                    //add extension to output
                    $output[$name] = $instance;

                }

            }

        }

        return $output;

    }

    //get all enabled middlewares
    private function getMiddlewares() {

        $output = [];

        foreach($this->config->middlewares as $className) { //loop for each middleware definition in the configuration

            foreach($this->extensions["BytesPhp\Rest\Server\API\IMiddlewareExtension"] as $extension) { //loop for each extension found (in search paths)

                if($extension->name == $className) { //the class names are matching

                    //initialize the entpoint handler class instance
                    $instance = $extension->instance;
                    $instance->Initialize($this,$extension->metadata);

                    //add extension to output
                    $output[] = $instance;

                }

            }

        }

        return $output;

    }

    //returns the error handler instance enabled
    private function getErrorHandler() {

        $output = null;

        $className = $this->config->errorHandler;

        foreach($this->extensions["BytesPhp\Rest\Server\API\IErrorhandlerExtension"] as $extension) { //loop for each extension found (in search paths)

            if($extension->name == $className) { //the class names are matching

                //initialize the entpoint handler class instance
                $instance = $extension->instance;
                $instance->Initialize($this,$extension->metadata);

                //add extension to output
                $output = $instance;

            }

        }

        return $output;

    }

}
?>