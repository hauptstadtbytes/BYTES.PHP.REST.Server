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

use BytesPhp\Rest\Server\Implementations\Response\LogResponseLayout as LogResponseLayout;

/**
 * @decription a sample endpoint returning a log
 * @route /v1/log
 */
class LogEndpoint extends EndpointExtension {

    //handles the GET request
    function HandleGETRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        //assemble the output
        $layout = new LogResponseLayout($reqContext); //set the JSON output as default

        $layout->Debug("Hello World!"); //should not be visible since the default threshold is 'Information'
        $layout->Info("This is an example log entry","... with details");
        $layout->Fatal("EOF");

        //return the output value
        return $resContext->getResponse($layout);

    }

}
?>