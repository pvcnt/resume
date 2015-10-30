<?php

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

ini_set('display_errors', 0);

require_once __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/app/src/app.php';
require __DIR__.'/app/config/prod.php';
require __DIR__.'/app/src/controllers.php';
$app->run();
