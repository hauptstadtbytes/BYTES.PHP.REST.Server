<?php
//set the namespace
namespace BytesPhp\Rest\Server\Implementations\Response;

//add namespaces required from 'Slim' framework
use Psr\Http\Message\ResponseInterface as Response;

//add internal namespace(s) required
use BytesPhp\Rest\Server\API\IResponseLayout as IResponseLayout;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;

//the HTML response layout class
class HTMLResponseLayout implements IResponseLayout {

    //public properties
    public ?string $head = null;
    public string $body = "";

    //implement "IResponseLayout"
    public function getResponse(Response $response) : Response {

        if(is_null($this->head)){
            $this->head = "";
        }

        $response->getBody()->write("<!DOCTYPE html><html><head>".$this->head."</head><body>".$this->body."</body></html>");

        return $response->withHeader('Content-Type', 'text/html')->withStatus(200);

    }

}

?>