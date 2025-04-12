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

use BytesPhp\Rest\Server\Implementations\Response\JSONResponseLayout as JSONResponseLayout;
use BytesPhp\Rest\Server\Implementations\Response\HTMLResponseLayout as HTMLResponseLayout;

/**
 * @decription a simple 'hello world' endpoint extension
 * @route /v1/hello|/v1/hello/{id}
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

        //write to default log
        //$appContext->log->info("Hello requested");

        //assemble the output
        $layout = new JSONResponseLayout($reqContext); //set the JSON output as default

        switch(strtolower($outputFormat)) {
            case "json":
                //set the message
                $layout->message = "Hello World!";
                $layout->payload = $reqContext->arguments;
                break;

            case "html":
                //create the output layout
                $layout = new HTMLResponseLayout($reqContext);
                $layout->body = "<h1>Hello</h1><p>...world!</p>";
                break;

            default:
                //set the (error) message
                $layout->successful = false;
                $layout->statusCode = 400;
                $layout->message = "Format unkown";
        }

        //return the output value
        return $resContext->getResponse($layout);

    }

}
?>