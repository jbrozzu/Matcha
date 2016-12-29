<?php

	namespace App\Controllers\Auth;

	use App\Controllers\Controller;
	use App\Models\User;

	class ProfilController extends Controller
	{

		public function getProfil($request, $response)
		{
			if ($this->isLogged())
			{
				$req = $this->user->getProfilInfos();
				$_SESSION['email'] = $req['email'];
				$_SESSION['nom'] = ($req['nom'] != NULL ? $req['nom'] : "NULL");
				$_SESSION['prenom'] = ($req['prenom'] != NULL ? $req['prenom'] : "NULL");
				$_SESSION['date_naissance'] = ($req['date_naissance'] != NULL ? str_replace('-', '/', date("d/m/Y", strtotime($req['date_naissance']))) : "NULL");
				$_SESSION['sexe'] = ($req['sexe'] != NULL ? $req['sexe'] : "NULL");
				$_SESSION['orientation'] = $req['orientation'];
				$_SESSION['latitude'] = $req['latitude'];
				$_SESSION['longitude'] = $req['longitude'];

				return $this->view->render($response, 'auth/profil.twig');
			}

			return $response->withRedirect($this->router->pathFor('home'));
		}


		public function updateProfil($request, $response)
		{
			return $this->view->render($response, 'auth/updateProfil.twig');
		}


		private function checkDate($date)
		{
			
			if (!preg_match('/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/', $date))
			{
				$this->flash->addMessage('error', 'Mauvais format de la date de naissance (jj/mm/aaaa)');
			 	return false;
			}
			list($dd, $mm, $yyyy) = explode('/', $date);
			if (!checkdate($mm, $dd, $yyyy)) 
			{
			    $this->flash->addMessage('error', 'La date de naissance n\'est pas valide');
			 	return false;
			}
			if ($yyyy > 2016 || $yyyy < 1900)
			{
			    $this->flash->addMessage('error', 'L\'année de la date de naissance n\'est pas valide');
			 	return false;
			}
			return true;
		}

		private function checkPasswordChange($password, $passwordbis)
		{
			if ($password == '' && $passwordbis == '')
			{
				return true;
			}
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


		public function postProfil($request, $response)
		{
			$date = NULL;

	    	if ($this->checkDate($request->getParam('date_naissance')) == false || $this->checkEmail($request->getParam('email')) == false || $this->checkPasswordChange($request->getParam('password'), $request->getParam('passwordbis')) == false)
	    	{
	    		return $response->withRedirect($this->router->pathFor('update_profil'));
	    	}
	    	else
	    	{
	    		if ($request->getParam('date_naissance') != NULL)
	    		{
		    		$date = str_replace('/', '-', $request->getParam('date_naissance'));
		    		$date = date("Y-m-d", strtotime($date));
		    	}

	    		$this->user->saveNewProfil($request->getParam('pseudo'), $request->getParam('email'), $request->getParam('nom'),
	    			$request->getParam('prenom'), $date, $request->getParam('sexe'), $request->getParam('orientation'), 
	    			$request->getParam('password'), $request->getParam('lat'), $request->getParam('lng'));
				return $response->withRedirect($this->router->pathFor('auth.profil'));
	    	}
		}

	}


