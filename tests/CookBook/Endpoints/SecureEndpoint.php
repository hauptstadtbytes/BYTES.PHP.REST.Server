<?php
//set the namespace
namespace BytesPhp\Rest\Server\Tests\CookBook\Endpoints;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//add namespace(s) required from server package
use BytesPhp\Rest\Server\Types\Extension\EndpointExtension as EndpointExtension;

use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;
use BytesPhp\Rest\Server\Types\Context\ResponseContext as ResponseContext;

use BytesPhp\Rest\Server\Implementations\Response\JSONResponseLayout as JSONResponseLayout;

/**
 * @decription an example for a "header-secured" endpoint extension (for demonstration purpose)
 */
class SecureEndpoint extends EndpointExtension {

    //handles the GET request
    function HandleGETRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        //return the output value
        $layout = new JSONResponseLayout($reqContext);

        $layout->message = "Successfully authenticated";

        return $resContext->getResponse($layout);

    }

    //perform preexecution checks (i.e. for header token)
    function OnPreexecution(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : ?Response {

        //get the security token
        $baererToken = $this->GetBaererToken($reqContext->headers);

        //check the header token and return the outout
        $layout = new JSONResponseLayout($reqContext);

        $layout->statusCode = 401;
        $layout->successful = false;
        $layout->message = "Authentication failed";

        if(!is_null($baererToken)) {

            if($appContext->services["auth"]->checkToken($baererToken)) {

                return null;

            } 

        }

        //return the default output value
        return $resContext->getResponse($layout);

    }

    //extracts the baerer token from headers
    private function GetBaererToken(array $headers) : ?string{

        //check for 'Authorization' header
        if(!array_key_exists("Authorization",$headers)) {

            return null;

        }

        foreach($headers["Authorization"] as $token){

            if(string_startswith($token,"Bearer ")) {

                return substr($token,7);

            }

        }

        //return the default output
        return null;

    }

}
?>