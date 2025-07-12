<?php
//set the namespace
namespace BytesPhp\Rest\Server\Implementations\Response;

//add namespaces required from 'Slim' framework
use Psr\Http\Message\ResponseInterface as Response;

//add namespace(s) required from 'BYTES.PHP' framework
use BytesPhp\Logging\Log as Log;
use BytesPhp\Logging\LogEntry as LogEntry;
use BytesPhp\Logging\InformationLevel as InformationLevel;

//add internal namespace(s) required
use BytesPhp\Rest\Server\API\IResponseLayout as IResponseLayout;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;

//the log response layout class
class LogResponseLayout implements IResponseLayout {

    //private variable(s)
    private ?Log $myLog = null;

    //public properties
    public InformationLevel $theshold = InformationLevel::Debug;
    public string $entryTemplate = "%TimeStamp%; %Level%; %Message%; %Details%";
    public string $timestampTemplate = "Y-m-d H:i:s";

    //implement "IResponseLayout"
    public function getResponse(Response $response) : Response {

        //set the header
        $response = $response->withHeader("Content-type","text/plain");

        //set the body
        $response->getBody()->write($this->GetResponseBody());

        //return the output value
        return $response;

    }

    //public function(s) writing to the log
    public function Debug(string $message, $details = null) {

        if(is_null($this->myLog)){
            $this->myLog = new Log();
        }

        $this->myLog->Debug($message,$details);

    }

    public function Info(string $message, $details = null) {

        if(is_null($this->myLog)){
            $this->myLog = new Log();
        }

        $this->myLog->Info($message,$details);

    }

    public function Warning(string $message, $details = null) {

        if(is_null($this->myLog)){
            $this->myLog = new Log();
        }
        
        $this->myLog->Warning($message,$details);

    }

    public function Exception(string $message, $details = null) {

        if(is_null($this->myLog)){
            $this->myLog = new Log();
        }

        $this->myLog->Exception($message,$details);

    }

    public function Fatal(string $message, $details = null) {

        if(is_null($this->myLog)){
            $this->myLog = new Log();
        }

        $this->myLog->Fatal($message,$details);

    }

    //private function assembling the output body
    private function GetResponseBody() {

        $output = "";

        foreach($this->myLog->Cache as $entry) {
            $output .= $this->ParseEntry($entry)."\n";
        }

        return $output;

    }

    //private method parsing the 'LogEntry'
    private function ParseEntry(LogEntry $entry) {

        //parse the details
        $details = "";

        if(!is_null($entry->details)) {
            $details = $entry->details;
        }

        //prepare the values
        $values = ["%TimeStamp%" => $entry->timestamp->format($this->timestampTemplate), "%Level%" => $entry->level->name, "%Message%" => $entry->message, "%Details%" => $details];

        //parse the entry
        $output = $this->entryTemplate;

        foreach($values as $mask => $value) {

            $output = str_replace($mask, $value, $output);

        }

        //return the output value
        return $output;
    }

}

?>