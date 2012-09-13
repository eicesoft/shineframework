<?php
include 'Lib/autoload.php'; //自动加载

define('APP_PATH', __DIR__ . DS . 'App');

use Core\Application;
use Core\Error\CoreError;

try {
	$app = Application::Instance();

	$app->setAppPath( APP_PATH );
	$app->setMode( Application::FLASH_MODE );

	$app->run();
} catch (CoreError $ex) {
	echo $ex->getMessage();
}