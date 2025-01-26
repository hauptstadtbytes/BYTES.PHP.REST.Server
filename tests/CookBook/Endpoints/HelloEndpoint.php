<?php
//set the namespace
namespace BytesPhp\Rest\Server\Tests\CookBook\Endpoints;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//add namespaces required from API server API
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

        //set the response data
        $resContext->payload = "Hello World!";

        //return the output value
        return $resContext->GetResponse();

    }

}
?>