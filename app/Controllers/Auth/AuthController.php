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
				$this->getProfil($request, $response);
				$this->checkNotifVisit($_SESSION['pseudo'], $_SESSION['id']);
				return $response->withRedirect($this->router->pathFor('home'));	
			}

			return $response->withRedirect($this->router->pathFor('auth.signup'));
		}

		public function checkNotifVisit($pseudo, $id)
		{
			$_SESSION['notifs'] = $this->user->getNotif($pseudo, $id);
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
				$this->getProfil($request, $response);
				$this->checkNotifVisit($_SESSION['pseudo'], $_SESSION['id']);
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

		public function getForgot($request, $response)
		{	
			return $this->view->render($response, 'auth/forgot.twig');
		}

		public function postForgot($request, $response)
		{	
			$email = $request->getParam('email');
			$pseudo = $request->getParam('pseudo');
			$num = $this->user->checkForgot($pseudo, $email);
			if ($num == "1")
			{	
				$seed = str_split('aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ');
		        shuffle($seed);
		        $rand = '';
		        foreach (array_rand($seed, 7) as $k) $rand .= $seed[$k];
		        $rand = $rand . rand(1, 9);
		        $hash = hash('whirlpool', $rand);

		        $this->user->saveNewPass($pseudo, $email, $hash);

		        $to      = $email;
				$subject = 'Réinitialisation';
				$message = '
				 
				Votre mot de passe a été réinitialisé.
				Vous pouvez dès à présent vous connecter avec votre nouveau mot de passe.
				 
				------------------------
				Username: '.$pseudo.'
				nouveau mot de passe: '.$rand.'
				------------------------
				 
				Cliquez sur ce lien pour revenir sur le site Matcha:
				http://localhost:8080/Matcha/public/auth/login
				
				';
				                     
				$headers = 'From:noreply@yourwebsite.com' . "\r\n";
				mail($to, $subject, $message, $headers);



				$this->flash->addMessage('error', 'Un nouveau mot de passe vient de vous être envoyé');
				return $response->withRedirect($this->router->pathFor('home'));
			}
			else if ($num == "2")
			{
				$this->flash->addMessage('error', 'Cet e-mail ne correspond pas au pseudo');
				return $response->withRedirect($this->router->pathFor('auth.forgot'));
			}
			else 
			{
				$this->flash->addMessage('error', 'Ce pseudo n\'existe pas');
				return $response->withRedirect($this->router->pathFor('auth.forgot'));
			}
		}
	}
