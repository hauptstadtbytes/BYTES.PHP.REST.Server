<?php
//set the namespace
namespace BytesPhp\Rest\Server\Tests\CookBook\Services;

//add namespace(s) required from server package
use BytesPhp\Rest\Server\Types\Context\ApplicationContext as ApplicationContext;

use BytesPhp\Rest\Server\Types\Extension\ServiceExtension as ServiceExtension;

/**
 * @decription a PDO-based simple database access service
 */
class DBService extends ServiceExtension {

    //reads the database, returning an array of items found
    public function getItems(bool $lastOnly = false): array{

        $output = [];

        //get the connection parameters
        $args = $this->appContext->configuration->arguments["db"];

        if(array_key_exists("db",$args)) { //check for the connection arguments

            //create a new database collection (see 'https://www.php-einfach.de/mysql-tutorial/daten-ausgeben/' for more details)
            $pdo = new \PDO("mysql:host=".$args["db"]["host"].";dbname=".$args["db"]["collection"], $args["db"]["user"], $args["db"]["password"]);

            $sql = "";

            if($lastOnly) {
                $sql = "SELECT * FROM Items ORDER BY id DESC LIMIT 1";
            } else {
                $sql = "SELECT * FROM Items";
            }
            
            //create the output list
            foreach($pdo->query($sql) as $row) {
                $output[] = ["id" => $row["id"],"title" => $row["title"],"content" => $row["content"]];
            }

        }

        return $output;

    }

    //writes a new item to the database
    //please note: for simplicity, there is no prevention againt e.g. SQL injection implemented; do not use in productive scenarious
    public function addItem(string $title, string $content = null): array {

        //parse the arguments
        if(is_null($content)){
            $content = "";
        }

        //get the connection parameters
        $args = $this->appContext->configuration->arguments;

        if(array_key_exists("db",$args)) { //check for the connection arguments

            //create a new database collection (see 'https://www.php-einfach.de/mysql-tutorial/daten-einfuegen/' for more details)
            $pdo = new \PDO("mysql:host=".$args["db"]["host"].";dbname=".$args["db"]["collection"], $args["db"]["user"], $args["db"]["password"]);
            $statement = $pdo->prepare("INSERT INTO Items (title,content) VALUES (?,?)");
           
            //add the item
            $statement->execute(array($title,$content));

            //return the last item
            return $this->getItems(true);

        }

    }

}
?>