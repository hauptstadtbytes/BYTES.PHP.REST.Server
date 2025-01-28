<?php
//set the namespace
namespace BytesPhp\Rest\Server\API;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

//the middleware extension interface
interface IMiddlewareExtension {

    //the (default) invoking method (called by the Slim framework)
    public function __invoke(Request $request, RequestHandler $handler) : Response;

}
?>