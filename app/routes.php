<?php

	$app->get('/', 'HomeController:index')->setName('home');

	$app->get('/signup', 'UserController:getSignup')->setName('user.signup');
	$app->post('/signup', 'UserController:postSignup');

	// $app->get('/signup', UserController::class.":getSignup")->setName('user.signup');
	// $app->post('/signup', UserController::class.":postSignup");

	// $app->get('/{id}', 'UsersController:editLocation')->setName('editLocation');


	$app->get('/contact', function($request, $response){
	    return $this->view->render($response, 'contact.php');
	});