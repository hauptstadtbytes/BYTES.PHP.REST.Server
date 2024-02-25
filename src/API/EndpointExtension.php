<?php
//set the namespace
namespace BytesPhp\Rest\Server\API;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Exception\HttpMethodNotAllowedException as HttpMethodNotAllowedException;

//add internal namespace(s) required
use BytesPhp\Rest\Server\API\Extension as Extension;

use BytesPhp\Rest\Server\Types\ApplicationContext as ApplicationContext;
use BytesPhp\Rest\Server\Types\RequestContext as RequestContext;
use BytesPhp\Rest\Server\Types\ResponseContext as ResponseContext;

use BytesPhp\Rest\Server\Types\Exceptions\MethodNotImplementedException as MethodNotImplementedException;

//the entdpoint extension interface
interface EndpointExtensionInterface {

    //the (default) invoking method (called by the Slim framework)
    public function __invoke(Request $request, Response $response, array $args);

}

//the endpoint extension (parent) class
class EndpointExtension extends Extension implements EndpointExtensionInterface{

    //the (default) invoking method (called by the Slim framework)
    public function __invoke(Request $request, Response $response, array $args) {

        //call the (method-related) request handling method
        $reqContext = new RequestContext($request, $args); //create a new request context instance
        $resContext = new ResponseContext($request, $response); //create a new response context instance

        switch (strtolower($reqContext->method) ) {
            case "get":
                return $this->HandleGETRequest($this->appContext, $reqContext, $resContext);
                break;
            case "post":
                return $this->HandlePOSTRequest($this->appContext, $reqContext, $resContext);
                break;
            case "patch":
                return $this->HandlePATCHRequest($this->appContext, $reqContext, $resContext);
                break;
            case "put":
                return $this->HandlePUTRequest($this->appContext, $reqContext, $resContext);
                break;
            case "delete":
                return $this->HandleDELETERequest($this->appContext, $reqContext, $resContext);
                break;
            case "options":
                return $this->HandleOPTIONSRequest($this->appContext, $reqContext, $resContext);
                break;
            default:
                throw new HttpMethodNotAllowedException($request);
        }
    }

    function HandleGETRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        throw new MethodNotImplementedException($reqContext, "'GET' method not implemented");
        return $resContext->Response;

    }

    function HandlePOSTRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        throw new MethodNotImplementedException($reqContext, "'POST' method not implemented");
        return $resContext->Response;

    }

    function HandlePATCHRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        throw new MethodNotImplementedException($reqContext, "'PATCH' method not implemented");
        return $resContext->Response;

    }

    function HandlePUTRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        throw new MethodNotImplementedException($reqContext, "'PUT' method not implemented");
        return $resContext->Response;

    }

    function HandleDELETERequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        throw new MethodNotImplementedException($reqContext, "'DELETE' method not implemented");
        return $resContext->Response;

    }

    function HandleOPTIONSRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        throw new MethodNotImplementedException($reqContext, "'OPTIONS' method not implemented");
        return $resContext->Response;

    }
}
?>