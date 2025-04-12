<?php
//set the namespace
namespace BytesPhp\Rest\Server\Implementations\ErrorHandler;

//embed global external type(s) required
use Throwable As Throwable;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;

//add internal namespace(s) required
use BytesPhp\Rest\Server\Types\Extension\ErrorHandlerExtension as ErrorHandlerExtension;

use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;
use BytesPhp\Rest\Server\Types\Context\ResponseContext as ResponseContext;

use BytesPhp\Rest\Server\Implementations\Response\JSONResponseLayout as JSONResponseLayout;

//the "trailing slash" middleware extension class
class DefaultErrorHandler extends ErrorHandlerExtension {

    function HandleError(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext, Throwable $exception): Response{

        //assemble the output layout
        $layout = new JSONResponseLayout($reqContext);
        $layout->successful = false;

        switch (get_class($exception)) {
            case "Slim\Exception\HttpNotFoundException":
                $layout->message = "Route not found or disabled";
                $layout->statusCode = 404;
                break;
            case "Slim\\Exception\\HttpMethodNotAllowedException":
                $layout->message = "Endpoint does not support the HTTP request method '".$reqContext->method."'";
                $layout->statusCode = 405;
                break;
            case "BytesPhp\Rest\Server\Types\Exception\MethodNotImplementedException":
                $layout->message = "Endpoint does not support the HTTP request method '".$reqContext->method."'";
                $layout->statusCode = 405;
                break;
            default:
                $layout->message = $exception->getMessage();
        }

        //write the event to the server log
        $appContext->log->Exception($layout->message."|".$reqContext->path."|".$reqContext->method);

        //return the response
        return $resContext->getResponse($layout);

    }

}
?>