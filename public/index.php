<?php
declare(strict_types=1);

use DI\ContainerBuilder;

use Relay\Relay;
use Laminas\Diactoros\ServerRequestFactory;

use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Middlewares\Utils\Dispatcher;
use App\Middlewares\RepositoryFactoryMiddleware;

use Illuminate\Database\Capsule\Manager as Capsule;
use Narrowspark\HttpEmitter\SapiEmitter;


require __DIR__ . '/../vendor/autoload.php';

//Loading Environmental variables
if (file_exists(__DIR__ . '/../.env')) {    
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
	$dotenv->load();
}

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require __DIR__ . '/../config/settings.php';
$settings($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/../config/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

//get routes
$routes = require __DIR__ . '/../config/routes.php';

//get path related constants
require __DIR__ . '/../config/constants.php';


$request = ServerRequestFactory::fromGlobals(); 

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RepositoryFactoryMiddleware($container);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle($request);


$emitter = new SapiEmitter();
return $emitter->emit($response);






