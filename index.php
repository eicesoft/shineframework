<?php
include 'Site/autoload.php'; //自动加载

$start = microtime(true);
define('APP_PATH', __DIR__ . DS . 'Site' . DS . 'App');

use Core\Application;
use Core\Error\CoreError;
use Core\Monitor\Debug;

try {
    $app = Application::instance();

    $app->setAppPath(APP_PATH);
    $app->setMode(Application::WEB_MODE);

    $app->run();
} catch (CoreError $ex) {
    echo $ex->getMessage();
}

$end = microtime(true);
Debug::instance()->trace(sprintf("Page run: %0.4f ms", ($end - $start) * 1000));
