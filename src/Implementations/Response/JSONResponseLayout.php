<?php
//set the namespace
namespace BytesPhp\Rest\Server\Implementations\Response;

//add namespaces required from 'Slim' framework
use Psr\Http\Message\ResponseInterface as Response;

//add internal namespace(s) required
use BytesPhp\Rest\Server\API\IResponseLayout as IResponseLayout;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;

//the JSON response layout class
class JSONResponseLayout implements IResponseLayout {

    //private variable(s)
    private ?RequestContext $request = null;

    //public properties
    public int $statusCode = 200;

    public bool $successful = true;
    public string $message = "";

    public ?array $payload = null;

    //constructor method
    public function __construct(RequestContext $req = null) {

        if(!is_null($req)){
            $this->request = $req;
        }

    }

    //implement "IResponseLayout"
    public function getResponse(Response $response) : Response {

        $data = [];
        $data["status"] = ["successful" => $this->successful, "message" => $this->message];

        if(!is_null($this->request)){
            $timestamp = new \DateTime("now", new \DateTimeZone("UTC")); //see 'https://stackoverflow.com/questions/8655515/get-utc-time-in-php' for reference

            $data["metadata"] = ["host" => $this->request->host, "path" => $this->request->path, "method" => $this->request->method, "timestamp" => $timestamp->format(\DateTime::RFC850)];
        }

        if(!is_null($this->payload)){
            $data["payload"] = $this->payload;
        }

        $response->getBody()->write(json_encode($data,JSON_PRETTY_PRINT));

        return $response->withHeader('Content-Type', 'application/json')->withStatus($this->statusCode);

    }
    
}
?>