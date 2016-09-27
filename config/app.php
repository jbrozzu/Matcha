<?php

	session_start();

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	require '../vendor/autoload.php';



	$app = new \Slim\App([
    	'settings' => [
        	'displayErrorDetails' => true,

        	'db' => [
	        	'host' => 'localhost',
	        	'database' => 'Matcha',
	        	'username' => 'root',
	        	'password' => 'root',
        	]
        ],
	]);


	// Get container
	$container = $app->getContainer();

	// Register component on container
	$container['db'] = function ($container) {
	    $db = $container['settings']['db'];
	    $bdd = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['database'], $db['username'], $db['password']);
	    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	    return $bdd;
	};

	$container['view'] = function ($container) {
	    $view = new \Slim\Views\Twig('../view', [
	        'cache' => false,
	    ]);
	    $view->addExtension(new \Slim\Views\TwigExtension(
	        $container->router,
	        $container->request->getUri(),
	    ));

	    return $view;
	};

	$container['HomeController'] = function ($container) {
		return new \App\Controllers\HomeController($container);
	};

	$container['UserController'] = function ($container) {
		return new \App\Controllers\Auth\UserController($container);
	};

	require '../app/routes.php';

