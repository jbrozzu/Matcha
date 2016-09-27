<?php

	$app->get('/', 'HomeController:index')->setName('home');

	$app->get('/auth/signup', 'UserController:getSignup')->setName('user.signup');
	$app->post('/auth/signup', 'UserController:postSignup');

	// $app->get('/{id}', 'UsersController:editLocation')->setName('editLocation');


	$app->get('/contact', function($request, $response){
	    return $this->view->render($response, 'contact.php');
	});