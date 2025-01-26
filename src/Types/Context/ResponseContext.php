<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types\Context;

//add namespaces required from 'Slim' framework
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

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

    //returns the default ('slim') response
    public function GetResponse(int $statusCode = null, string $body = null, string $applicationType = null): Response{ // see 'https://stackoverflow.com/questions/23714383/what-are-all-the-possible-values-for-http-content-type-header' for application types

        if(is_null($statusCode)){
            $statusCode = 200;
        }

        if(!is_null($body)) {
            $this->response->getBody()->write($body);
        }

        if(is_null($applicationType)) {

            return $this->response->withStatus($statusCode);

        } else {

            return $this->response->withHeader('Content-Type', $applicationType)->withStatus($statusCode);

        }
        
    }

    //returns a JSON formatted response
    public function GetJSONResponse(array $body, int $statusCode = null): Response {

        if(is_null($statusCode)){
            $statusCode = 200;
        }

        $this->response->getBody()->write(json_encode($body,JSON_PRETTY_PRINT));

        return $this->response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);

    }

    //returns a HTML response
    public function GetHTMLResponse(string $body, string $head = null): Response {

        if(is_null($head)){
            $head = "";
        }

        $this->response->getBody()->write("<!DOCTYPE html><html><head>.$head.</head><body>".$body."</body></html>");

        return $this->response->withHeader('Content-Type', 'text/html')->withStatus(200);

    }

}
?>