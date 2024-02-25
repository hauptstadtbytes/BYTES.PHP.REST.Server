<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types\Exceptions;

//add (PHP) global namespaces required
use RuntimeException;
use Throwable;

//internal namepsaces required
use BytesPhp\Rest\Server\Types\RequestContext as RequestContext;

class ApplicationException extends RuntimeException{

    protected string $description = '';
    protected ?RequestContext $requestContext = null;

    public function __construct(RequestContext $reqContext = null, string $message = null, int $code = 0, ?Throwable $previous = null) {

        if(empty($message)) {
            $message = $this->message;
        } 

        if(!is_null($reqContext)) {
            $this->requestContext = $reqContext;
        }

        parent::__construct($message, $code, $previous);
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
?>