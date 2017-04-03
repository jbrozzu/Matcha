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

	}