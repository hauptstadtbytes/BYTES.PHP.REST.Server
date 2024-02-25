<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types;

//add namespace(s) required from 'BYTES.PHP' framework
use BytesPhp\Reflection\Extensibility\ExtensionsManager as ExtensionsManager;

//import internal namespace(s) required
use BytesPhp\Rest\Server\Server as APIServer;
use BytesPhp\Rest\Server\Types\Settings as ApplicationSettings;

//the appplication context class
class ApplicationContext{

    //private properties
    private APIServer $server;
    private ApplicationSettings $settings;

    private array $exInterfaces = ["BytesPhp\Rest\APIServer\API\EndpointExtensionInterface"];
    private array $extensions = [];

    //constructur method
    public function __construct(APIServer $server, ApplicationSettings $settings) {

        //set the properties
        $this->server = $server;
        $this->settings = $settings;

        //load the extensions
        $this->loadExtensions($this->settings->searchPaths);

    }

    //(public) getter (magic) method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "settings":
                return $this->settings;
                break;

            case "extensions":
                return $this->extensions;
                break;

            case "supportedmethods":
                return ["GET","POST","PUT","PATCH","DELETE","OPTIONS"];
                break;
                
            default:
                return null;
            
        }
        
    }

    //load all extensions (found)
    private function loadExtensions(array $searchPaths):void {

        $exManager = new ExtensionsManager(); //create a new extensions manager class instance

        $output = [];

        foreach($this->exInterfaces as $interface){ //loop for each interface known

            $data = ["all" => [], "enabled" => []];

            $data["all"] = $exManager->GetExtensions($searchPaths,$interface, array("enabled" => null));

            foreach($data["all"] as $extension){

                if(strtolower($extension->metadata->enabled) == "true"){ //check if the extension is enabled

                    switch($interface) {

                        case "BytesPhp\Rest\APIServer\API\EndpointExtensionInterface":
                            if($extension->metadata->ContainsKey("route")){
                                $data["enabled"][] = $extension;
                            }
                            break;

                        default:
                        $data["enabled"][] = $extension;
                    }
            
                }
            
            }

            $output[$interface] = $data;

        }

        $this->extensions = $output;

    }

}
?>