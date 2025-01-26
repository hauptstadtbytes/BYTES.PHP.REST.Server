# Installation

1. Add the composer package to your project

```
composer require bytesgmbh/bytes.php.rest.server:main-dev
```

2. Create an index.php file with the following conten.

```
<?php

//add namespace(s) required from "bytes.php.rest" framework
use BytesPhp\Rest\Server\Server as Server;
use BytesPhp\Rest\Server\Types\Configuration as Configuration;

//embed the composer auto-loading
require (__DIR__.'/../vendor/autoload.php'); //adjust this line to match your project structure and maybe add some additional files required

//create a new configuration
$config = new Configuration();

$config->searchPaths[] = __DIR__."/CookBook/Endpoints";
$config->endpoints["/v1/hello"] = "BytesPhp\Rest\Server\Tests\CookBook\Endpoints\HelloEndpoint";
$config->methods = ["GET","POST","PUT","PATCH","DELETE","OPTIONS"];

//create a new server instance
$server = new Server($config);

//run the server/ handle the request
$server->run();

?>
```

3. Add a .htaccess file (on Apache server) on the same level as your index.php file

```
# see 'https://www.slimframework.com/docs/v4/start/web-servers.html' for reference
RewriteEngine On
RewriteBase /bytes.php/rest.server/tests
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

## Notice
Typically a slim application runs into a 404 issues when deployed in a sub directory (not the domain root folder). To prevent this the solution of Rob Allen (see [https://akrabat.com/running-slim-4-in-a-subdirectory/](https://akrabat.com/running-slim-4-in-a-subdirectory/)) is used. So, there is no additional modifications required.
