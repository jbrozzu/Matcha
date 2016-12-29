<?php

	session_start();

	require __DIR__ . '/../vendor/autoload.php';



	$app = new \Slim\App([
		'settings' => [
			'displayErrorDetails' => true,
			'db'=> [
				'driver' => 'mysql',
				'host' => 'localhost',
				'database' => 'matcha',
				'username' => 'root',
				'password' => 'root'
			]
		]
	]);


	$container = $app->getContainer();

	$container['db'] = function ($container) {
	    $db = $container['settings']['db'];
	    $bdd = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['database'], $db['username'], $db['password']);
	    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	    return $bdd;
	};

	$container['view'] = function ($container) {
		$view = new \Slim\Views\Twig(__DIR__ . '/../ressources/views', [
			'cache' => false,
		]);

		$view->addExtension(new \Slim\Views\TwigExtension(
			$container->router,
			$container->request->getUri()
		));
		$view->getEnvironment()->addGlobal('flash', $container['flash']);
		$view->getEnvironment()->addGlobal('session', $_SESSION);
		$view->getEnvironment()->addGlobal('auth', $container['AuthController']);

		return $view;
	};

	$container['HomeController'] = function ($container){
		return new \App\Controllers\HomeController($container);
	};

	$container['AuthController'] = function ($container){
		return new \App\Controllers\Auth\AuthController($container);
	};

	$container['ProfilController'] = function ($container){
		return new \App\Controllers\Auth\ProfilController($container);
	};

	$container['flash'] = function () {
		return new \Slim\Flash\Messages();
	};

	require __DIR__ . '/../app/routes.php';

