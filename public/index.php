<?php

require  __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__. '/..');
$dotenv->load();

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_DATABASE'),
    'username'  => getenv('DB_USERNAME'),
    'password'  => getenv('DB_PASSWORD'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

$map->get('movil.index', '/api/movil/aircrafts', [
    'controller' => 'App\Http\Movil\Controllers\AircraftController',
    'action' => 'index'
]);

$map->post('movil.store', '/api/movil/aircrafts', [
    'controller' => 'App\Http\Movil\Controllers\AircraftController',
    'action' => 'store'
]);

$map->delete('movil.delete', '/api/movil/aircrafts', [
    'controller' => 'App\Http\Movil\Controllers\AircraftController',
    'action' => 'delete'
]);

$map->get('home', '/', [
    'controller' => 'App\Http\Web\Controllers\HomeController',
    'action' => 'index'
]);

$map->post('web.store', '/api/web/aircrafts', [
    'controller' => 'App\Http\Web\Controllers\AircraftController',
    'action' => 'store'
]);

$map->delete('web.delete', '/api/web/aircrafts', [
    'controller' => 'App\Http\Web\Controllers\AircraftController',
    'action' => 'delete'
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
    echo 'No found route';
    exit;
}

$handlerData = $route->handler;
$controllerName = $handlerData['controller'];
$actionName = $handlerData['action'];
 
$controller = new $controllerName;
$controller->$actionName($request);
