<?php
//set the namespace
namespace BytesPhp\Rest\Server\Implementations\Middleware;

//add namespace(s) required from 'Slim' framework
use Psr\Http\Message\ResponseInterface as Response;

//import internal namespace(s) required
use BytesPhp\Rest\Server\Types\Extension\MiddlewareExtension as MiddlewareExtension;

use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;
use BytesPhp\Rest\Server\Types\Context\MiddlewareContext as MiddlewareContext;

//the "trailing slash" middleware extension class
class CORSMiddleware extends MiddlewareExtension {

    function HandleRequest(ApplicationContext $appContext, RequestContext $reqContext, MiddlewareContext $middlewareContext) : Response {

        //get the output
        $response = $middlewareContext->GetResponse();

        //return the output
        return $response
            ->withHeader('Access-Control-Allow-Origin', $appContext->configuration->arguments["cors"]["origin"])
            ->withHeader('Access-Control-Allow-Headers', $appContext->configuration->arguments["cors"]["headers"])
            ->withHeader('Access-Control-Allow-Methods', implode(", ",$appContext->configuration->methods));

    }

}
?>