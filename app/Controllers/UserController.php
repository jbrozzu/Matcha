<?php

	namespace App\Controllers;

	use App\Controllers\Controller;

	class UserController extends Controller
	{
		public function getSignup($request, $response)
		{
			$this->view->render($response, 'signup.php');
		}

		public function postSignup($request, $response)
		{
			$query = $this->db->prepare("INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())");
			$query->execute(array($request->getParam('name'), $request->getParam('email'), $request->getParam('pass')));
			
			return $response->withRedirect($this->router->pathFor('home'));
			// return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('home'));
		}
	}