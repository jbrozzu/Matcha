<?php

	namespace App\Controllers\Auth;

	use App\Controllers\Controller;
	use App\Models\User;


	class AuthController extends Controller
	{
		protected $user;

		public function getSignup($request, $response)
		{
			if ($this->isLogged())
			{
				return $response->withRedirect($this->router->pathFor('home'));	
			}

			return $this->view->render($response, 'auth/signup.twig');
		}

		public function postSignup($request, $response)
		{
			$this->user = new User($this->container);
			if ($this->checkEmail($request->getParam('email')) AND $this->checkName($request->getParam('pseudo')) 
				AND $this->checkPassword($request->getParam('password'), $request->getParam('passwordbis')))
			{
				$this->user->createUser($request);
				$_SESSION['pseudo'] = ucfirst($request->getParam('pseudo'));
				return $response->withRedirect($this->router->pathFor('home'));	
			}

			return $response->withRedirect($this->router->pathFor('auth.signup'));
		}

		public function getLogin($request, $response)
		{
			if ($this->isLogged())
			{
				return $response->withRedirect($this->router->pathFor('home'));	
			}
			
			return $this->view->render($response, 'auth/login.twig');
		}

		public function postLogin($request, $response)
		{
			$this->user = new User($this->container);
			if ($this->user->checkLog($request->getParam('pseudo'), $request->getParam('password')) == 2)
			{
				$_SESSION['pseudo'] = ucfirst($request->getParam('pseudo'));
				return $response->withRedirect($this->router->pathFor('home'));
			}
			elseif ($this->user->checkLog($request->getParam('pseudo'), $request->getParam('password')) == 1)
			{
				$this->flash->addMessage('error', 'Ce mot de passe est invalide');
				return $response->withRedirect($this->router->pathFor('auth.login'));
			}
			else
			{
				$this->flash->addMessage('error', 'Ce pseudo n\'existe pas');
				return $response->withRedirect($this->router->pathFor('auth.login'));
			}
		}

		public function logout($request, $response)
		{
			session_start();
			session_destroy();
			return $response->withRedirect($this->router->pathFor('home'));
		}

	}
