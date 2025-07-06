<?php
//set the namespace
namespace BytesPhp\Rest\Server\Tests\CookBook\Endpoints\RouteExamples;

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
 * @decription an endpoint, demonstrating how to work with URL parameters (defining both routes will result in an 'optional parameter')
 * @route /v1/routes/paramater/{id}|/v1/routes/paramater
 */
class ParametersEndpoint extends EndpointExtension {

    //handles the GET request
    function HandleGETRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        $id = null;

        if(array_key_exists("id",$reqContext->arguments)) {
            $id = $reqContext->arguments["id"];
        }

        //assemble the output
        $layout = new JSONResponseLayout($reqContext); //set the JSON output as default

        if(is_null($id)){
            $layout->message = "No 'id' paramater given";
        } else {
            $layout->message = "paramater '".$id."' recognized";
        }

        //return the output value
        return $resContext->getResponse($layout);

    }

}
?>