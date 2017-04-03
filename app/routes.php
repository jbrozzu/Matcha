<?php

	$app->get('/', 'HomeController:index')->setName('home');

	$app->get('/auth/signup', 'AuthController:getSignup')->setName('auth.signup');
	$app->post('/auth/signup', 'AuthController:postSignup');

	$app->get('/auth/login', 'AuthController:getLogin')->setName('auth.login');
	$app->post('/auth/login', 'AuthController:postLogin');

	$app->get('/auth/logout', 'AuthController:logout')->setName('auth.logout');

	$app->get('/auth/profil', 'ProfilController:getProfil')->setName('auth.profil');
	$app->get('/auth/update', 'ProfilController:updateProfil')->setName('update_profil');
	$app->post('/auth/update', 'ProfilController:postProfil');

	$app->get('/auth/update_pic', 'ProfilController:updatePicture')->setName('update_picture');
	$app->post('/auth/update_pic', 'ProfilController:postPicture');

	$app->get('/auth/delete_pic/{id}', 'ProfilController:deletePicture')->setName('delete_pic');

	$app->get('/search', 'SearchController:getSearch')->setName('search');
	$app->post('/search', 'SearchController:postSearch');
	$app->get('/search_add', 'SearchController:getSearchAdd')->setName('search_add');
	$app->get('/search/{id}', 'SearchController:getProfil')->setName('profil_search');

