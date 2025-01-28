<?php
//set the namespace
namespace BytesPhp\Rest\Server\API;

//embed namespace(s) required from 'Slim' framework
use Psr\Http\Message\ResponseInterface as Response;

//the response layout interface
interface IResponseLayout {

    public function getResponse(Response $response) : Response;

}
?>