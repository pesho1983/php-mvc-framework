<?php
spl_autoload_register();
//взима параметри
$uri = $_SERVER['REQUEST_URI'];
$junk = str_replace(basename(__FILE__), "", $_SERVER['PHP_SELF']);
$actionPart = str_replace($junk, "", $uri);
$uriTokens = explode("/", $actionPart);

$className = array_shift($uriTokens);
$methodName = array_shift($uriTokens);

$request = new \Core\Http\Request($className,$methodName,$uriTokens,$_SERVER['QUERY_STRING']);
$modelBinder = new \Core\ModelBinding\ModelBinder();
$app = new \Core\Application($request, $modelBinder);

$app->start();


