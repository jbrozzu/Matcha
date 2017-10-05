<?php

	namespace App\Controllers\Auth;

	use App\Controllers\Controller;
	use App\Models\User;

	class ProfilController extends Controller
	{

		// public function getProfil($request, $response)
		// {
		// 	if ($this->isLogged())
		// 	{
		// 		$req = $this->user->getProfilInfos();
		// 		$_SESSION['email'] = $req['email'];
		// 		$_SESSION['nom'] = ($req['nom'] != NULL ? $req['nom'] : "NULL");
		// 		$_SESSION['prenom'] = ($req['prenom'] != NULL ? $req['prenom'] : "NULL");
		// 		$_SESSION['date_naissance'] = ($req['date_naissance'] != NULL ? str_replace('-', '/', date("d/m/Y", strtotime($req['date_naissance']))) : "NULL");
		// 		$_SESSION['sexe'] = ($req['sexe'] != NULL ? $req['sexe'] : "NULL");
		// 		$_SESSION['orientation'] = $req['orientation'];
		// 		$_SESSION['hobby'] = ($req['hobby'] != NULL ? $req['hobby'] : "NULL");
		// 		$_SESSION['latitude'] = $req['latitude'];
		// 		$_SESSION['longitude'] = $req['longitude'];


		// 		$req_img = $this->user->getPictures();
		// 		$_SESSION['img1'] = ($req_img['img1'] != NULL ? $req_img['img1'] : "NULL");
		// 		$_SESSION['img2'] = ($req_img['img2'] != NULL ? $req_img['img2'] : "NULL");
		// 		$_SESSION['img3'] = ($req_img['img3'] != NULL ? $req_img['img3'] : "NULL");
		// 		$_SESSION['img4'] = ($req_img['img4'] != NULL ? $req_img['img4'] : "NULL");
		// 		$_SESSION['img5'] = ($req_img['img5'] != NULL ? $req_img['img5'] : "NULL");
		// 		$_SESSION['picProfil'] = ($req_img['img_profil'] != NULL ? $req_img['img_profil'] : "NULL");

		// 		return $this->view->render($response, 'auth/profil.twig');
		// 	}

		// 	return $response->withRedirect($this->router->pathFor('home'));
		// }


		public function updateProfil($request, $response)
		{
			return $this->view->render($response, 'auth/updateProfil.twig');
		}

		public function updatePicture($request, $response)
		{
			return $this->view->render($response, 'auth/updatePicture.twig');
		}


		private function checkDate($date)
		{
			if ($date == '')
			{
				return true;
			}
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


		private function checkHobby($hobby)
		{
			if ($hobby == '')
			{
				return true;
			}
			$hobbytab = explode(" ", $hobby);
			foreach ($hobbytab as $value) {
				$value = "-" . $value . "-";
				if (!preg_match('/-#[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜ_-]+-/', $value))
				{
					$this->flash->addMessage('error', 'Mauvais format pour les points d\'intérêt (ne pas oublier l\'espace entre chaque mot).');
					return false;
				}
			}

			if (strlen($hobby) > 50)
			{
				$this->flash->addMessage('error', 'Le nombre max de caractères pour les points d\'intérêts a été dépassé.');
				return false;
			}
			return true;
		}


		public function postProfil($request, $response)
		{
			$date = NULL;

	    	if ($this->checkDate($request->getParam('date_naissance')) == false || 
	    		$this->checkEmail($request->getParam('email')) == false || 
	    		$this->checkPasswordChange($request->getParam('password'), $request->getParam('passwordbis')) == false ||
	    		$this->checkHobby($request->getParam('hobby')) == false)
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
	    			$request->getParam('password'), $request->getParam('hobby'), $request->getParam('lat'), $request->getParam('lng'));
				return $response->withRedirect($this->router->pathFor('auth.profil'));
	    	}
		}

		private function checkPicture()
		{
			$tabExt = array('jpg','gif','png','jpeg');

			if(!empty($_FILES))
			{
			  	if( !empty($_FILES['fichier']['name']) )
			  	{
			  		$extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
			    	if(in_array(strtolower($extension), $tabExt))
			    	{
			      		$infosImg = getimagesize($_FILES['fichier']['tmp_name']);
			      		if($infosImg[2] >= 1 && $infosImg[2] <= 14)
			      		{
			        		if(($infosImg[0] <= 10000) && ($infosImg[1] <= 5000) && (filesize($_FILES['fichier']['tmp_name']) <= 5000000))
			        		{
			        			return true;
			        		}
			        		else
			        		{
			          			$this->flash->addMessage('error', 'Erreur dans les dimensions de l\'image !');
			          			return false;
			        		}
			      		}
			      		else
			      		{
			        		$this->flash->addMessage('error', 'Le fichier à uploader n\'est pas une image !');
			        		return false;
			      		}
			    	}
			    	else
			    	{
			      		$this->flash->addMessage('error', 'L\'extension du fichier est incorrecte !');
			      		return false;
			    	}
			  	}
			  	else 
			  	{
			    	$this->flash->addMessage('error', 'Veuillez selectionner un fichier svp !');
			    	return false;
			  	}
			}
		}

		public function postPicture($request, $response)
		{
			if( !is_dir('../ressources/pictures/' . $_SESSION['pseudo']) ) {
			  	if( !mkdir('../ressources/pictures/' . $_SESSION['pseudo'], 0755) ) {
			    	exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
			  	}
			}
			
			if ($this->checkPicture() == true)
			{
				if ($_SESSION['img1'] == "NULL")
				{
					$picName = $_SESSION['pseudo'] . '/pic_1.png';
					move_uploaded_file($_FILES['fichier']['tmp_name'], '../ressources/pictures/'. $picName);
					$this->user->saveNewPicture("pic_1.png");
					$_SESSION['img1'] = $picName;
				}
				else if ($_SESSION['img2'] == "NULL")
				{
					$picName = $_SESSION['pseudo'] . '/pic_2.png';
					move_uploaded_file($_FILES['fichier']['tmp_name'], '../ressources/pictures/'. $picName);
					$this->user->saveNewPicture("pic_2.png");
					$_SESSION['img2'] = $picName;
				}
				else if ($_SESSION['img3'] == "NULL")
				{
					$picName = $_SESSION['pseudo'] . '/pic_3.png';
					move_uploaded_file($_FILES['fichier']['tmp_name'], '../ressources/pictures/'. $picName);
					$this->user->saveNewPicture("pic_3.png");
					$_SESSION['img3'] = $picName;
				}
				else if ($_SESSION['img4'] == "NULL")
				{
					$picName = $_SESSION['pseudo'] . '/pic_4.png';
					move_uploaded_file($_FILES['fichier']['tmp_name'], '../ressources/pictures/'. $picName);
					$this->user->saveNewPicture("pic_4.png");
					$_SESSION['img4'] = $picName;
				}
				else if ($_SESSION['img5'] == "NULL")
				{
					$picName = $_SESSION['pseudo'] . '/pic_5.png';
					move_uploaded_file($_FILES['fichier']['tmp_name'], '../ressources/pictures/'. $picName);
					$this->user->saveNewPicture("pic_5.png");
					$_SESSION['img5'] = $picName;
				}
				else
				{
					$this->flash->addMessage('error', 'Vous avez déjà le nombre max de photos.');
					return $response->withRedirect($this->router->pathFor('update_picture'));
				}
				
	            $this->flash->addMessage('error', 'Upload réussi !');
				return $response->withRedirect($this->router->pathFor('update_picture'));
			}
			else 
			{
				return $response->withRedirect($this->router->pathFor('update_picture'));
			}

		}

		public function deletePicture($request, $response, $args)
		{
			$img = 'img' . $args['id'];
			$this->user->deleteDataPic($args['id']);
			$_SESSION[$img] = "NULL";
			$this->flash->addMessage('error', 'La photo a bien été supprimé.');
			return $response->withRedirect($this->router->pathFor('update_picture'));
		}
	}


