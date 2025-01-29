<?php
//set the namespace
namespace BytesPhp\Rest\Server\Types\Extension;

//embed global external type(s) required
use Throwable As Throwable;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface as LoggerInterface;

//add internal namespace(s) required
use BytesPhp\Rest\Server\API\IErrorhandlerExtension as IErrorhandlerExtension;
use BytesPhp\Rest\Server\Types\Extension\Extension as Extension;

use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;
use BytesPhp\Rest\Server\Types\Context\ResponseContext as ResponseContext;

//the endpoint extension (parent) class
class ErrorHandlerExtension extends Extension implements IErrorhandlerExtension{

    //the (default) invoking method (called by the Slim framework)
    public function __invoke(Request $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails, ?LoggerInterface $logger = null): Response {

        return $this->HandleError($this->appContext, new RequestContext($request), new ResponseContext($request, $this->appContext->createNewResponse()), $exception);

    }

    function HandleError(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext, Throwable $exception): Response{

        return $resContext->getResponse();

    }

}
?>