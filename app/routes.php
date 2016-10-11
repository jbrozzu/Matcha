<?php

	$app->get('/', 'HomeController:index')->setName('home');

	$app->get('/auth/signup', 'AuthController:getSignup')->setName('auth.signup');
	$app->post('/auth/signup', 'AuthController:postSignup');

	$app->get('/auth/login', 'AuthController:getLogin')->setName('auth.login');
	$app->post('/auth/login', 'AuthController:postLogin');

	$app->get('/auth/logout', 'AuthController:logout')->setName('auth.logout');

	$app->get('/auth/profil', 'AuthController:getProfil')->setName('auth.profil');
	$app->get('/auth/update', 'AuthController:updateProfil')->setName('update_profil');
	$app->post('/auth/update', 'AuthController:postProfil');
