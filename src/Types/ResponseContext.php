<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types;

//add namespaces required from 'Slim' framework
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//the response context class
class ResponseContext{

    //private properties
    private Response $response;
    private Request $request;

    //public properties
    public bool $statusFlag = true;
    public string $statusMessage = "";
    public int $statusCode = 200;

    public $payload = [];

    //constructur method
    public function __construct(Request $req, Response $res) {

        $this->request = $req;
        $this->response = $res;

    }

    //returns the ('slim') response
    public function GetResponse(): Response{

        $bodyData = ['status' => ["successful" => $this->statusFlag, "message" => $this->statusMessage], 'metadata' => $this->GetMetadata(), "payload" => $this->payload];
        $this->response->getBody()->write(json_encode($bodyData,JSON_PRETTY_PRINT));

        return $this->response->withHeader('Content-Type', 'application/json')->withStatus($this->statusCode);
    }

    //returns the (default) response metadata
    private function GetMetadata(): array{

        $uri = $this->request->getUri();
        $timestamp = new \DateTime("now", new \DateTimeZone("UTC")); //see 'https://stackoverflow.com/questions/8655515/get-utc-time-in-php' for reference

        return ["host" => $uri->getHost(), "path" => $uri->getPath(), "method" => $this->request->getMethod(), "timestamp" => $timestamp->format(\DateTime::RFC850)];

    }

}
?>