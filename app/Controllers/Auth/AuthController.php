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

		public function getProfil($request, $response)
		{
			if ($this->isLogged())
			{
				$this->user = new User($this->container);
				$req = $this->user->getProfilInfos($_SESSION['pseudo']);
				$_SESSION['nom'] = ($req['nom'] != NULL ? $req['nom'] : "N/A");
				$_SESSION['prenom'] = ($req['prenom'] != NULL ? $req['prenom'] : "N/A");
				$_SESSION['date_naissance'] = ($req['date_naissance'] != NULL ? $req['date_naissance'] : "N/A");
				$_SESSION['sexe'] = ($req['sexe'] != NULL ? $req['sexe'] : "N/A");
				$_SESSION['orientation'] = ($req['orientation'] != NULL ? $req['orientation'] : "N/A");
				$_SESSION['localisation'] = ($req['localisation'] != NULL ? $req['localisation'] : "N/A");

				return $this->view->render($response, 'auth/profil.twig');
			}

			return $response->withRedirect($this->router->pathFor('home'));
		}

		public function updateProfil($request, $response)
		{
			return $this->view->render($response, 'auth/updateProfil.twig');
		}

		public function isLogged()
        {
        	if (isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo']))
        		return true;
        	return false;
        }

		private function checkEmail($email)
		{
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
				$this->flash->addMessage('error', 'L\'adresse e-mail est invalide');
				return false;
			}
			if ($this->user->emailExist($email))
			{
				$this->flash->addMessage('error', 'Cette adresse e-mail est déjà prise');
				return false;
			}
			return true;
		}

		private function checkName($pseudo)
		{
			if (strlen($pseudo) > 20) 
			{
				$this->flash->addMessage('error', 'Ce pseudo est trop long (20 caractères max)');
				return false;
			}
			if (!preg_match('/^[A-Za-z0-9_]+$/', $pseudo))
			{
				$this->flash->addMessage('error', 'Le pseudo est invalide (lettres, chiffres et underscore uniquement)');
				return false;
			}
			if ($this->user->nameExist($pseudo))
			{
				$this->flash->addMessage('error', 'Ce pseudo est déjà pris');
				return false;
			}
			return true;
		}

		private function checkPassword($password, $passwordbis)
		{
			if (strlen($password) < 8 || !preg_match('`\d`si', $password))
			{
				$this->flash->addMessage('error', 'Votre mot de passe doit contenir 8 caractères minimum (avec au moins un chiffre)');
				return false;
			}
			if ($password != $passwordbis) 
			{
				$this->flash->addMessage('error', 'Le mot de passe et la confirmation ne sont pas identiques');
				return false;
			}
			return true;
		}
	}