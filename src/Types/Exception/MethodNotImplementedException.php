<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types\Exception;

//import internal namespaces required
use BytesPhp\Rest\Server\Types\Exception\ApplicationException as ApplicationException;

class MethodNotImplementedException extends ApplicationException{

    protected $message = 'Method not implemented';

    protected string $description = 'The requested endpoint does not implement the method requested';

}
?>