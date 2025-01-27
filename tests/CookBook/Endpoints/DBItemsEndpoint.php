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

/**
 * @decription a simple endpoint extension for database interactions
 */
class DBItemsEndpoint extends EndpointExtension {

    //handles the GET request
    function HandleGETRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        //get the database service
        $dbService = $appContext->services["db"];

        //return the output value(s)
        $timestamp = new \DateTime("now", new \DateTimeZone("UTC")); //see 'https://stackoverflow.com/questions/8655515/get-utc-time-in-php' for reference

        return $resContext->GetJSONResponse(['status' => ["successful" => true, "message" => ""], 'metadata' => ["host" => $reqContext->host, "path" => $reqContext->path, "method" => $reqContext->method, "timestamp" => $timestamp->format(\DateTime::RFC850)], "payload" => $dbService->getItems()]);

    }

    //handles the POST request
    function HandlePOSTRequest(ApplicationContext $appContext, RequestContext $reqContext, ResponseContext $resContext) : Response {

        //parse the request body
        $requestData = new Dictionary($reqContext->GetBody(),["title" => "","content" => ""]);

        //get the database service
        $dbService = $appContext->services["db"];

        //add the item 
        $items = $dbService->addItem($requestData->title,$requestData->content);

        //return the output value
        $timestamp = new \DateTime("now", new \DateTimeZone("UTC")); //see 'https://stackoverflow.com/questions/8655515/get-utc-time-in-php' for reference

        if(count($items) == 1){ //the item was added successfully
            return $resContext->GetJSONResponse(['status' => ["successful" => true, "message" => "Item added successfully"], 'metadata' => ["host" => $reqContext->host, "path" => $reqContext->path, "method" => $reqContext->method, "timestamp" => $timestamp->format(\DateTime::RFC850)], "payload" => $items]);
        } else { //adding the item failed
            return $resContext->GetJSONResponse(['status' => ["successful" => false, "message" => "Failed to add item"], 'metadata' => ["host" => $reqContext->host, "path" => $reqContext->path, "method" => $reqContext->method, "timestamp" => $timestamp->format(\DateTime::RFC850)], "payload" => []]);
        }
        
    }

}
?>