<?php
//set the namespace
namespace BytesPhp\Rest\Server\Tests\CookBook\Endpoints;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//add namespaces required from API server API
use BytesPhp\Rest\Server\API\EndpointExtension as EndpointExtension;

use BytesPhp\Rest\Server\Types\ApplicationContext as ApplicationContext;
use BytesPhp\Rest\Server\Types\RequestContext as RequestContext;
use BytesPhp\Rest\Server\Types\ResponseContext as ResponseContext;

/**
 * @route /echo[/{id}]
 * @workspace cookbook
 * @enabled true
 * @decription a simple mirroring enpoint, demonstrating how to deal with request data and the application infrastructure
 */
class EchoEndpoint extends EndpointExtension {

    //handles the GET request
    function HandleGETRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        //set the response data
        $resContext->payload = ['host' => $reqContext->uri->getHost(), 'path' => $reqContext->uri->getPath(), "method" => $reqContext->method, "parameters" => $reqContext->arguments, "query" => $reqContext->queries, "headers" => $reqContext->headers];

        //return the output value
        return $resContext->GetResponse();

    }

}
?>