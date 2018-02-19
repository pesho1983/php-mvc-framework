<?php
spl_autoload_register();
//взима параметри
$uri = $_SERVER['REQUEST_URI'];
$junk = str_replace(basename(__FILE__), "", $_SERVER['PHP_SELF']);
$actionPart = str_replace($junk, "", $uri);
$uriTokens = explode("/", $actionPart);

$className = array_shift($uriTokens);
$methodName = array_shift($uriTokens);

//$modelBinder = new \Core\ModelBinding\ModelBinder();
$request = new \Core\Http\Request($className, $methodName, $uriTokens, $_SERVER['QUERY_STRING']);

$dbInfo = parse_ini_file('Config/db.ini');
$db = new \Database\PDODatabase(new PDO($dbInfo['dsn'], $dbInfo['user'], $dbInfo['pass']));


$container = new \Core\DependencyManagement\Container();
$container->cache(\Core\DependencyManagement\ContainerInterface::class, $container);
$container->cache(\Database\DatabaseInterface::class, $db);
$container->cache(\Core\Http\RequestInterface::class, $request);

$container->addDependency(\Core\View\ViewInterface::class, \Core\View\View::class);
$container->addDependency(\Core\ModelBinding\ModelBinderInterface::class, \Core\ModelBinding\ModelBinder::class);
$container->addDependency(\Repository\User\UserRepositoryInterface::class, \Repository\User\UserRepository::class);
$container->addDependency(\Service\User\UserServiceInterface::class, \Service\User\UserService::class);


$container->addDependency(\Service\Dummy\DummyServiceInterface::class, \Service\Dummy\DummyService::class);
$container->addDependency(\Core\ApplicationInterface::class, \Core\Application::class);

$app = $container->resolve(\Core\Application::class);

$app->start();


