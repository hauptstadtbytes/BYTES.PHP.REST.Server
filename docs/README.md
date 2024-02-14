# Installation

1. Add the composer package to your project

```
composer require bytesgmbh/bytes.php.rest:main-dev
```

2. Create an index.php file with the following conten.

```
<?php

//add namespace(s) required from "bytes.php.rest" framework
use BytesPhp\Rest\APIServer as ApiServer;

//embed the composer auto-loading
require (__DIR__.'/../vendor/autoload.php'); //adjust this line to match your project structure

//create a new server instance
$server = new ApiServer();

//run the server/ handle the request
$server->run();

?>
```

3. Add a .htaccess file (on Apache server) on the same level as your index.php file

```
# see 'https://www.slimframework.com/docs/v4/start/web-servers.html' for reference
RewriteEngine On
RewriteBase /bytes.php/rest/tests/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

Hint: When deploying a slim application to a sub directory (not the domain root folder), slim typically results in a 404 issue. To deal with that (automatically), the APIServer makes used of the solution provided by Rob Allen at [https://akrabat.com/running-slim-4-in-a-subdirectory/](https://akrabat.com/running-slim-4-in-a-subdirectory/). So, there should be no additional modifications required.
