<?php
//set the namespace
namespace BytesPhp\Rest\Server\Tests\CookBook\Endpoints;

//add namespace(s) required from "slim" framework
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//add namespace(s) required from "bytes.php" framework
use BytesPhp\Primitives\Dictionary as Dictionary;

//add namespace(s) required from server package
use BytesPhp\Rest\Server\Types\Extension\EndpointExtension as EndpointExtension;

use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;
use BytesPhp\Rest\Server\Types\Context\ResponseContext as ResponseContext;

use BytesPhp\Rest\Server\Implementations\Response\JSONResponseLayout as JSONResponseLayout;

/**
 * @decription a simple endpoint extension for database interactions
 */
class DBItemsEndpoint extends EndpointExtension {

    //handles the GET request
    function HandleGETRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        //get the database service
        $dbService = $appContext->services["db"];

        //assemble the output value
        $layout = new JSONResponseLayout($reqContext);
        $layout->payload = $dbService->getItems();

        //return the output value
        return $resContext->getResponse($layout);

    }

    //handles the POST request
    function HandlePOSTRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        //parse the request body
        $requestData = new Dictionary($reqContext->GetBody(),["title" => "","content" => ""]);

        //get the database service
        $dbService = $appContext->services["db"];

        //add the item 
        $items = $dbService->addItem($requestData->title,$requestData->content);

        //assemble the output value
        $layout = new JSONResponseLayout($reqContext);

        if(count($items) == 1){ //the item was added successfully
            $layout->payload = $items;
        } else { //adding the item failed
            $layout->successful = false;
            $layout->message = "Failed to add item";
        }

        //return the output value
        return $resContext->getResponse($layout);
        
    }

}
?>