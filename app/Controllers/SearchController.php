<?php

	namespace App\Controllers;

	use App\Models\User;


	class SearchController extends Controller
	{

		public function getSearch($request, $response)
		{
			$_SESSION['allProfil'] = $this->user->getAllProfil();

			return $this->view->render($response, 'search/search.twig');
		}


		public function getSearchAdd ($request, $response)
		{
			return $this->view->render($response, 'search/searchbis.twig');
		}


		public function postSearch($request, $response)
		{
			$_SESSION['allProfil'] = $this->user->getSomeProfil($request->getParam('age'), $request->getParam('localisation'), $request->getParam('hash'));
			if ($_SESSION['allProfil'] == "error")
			{
				$_SESSION['allProfil'] = $this->user->getAllProfil();
			}
			return $response->withRedirect($this->router->pathFor('search_add'));
		}


		public function getProfil($request, $response, $args)
		{
			$_SESSION['searchProfil'] = $this->user->getProfilInfos($args['id']);
			$_SESSION['searchPicture'] = $this->user->getPictures($args['id']);
			
			if ($_SESSION['searchProfil']['date_naissance'] != '')
			{
				$_SESSION['searchProfil']['age'] = $this->user->getAge($_SESSION['searchProfil']['date_naissance']);
				$_SESSION['searchProfil']['date_naissance'] = str_replace('-', '/', date("d/m/Y", strtotime($_SESSION['searchProfil']['date_naissance'])));
			}

			//Enregistrer le fait que le profil a été visité

			$this->user->saveVisit($args['id']);

			return $this->view->render($response, 'search/searchprofil.twig');
		}

	}