<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types;

//add namespaces required from 'Slim' framework
use Psr\Http\Message\ServerRequestInterface as Request;

//the request context class
class RequestContext{

    //private properties
    private Request $request;
    private array $arguments = [];

    //constructor method
    public function __construct(Request $req, array $args = null) {

        $this->request = $req;

        if(!is_null($args)){
            $this->arguments = $args;
        }

    }

    //public getter method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "request":
                return $this->request;
                break;

            case "queries":
                return $this->GetQueries($this->request);
                break;

            case "arguments":
                return $this->arguments;
                break;
            
            case "headers":
                return $this->request->getHeaders();
                break;

            case "uri":
                return $this->request->getUri(); //see 'https://www.slimframework.com/docs/v4/objects/request.html' and 'https://discourse.slimframework.com/t/how-to-get-all-parameters-from-link/2003' for reference
                break;

            case "method":
                return $this->request->getMethod();
                break;
                
            default:
                return null;
            
        }
        
    }

    //returns the (parsed) request body
    public function GetBody(bool $returnJSON = true){

        if($returnJSON){
            return json_decode($this->request->getBody(),true);
        } else {
            return $this->request->getBody();
        }

    }

    //returns a list of URL queries used
    protected function GetQueries(Request $request): array {

        $output = [];

        $queryString = $request->getUri()->getQuery();

        if(!empty($queryString)){

            foreach(explode("&",$queryString) as $subString){

                $parts = explode("=",$subString);

                $val = "";
                if(count($parts) >= 2){
                    $val = $parts[1];
                }

                $output[$parts[0]] = $val;

            }
        }

        return $output;

    }

}
?>