<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types\Extension;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

//add internal namespace(s) required
use BytesPhp\Rest\Server\API\IMiddlewareExtension as IMiddlewareExtension;
use BytesPhp\Rest\Server\Types\Extension\Extension as Extension;

use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;
use BytesPhp\Rest\Server\Types\Context\MiddlewareContext as MiddlewareContext;

//the endpoint extension (parent) class
class MiddlewareExtension extends Extension implements IMiddlewareExtension{

    //the (default) invoking method (called by the Slim framework)
    public function __invoke(Request $request, RequestHandler $handler) : Response {

        return $this->HandleRequest($this->appContext, new RequestContext($request), new MiddlewareContext($request, $handler));

    }

    function HandleRequest(ApplicationContext $appContext, RequestContext $reqContext, MiddlewareContext $middlewareContext) : Response {

        return $middlewareContext->GetResponse();

    }

}
?>