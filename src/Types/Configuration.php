<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types;

//the appplication configuration class
class Configuration{

    //public properties
    public array $searchPaths = []; //e.g. [__DIR__."/CookBook/Endpoints", "<Another Path>"]
    public array $endpoints = [];  //e.g. [[/v1/hello => "BytesPhp\Rest\Server\Tests\CookBook\Endpoints\HelloEndpoint"],[/<workspace>/<endpoint> => <full qualified class name>]]
    public array $methods = []; //e.g. ["GET","POST","PUT","PATCH","DELETE","OPTIONS"]

    //constructur method
    public function __construct(array $data = null) {

        if(!is_null($data)){
            $this->parseFromArray(array_change_key_case($data,CASE_LOWER));
        }

    }

    //parses the settings from array
    private function parseFromArray(array $data): void {

        if(array_key_exists("searchpaths",$data)){
            $this->searchPaths = $data["searchpaths"];
        }

        if(array_key_exists("endpoints",$data)){
            $this->endpoints = $data["endpoints"];
        }

        if(array_key_exists("methods",$data)){
            $this->methods = $data["methods"];
        }
        
    }

}
?>