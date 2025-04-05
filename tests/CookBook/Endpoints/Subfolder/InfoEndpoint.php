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
use BytesPhp\Rest\Server\Implementations\Response\HTMLResponseLayout as HTMLResponseLayout;

/**
 * @decription a simple 'PHP info' endpoint extension
 */
class InfoEndpoint extends EndpointExtension {

    //handles the GET request
    function HandleGETRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        //assemble the output
        $layout = new JSONResponseLayout($reqContext); //set the JSON output as default

        $layout->payload = [$this->GetPHPInfo()];

        //return the output value
        return $resContext->getResponse($layout);

    }


    //captures the PHPInfo data, based on 'https://gist.github.com/jgornick/208754'
    private function GetPHPInfo() {
        ob_start();
        phpinfo();
        $data = ob_get_contents();
        ob_clean();
        return $data;
    }
}
?>