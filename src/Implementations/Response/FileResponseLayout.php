<?php
//set the namespace
namespace BytesPhp\Rest\Server\Implementations\Response;

//add namespaces required from 'Slim' framework
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Stream as Stream;

//add internal namespace(s) required
use BytesPhp\Rest\Server\API\IResponseLayout as IResponseLayout;
use BytesPhp\Rest\Server\Types\Context\RequestContext as RequestContext;

//the file response layout class, based on the articles found at 'https://github.com/mhndev/slim-file-response/blob/develop/src/FileResponse.php' and 'https://dev.to/nauleyco/how-to-download-a-csv-file-with-slim-4-21a7'
class FileResponseLayout implements IResponseLayout {

    //public properties
    public ?string $filePath = null;
    public ?string $fileName = null;

    public bool $preventCaching = false;

    //implement "IResponseLayout"
    public function getResponse(Response $response) : Response {

        if ($fd = fopen($this->filePath, "rb")) { //try to open the file

            $size = filesize($this->filePath);
            $path_parts = pathinfo($this->filePath);
            $ext = strtolower($path_parts["extension"]);

            $outputName = "file.sample";

            if(is_null($this->fileName)) {
                $outputName = $path_parts["basename"];
            } else{
                if(count(explode('.', $this->fileName)) <= 1){
                    $outputName = $this->fileName.'.'.$ext;
                }
            }

            switch ($ext) {
                case "pdf":
                    $response = $response->withHeader("Content-type","application/pdf");
                    break;

                case "png":
                    $response = $response->withHeader("Content-type","image/png");
                    break;

                case "gif":
                    $response = $response->withHeader("Content-type","image/gif");
                    break;

                case "jpeg":
                    $response = $response->withHeader("Content-type","image/jpeg");
                    break;

                case "jpg":
                    $response = $response->withHeader("Content-type","image/jpg");
                    break;

                case "mp3":
                    $response = $response->withHeader("Content-type","audio/mpeg");
                    break;

                default;
                    $response = $response->withHeader("Content-type","application/octet-stream");
                    break;
            }

            $response = $response->withHeader("Content-Disposition",'attachment; filename="'.$outputName.'"');
            $response = $response->withHeader("Content-length",$size);

            //set the header(s) for cache control
            if($this->preventCaching) {
                $response = $response->withHeader("Cache-control","private");
            } else {
                $response = $response->withHeader("Cache-control","no-cache, must-revalidate");
                $response = $response->withHeader('Pragma', 'no-cache');
            }

        }

        //return the output value, using a stream
        return $response->withBody(new Stream($fd));
    }

}

?>