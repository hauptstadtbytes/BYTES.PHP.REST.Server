<?php
//set the namespace
namespace BytesPhp\Rest\Server\API;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//the entdpoint extension interface
interface IEndpointExtension {

    //the (default) invoking method (called by the Slim framework)
    public function __invoke(Request $request, Response $response, array $args);

}

?>