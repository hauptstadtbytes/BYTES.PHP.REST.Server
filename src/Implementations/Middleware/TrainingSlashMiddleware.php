<?php
//set the namespace
namespace BytesPhp\Rest\Server\Implementations\Middleware;

//add namespace(s) required from 'Slim' framework
use Psr\Http\Message\ResponseInterface as Response;

//import internal namespace(s) required
use BytesPhp\Rest\Server\Types\Extension\MiddlewareExtension as MiddlewareExtension;

use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;
use BytesPhp\Rest\Server\Types\Context\MiddlewareContext as MiddlewareContext;

//the "trailing slash" middleware extension class
class TrailingSlashMiddleware extends MiddlewareExtension {

    function HandleRequest(ApplicationContext $appContext, RequestContext $reqContext, MiddlewareContext $middlewareContext) : Response {

        $uri = $reqContext->request->getUri();
        $path = $uri->getPath();

        $request = null;

        if ($path != '/' && substr($path, -1) == '/') {

            //(recursively) remove slashes
            $path = rtrim($path, '/');
    
            //permanently redirect paths with a trailing slash to the non-trailing counterpart
            $uri = $uri->withPath($path);
            
            if ($reqContext->request->getMethod() == 'GET') {

                $response = $appContext->createNewResponse();
                return $response
                    ->withHeader('Location', (string) $uri)
                    ->withStatus(301);

            } else {

                $request = $reqContext->request->withUri($uri);

            }

        }

        return $middlewareContext->getResponse($request);

    }

}
?>