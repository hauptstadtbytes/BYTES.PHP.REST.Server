<?php
//set the namespace
namespace BytesPhp\Rest\Server\Tests\CookBook\Services;

//add namespace(s) required from server package
use BytesPhp\Rest\Server\Types\Extension\ServiceExtension as ServiceExtension;

/**
 * @decription a simple authentication service (for demo purposes)
 */
class AuthService extends ServiceExtension {

    public function checkToken(string $key): bool{

        if($key == "ABC123") {
            return true;
        } else {
            return false;
        }

    }

}
?>