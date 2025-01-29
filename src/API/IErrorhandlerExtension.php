<?php
//set the namespace
namespace BytesPhp\Rest\Server\API;

//embed global external type(s) required
use Throwable As Throwable;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface as LoggerInterface;

//the entdpoint extension interface
interface IErrorhandlerExtension {

    //the (default) invoking method (called by the Slim framework)
    public function __invoke(Request $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails, ?LoggerInterface $logger = null): Response;

}
?>