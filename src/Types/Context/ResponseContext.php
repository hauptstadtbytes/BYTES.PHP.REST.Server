<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types\Context;

//add namespaces required from 'Slim' framework
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//add internal namespace(s) required
use BytesPhp\Rest\Server\API\IResponseLayout as IResponseLayout;
use BytesPhp\Rest\Server\Implementations\Response\JSONResponseLayout as JSONResponseLayout;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;

//the response context class
class ResponseContext{

    //private properties
    private Request $request;
    private Response $response;

    //constructur method
    public function __construct(Request $req, Response $res) {

        $this->request = $req;
        $this->response = $res;

    }

    public function getResponse(?IResponseLayout $layout = null) {

        if(is_null($layout)) {
            $layout = new JSONResponseLayout(new RequestContext($this->request));
        }

        return $layout->getResponse($this->response);

    }

}
?>