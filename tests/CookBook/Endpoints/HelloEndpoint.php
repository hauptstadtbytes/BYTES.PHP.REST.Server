<?php
//set the namespace
namespace BytesPhp\Rest\Server\Tests\CookBook\Endpoints;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//add namespace(s) required from server package
use BytesPhp\Rest\Server\Types\Extension\EndpointExtension as EndpointExtension;

use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;
use BytesPhp\Rest\Server\Types\Context\ResponseContext as ResponseContext;

/**
 * @decription a simple 'hello world' endpoint extension
 */
class HelloEndpoint extends EndpointExtension {

    //handles the GET request
    function HandleGETRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        //get the request queries and set the output format
        $outputFormat = "json";

        $queries = $reqContext->queries;

        if(array_key_exists("format",$queries)){
            $outputFormat = $queries["format"];
        }

        switch(strtolower($outputFormat)) {
            case "json":
                //create a new timestamp
                $timestamp = new \DateTime("now", new \DateTimeZone("UTC")); //see 'https://stackoverflow.com/questions/8655515/get-utc-time-in-php' for reference

                //return the output value
                return $resContext->GetJSONResponse(['status' => ["successful" => true, "message" => "Hello world!"], 'metadata' => ["host" => $reqContext->host, "path" => $reqContext->path, "method" => $reqContext->method, "timestamp" => $timestamp->format(\DateTime::RFC850)], "payload" => []]);
                break;

            case "html":
                return $resContext->GetHTMLResponse("<h1>Hello</h1><p>...world!</p>");
                break;

            default:
                //create a new timestamp
                $timestamp = new \DateTime("now", new \DateTimeZone("UTC")); //see 'https://stackoverflow.com/questions/8655515/get-utc-time-in-php' for reference

                //return the output value
                return $resContext->GetJSONResponse(['status' => ["successful" => false, "message" => "Format Unkown"], 'metadata' => ["host" => $reqContext->host, "path" => $reqContext->path, "method" => $reqContext->method, "timestamp" => $timestamp->format(\DateTime::RFC850)], "payload" => []],400); //set the status code for 'bad request'
        }

    }

}
?>