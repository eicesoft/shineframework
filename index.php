<?php
include 'Lib/autoload.php'; //自动加载

$start = microtime(true);
define('APP_PATH', __DIR__ . DS . 'App');

use Core\Application;
use Core\Error\CoreError;

try {
	$app = Application::Instance();

	$app->setAppPath( APP_PATH );
	$app->setMode( Application::WEB_MODE );

	$app->run();
} catch (CoreError $ex) {
	echo $ex->getMessage();
}

$end = microtime(true);

\Core\Monitor\Debug::Instance()->trace(sprintf("page run: %0.4f ms", ($end - $start) * 1000));