<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types;

//the appplication settings class
class Settings{

    //private properties
    private array $searchPaths = [];

    //constructur method
    public function __construct(array $data = null) {

        if(!is_null($data)){
            $this->parseFromArray(array_change_key_case($data,CASE_LOWER));
        }

    }

    //(public) getter (magic) method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "searchpaths":
                return $this->searchPaths;
                break;
                
            default:
                return null;
            
        }
        
    }

    //parses the settings from array
    private function parseFromArray(array $data): void {

        if(array_key_exists("searchpaths",$data)){
            $this->searchPaths = $data["searchpaths"];
        }
    }

}
?>