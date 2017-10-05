<?php

	namespace App\Controllers;

	use App\Models\User;

	class Controller
	{

		protected $container;
		protected $user;
		

		public function __construct($container)
		{
			$this->container = $container;
			$this->user = new User($this->container);
		}


		public function __get($property)
		{
			if ($this->container->{$property}) 
			{
				return $this->container->{$property};
			}
		}


		public function isLogged()
        {
        	if (isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo']))
        		return true;
        	return false;
        }


        protected function checkEmail($email)
		{
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
				$this->flash->addMessage('error', 'L\'adresse e-mail est invalide');
				return false;
			}
			if ($this->user->emailExist($email) && $email != $_SESSION['email'])
			{
				$this->flash->addMessage('error', 'Cette adresse e-mail est déjà prise');
				return false;
			}
			return true;
		}


		protected function checkName($pseudo)
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


		protected function checkPassword($password, $passwordbis)
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

		public function getProfil($request, $response)
		{
			if ($this->isLogged())
			{
				$req = $this->user->getProfilInfos();
				$_SESSION['id'] = $req['id'];
				$_SESSION['email'] = $req['email'];
				$_SESSION['nom'] = ($req['nom'] != NULL ? $req['nom'] : "NULL");
				$_SESSION['prenom'] = ($req['prenom'] != NULL ? $req['prenom'] : "NULL");
				$_SESSION['date_naissance'] = ($req['date_naissance'] != NULL ? str_replace('-', '/', date("d/m/Y", strtotime($req['date_naissance']))) : "NULL");
				$_SESSION['sexe'] = ($req['sexe'] != NULL ? $req['sexe'] : "NULL");
				$_SESSION['orientation'] = $req['orientation'];
				$_SESSION['hobby'] = ($req['hobby'] != NULL ? $req['hobby'] : "NULL");
				$_SESSION['latitude'] = $req['latitude'];
				$_SESSION['longitude'] = $req['longitude'];


				$req_img = $this->user->getPictures();
				$_SESSION['img1'] = ($req_img['img1'] != NULL ? $req_img['img1'] : "NULL");
				$_SESSION['img2'] = ($req_img['img2'] != NULL ? $req_img['img2'] : "NULL");
				$_SESSION['img3'] = ($req_img['img3'] != NULL ? $req_img['img3'] : "NULL");
				$_SESSION['img4'] = ($req_img['img4'] != NULL ? $req_img['img4'] : "NULL");
				$_SESSION['img5'] = ($req_img['img5'] != NULL ? $req_img['img5'] : "NULL");
				$_SESSION['picProfil'] = ($req_img['img_profil'] != NULL ? $req_img['img_profil'] : "NULL");

				return $this->view->render($response, 'auth/profil.twig');
			}

			return $response->withRedirect($this->router->pathFor('home'));
		}


	}