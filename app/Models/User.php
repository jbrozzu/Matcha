<?php

namespace App\Models;

use App\Models\Model;


class User extends Model
{
	public function createUser($request)
	{
		$query = $this->container->db->prepare("INSERT INTO users (pseudo, nom, prenom, email, password, latitude, longitude, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
		$query->execute(array($request->getParam('pseudo'), $request->getParam('nom'), $request->getParam('prenom'), $request->getParam('email'), hash('whirlpool', $request->getParam('password')), $request->getParam('lat'), $request->getParam('lng')));
	}

	public function nameExist($pseudo)
	{
		$req_pseudo = $this->container->db->prepare('SELECT pseudo FROM users where pseudo = :pseudo');
		$req_pseudo->bindParam(':pseudo', $pseudo);
		$req_pseudo->execute();
		if ($req_pseudo->fetchColumn()) 
		{
			return true;
		}
		return false;
	}

	public function emailExist($email)
	{
		$req_email = $this->db->prepare('SELECT email FROM users where email = :email');
		$req_email->bindParam(':email', $email);
		$req_email->execute();
		if ($req_email->fetchColumn()) 
		{
			return true;
		}
		return false;
	}

	public function checkLog($pseudo, $password)
	{
		$req_pseudo = $this->db->prepare('SELECT pseudo FROM users where pseudo = :pseudo');
		$req_pseudo->bindParam(':pseudo', $pseudo);
		$req_pseudo->execute();

		if ($req_pseudo->fetchColumn() == $pseudo) 
		{
			$req_password = $this->db->prepare('SELECT password FROM users where pseudo = :pseudo');
		    $req_password->bindParam(':pseudo', $pseudo);
			$req_password->execute();
			if ($req_password->fetchColumn() == hash('whirlpool', $password))
			{
				return 2;
			}
			else 
			{
				return 1;
			}
	    }
	    else 
	    {
	    	return 0;
	    }
    }

    public function getProfilInfos()
    {
    	$req = $this->container->db->prepare('SELECT * FROM users where pseudo = :pseudo');
    	$req->bindParam(':pseudo', $_SESSION['pseudo']);
    	$req->execute();
    	$result = $req->fetch();
    	
    	return $result;
    }

    public function saveNewProfil($pseudo, $email, $nom, $prenom, $date_naissance, $sexe, $orientation, $password, $latitude, $longitude)
    {
    	if ($password == '')
    	{
    		$req = $this->container->db->prepare('UPDATE users SET pseudo = ?, email = ?, nom = ?, prenom = ?, date_naissance = ?, sexe = ?, orientation = ?, latitude = ?, longitude = ? WHERE pseudo = ?');
    		$req->execute(array($pseudo, $email, $nom, $prenom, $date_naissance, $sexe, $orientation, $latitude, $longitude, $_SESSION['pseudo']));
    	}
    	else
    	{
    		$req = $this->container->db->prepare('UPDATE users SET pseudo = ?, email = ?, nom = ?, prenom = ?, date_naissance = ?, sexe = ?, orientation = ?, password = ?, latitude = ?, longitude = ? WHERE pseudo = ?');
    		$req->execute(array($pseudo, $email, $nom, $prenom, $date_naissance, $sexe, $orientation, hash('whirlpool', $password), $latitude, $longitude, $_SESSION['pseudo']));
		}

    }

}




