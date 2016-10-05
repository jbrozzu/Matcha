<?php

	$app->get('/', 'HomeController:index')->setName('home');

	$app->get('/auth/signup', 'AuthController:getSignup')->setName('auth.signup');
	$app->post('/auth/signup', 'AuthController:postSignup');

	$app->get('/auth/login', 'AuthController:getLogin')->setName('auth.login');
	$app->post('/auth/login', 'AuthController:postLogin');

	$app->get('/auth/logout', 'AuthController:logout')->setName('auth.logout');