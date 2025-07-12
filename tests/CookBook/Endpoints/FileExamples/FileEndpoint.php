<?php
//set the namespace
namespace BytesPhp\Rest\Server\Tests\CookBook\Endpoints\FileExamples;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//add namespace(s) required from server framework
use BytesPhp\Rest\Server\Types\Extension\EndpointExtension as EndpointExtension;

use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;
use BytesPhp\Rest\Server\Types\Context\ResponseContext as ResponseContext;

use BytesPhp\Rest\Server\Implementations\Response\FileResponseLayout as FileResponseLayout;

/**
 * @decription an endpoint, demonstrating how to download file(s)
 * @route /v1/file
 */
class FileEndpoint extends EndpointExtension {

    //handles the GET request
    function HandleGETRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        //get the file path
        $filePath = __DIR__."/../../../Data/sampleImage.jpg";

        //create a new response layout, setting required parameters
        $layout = new FileResponseLayout($reqContext);
        $layout->filePath = $filePath;

        //return the output value
        return $resContext->getResponse($layout);

    }

}
?>