<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types\Context;

//add namespace(s) required from 'Slim' framework
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//the middleware context class
class MiddlewareContext {

    //private properties
    private ?Request $request = null;
    private ?RequestHandler $handler = null;

    //constructur method
    public function __construct(Request $req, RequestHandler $handler) {

        $this->request = $req;
        $this->handler = $handler;

    }

    //returns the (default) response
    public function getResponse(?Request $request = null, ?IResponseLayout $layout = null): Response {

        if(is_null($request)) {

            $request = $this->request;

        }

        if(!is_null($layout)){

            return $layout->getResponse($this->handler->handle($request));

        } else {

            return $this->handler->handle($request);
            
        }

    }

}
?>