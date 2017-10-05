<?php

namespace App\Models;

use App\Models\Model;


class User extends Model
{
	public function createUser($request)
	{
		$query = $this->container->db->prepare("INSERT INTO users (pseudo, nom, prenom, email, password, latitude, longitude, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
		$query->execute(array($request->getParam('pseudo'), $request->getParam('nom'), $request->getParam('prenom'), 
            $request->getParam('email'), hash('whirlpool', $request->getParam('password')), $request->getParam('lat'), $request->getParam('lng')));
		$query = $this->container->db->prepare("INSERT INTO Images (pseudo) VALUES (?)");
		$query->execute(array($request->getParam('pseudo')));
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

    public function getProfilInfos($pseudo = false)
    {
        if (!$pseudo)
        {
        	$req = $this->db->prepare('SELECT * FROM users where pseudo = :pseudo');
        	$req->bindParam(':pseudo', $_SESSION['pseudo']);
        }
        else
        {
            $req = $this->db->prepare('SELECT * FROM users where pseudo = :pseudo');
            $req->bindParam(':pseudo', $pseudo);
        }
    	$req->execute();
    	$result = $req->fetch();
    	
    	return $result;
    }


    public function getPictures($pseudo = false)
    {
        if (!$pseudo)
        {
    	   $req = $this->db->prepare('SELECT * FROM Images where pseudo = :pseudo');
    	   $req->bindParam(':pseudo', $_SESSION['pseudo']);
        }
        else
        {
            $req = $this->db->prepare('SELECT * FROM Images where pseudo = :pseudo');
            $req->bindParam(':pseudo', $pseudo);
        }
    	$req->execute();
    	$result = $req->fetch();
    	
    	return $result;
    }


    public function saveNewProfil($pseudo, $email, $nom, $prenom, $date_naissance, $sexe, $orientation, $password, $hobby, $latitude, $longitude)
    {
    	if ($password == '')
    	{
    		$req = $this->db->prepare('UPDATE users SET pseudo = ?, email = ?, nom = ?, prenom = ?, date_naissance = ?, sexe = ?, orientation = ?, hobby = ?, latitude = ?, longitude = ? WHERE pseudo = ?');
    		$req->execute(array($pseudo, $email, $nom, $prenom, $date_naissance, $sexe, $orientation, $hobby, $latitude, $longitude, $_SESSION['pseudo']));
    	}
    	else
    	{
    		$req = $this->db->prepare('UPDATE users SET pseudo = ?, email = ?, nom = ?, prenom = ?, date_naissance = ?, sexe = ?, orientation = ?, hobby = ?, password = ?, latitude = ?, longitude = ? WHERE pseudo = ?');
    		$req->execute(array($pseudo, $email, $nom, $prenom, $date_naissance, $sexe, $orientation, $hobby, hash('whirlpool', $password), $latitude, $longitude, $_SESSION['pseudo']));
		}

    }


    private function setProfilPic()
    {
        $req = $this->db->prepare('SELECT * FROM Images where pseudo = :pseudo');
        $req->bindParam(':pseudo', $_SESSION['pseudo']);
        $req->execute();
        $imgs = $req->fetch();

        if ($imgs['img1'] != 'NULL')
        {
            $req = $this->db->prepare('UPDATE Images SET img_profil = ? WHERE pseudo = ?');
            $req->execute(array($imgs['img1'], $_SESSION['pseudo']));
        }
        else if ($imgs['img2'] != 'NULL')
        {
            $req = $this->db->prepare('UPDATE Images SET img_profil = ? WHERE pseudo = ?');
            $req->execute(array($imgs['img2'], $_SESSION['pseudo']));
        }
        else if ($imgs['img3'] != 'NULL')
        {
            $req = $this->db->prepare('UPDATE Images SET img_profil = ? WHERE pseudo = ?');
            $req->execute(array($imgs['img3'], $_SESSION['pseudo']));
        }
        else if ($imgs['img4'] != 'NULL')
        {
            $req = $this->db->prepare('UPDATE Images SET img_profil = ? WHERE pseudo = ?');
            $req->execute(array($imgs['img4'], $_SESSION['pseudo']));
        }
        else if ($imgs['img5'] != 'NULL')
        {
            $req = $this->db->prepare('UPDATE Images SET img_profil = ? WHERE pseudo = ?');
            $req->execute(array($imgs['img5'], $_SESSION['pseudo']));
        }
        else
        {
             $req = $this->db->prepare('UPDATE Images SET img_profil = "NULL" WHERE pseudo = ?');
             $req->execute(array($_SESSION['pseudo']));
        }
    }


    public function saveNewPicture($picName)
     {
     	if ($picName == "pic_1.png")
     	{
     		$req = $this->db->prepare('UPDATE Images SET img1 = ? WHERE pseudo = ?');
    		$req->execute(array($_SESSION['pseudo'] . "/" . $picName, $_SESSION['pseudo']));
    	}
    	else if ($picName == "pic_2.png")
     	{
     		$req = $this->db->prepare('UPDATE Images SET img2 = ? WHERE pseudo = ?');
    		$req->execute(array($_SESSION['pseudo'] . "/" . $picName, $_SESSION['pseudo']));
    	}
    	else if ($picName == "pic_3.png")
     	{
     		$req = $this->db->prepare('UPDATE Images SET img3 = ? WHERE pseudo = ?');
    		$req->execute(array($_SESSION['pseudo'] . "/" . $picName, $_SESSION['pseudo']));
    	}
    	else if ($picName == "pic_4.png")
     	{
     		$req = $this->db->prepare('UPDATE Images SET img4 = ? WHERE pseudo = ?');
    		$req->execute(array($_SESSION['pseudo'] . "/" . $picName, $_SESSION['pseudo']));
    	}
    	else if ($picName == "pic_5.png")
     	{
     		$req = $this->db->prepare('UPDATE Images SET img5 = ? WHERE pseudo = ?');
    		$req->execute(array($_SESSION['pseudo'] . "/" . $picName, $_SESSION['pseudo']));
    	}

        $this->setProfilPic();

     }


    public function deleteDataPic($id)
    {
    	$req = $this->db->prepare('UPDATE Images SET img' . $id . ' = "NULL" WHERE pseudo = ?');
    	$req->execute(array($_SESSION['pseudo']));

        $this->setProfilPic();
    }


    public function getAge($date)
    {
        $age = date('Y') - date('Y', strtotime($date));
        if (date('md') < date('md', strtotime($date))) 
        {
            return $age - 1;
        }
        return $age;
    }


    public function getAllProfil()
    {
        $req = $this->db->prepare('SELECT users.pseudo, users.nom, users.prenom, users.date_naissance, Images.img_profil 
                                    FROM users INNER JOIN Images 
                                    ON users.pseudo = Images.pseudo WHERE users.pseudo != ?');
        $req->execute(array($_SESSION['pseudo']));
        $req->execute();
        $result = $req->fetchAll();
        
        return $result;
    }


    public function getSomeProfil($age, $localisation, $hobby)
    {

        $_SESSION['ageSearch'] = $age;
        $_SESSION['localisationSearch'] = $localisation;
        $_SESSION['hobbySearch'] = $hobby;

        $query = "SELECT users.pseudo, users.nom, users.prenom, users.date_naissance, Images.img_profil 
                                    FROM users INNER JOIN Images 
                                    ON users.pseudo = Images.pseudo WHERE users.pseudo != ?";


        if ($hobby != '')
        {
            $hobbytab = explode(" ", $hobby);
            $hobbyTabClean = array();
            foreach ($hobbytab as $value) {
                $value = "-" . $value . "-";
                if (!preg_match('/-#[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜ_]+-/', $value))
                {
                    $this->flash->addMessage('error', 'Mauvais format pour les points d\'intérêt (ne pas oublier le "#" et l\'espace entre chaque mot).');
                    return "error";
                }
                else {
                    array_push($hobbyTabClean, str_replace('-', '', $value));
                }
            }
            if (!empty($hobbyTabClean))
            {
                $queryAdd = "";
                foreach ($hobbyTabClean as $value) {
                    $queryAdd .= " AND users.hobby LIKE '%" . $value . "%'";
                }
                $query .= $queryAdd;
            }
        }


        if ($age == 1) 
        { 
            $query .= " AND users.date_naissance != 'NULL' AND year(users.date_naissance) >= (year(current_timestamp) - 25) 
                        AND year(users.date_naissance) <= (year(current_timestamp) - 18)";
        }
        if ($age == 2) 
        { 
            $query .= " AND users.date_naissance != 'NULL' AND year(users.date_naissance) >= (year(current_timestamp) - 40) 
                        AND year(users.date_naissance) <= (year(current_timestamp) - 26)";
        }
        if ($age == 3) 
        { 
            $query .= " AND users.date_naissance != 'NULL' AND year(users.date_naissance) >= (year(current_timestamp) - 60) 
                        AND year(users.date_naissance) <= (year(current_timestamp) - 41)";
        }
        if ($age == 4) 
        { 
            $query .= " AND users.date_naissance != 'NULL' AND year(users.date_naissance) <= (year(current_timestamp) - 61)";
        }

        // ----------------

        if ($localisation == 1)
        {
            $query .= " AND (6371 * Acos(Cos(radians(users.latitude)) * Cos(radians(users.longitude)) * Cos(radians(?)) * Cos(radians(?)) +
                                         Cos(radians(users.latitude)) * Sin(radians(users.longitude)) * Cos(radians(?)) * Sin(radians(?)) +
                                         Sin(radians(users.latitude)) * Sin(radians(?)))) <= 20";
        }
        if ($localisation == 2)
        {
            $query .= " AND (6371 * Acos(Cos(radians(users.latitude)) * Cos(radians(users.longitude)) * Cos(radians(?)) * Cos(radians(?)) +
                                         Cos(radians(users.latitude)) * Sin(radians(users.longitude)) * Cos(radians(?)) * Sin(radians(?)) +
                                         Sin(radians(users.latitude)) * Sin(radians(?)))) <= 50";
        }
        if ($localisation == 3)
        {
            $query .= " AND (6371 * Acos(Cos(radians(users.latitude)) * Cos(radians(users.longitude)) * Cos(radians(?)) * Cos(radians(?)) +
                                         Cos(radians(users.latitude)) * Sin(radians(users.longitude)) * Cos(radians(?)) * Sin(radians(?)) +
                                         Sin(radians(users.latitude)) * Sin(radians(?)))) <= 100";
        }
        if ($localisation == 4)
        {
            $query .= " AND (6371 * Acos(Cos(radians(users.latitude)) * Cos(radians(users.longitude)) * Cos(radians(?)) * Cos(radians(?)) +
                                         Cos(radians(users.latitude)) * Sin(radians(users.longitude)) * Cos(radians(?)) * Sin(radians(?)) +
                                         Sin(radians(users.latitude)) * Sin(radians(?)))) <= 500";
        }

        // ------------------


        $req = $this->db->prepare($query);
        if ($localisation == 0) 
        {
            $req->execute(array($_SESSION['pseudo']));

        }
        else 
        {
            $req->execute(array($_SESSION['pseudo'], $_SESSION['latitude'], $_SESSION['longitude'], $_SESSION['latitude'], 
                                $_SESSION['longitude'], $_SESSION['latitude']));

        }
        $result = $req->fetchAll();
        
        return $result;
    }

    public function checkForgot($pseudo, $email)
    {
        $req_pseudo = $this->container->db->prepare('SELECT pseudo FROM users where pseudo = :pseudo');
        $req_pseudo->bindParam(':pseudo', $pseudo);
        $req_pseudo->execute();
        if ($req_pseudo->fetchColumn())
        {
            $req_email = $this->container->db->prepare('SELECT email FROM users where pseudo = :pseudo');
            $req_email->bindParam(':pseudo', $pseudo);
            $req_email->execute();
            if ($req_email->fetchColumn() == $email)
            {
                return 1;
            }
            else 
            {
                return 2;
            }
        }
        else 
        {
            return 3;
        }
    }

    public function saveNewPass($pseudo, $email, $hash)
    {
        $req_mdp = $this->container->db->prepare("UPDATE users SET password = ? WHERE pseudo = ? AND email = ?");
        $req_mdp->execute(array($hash, $pseudo, $email));
    }


    public function saveVisit($pseudo_visit)
    {   
        $query_id = $this->container->db->prepare('SELECT id FROM users where pseudo = :pseudo');
        $query_id->bindParam(':pseudo', $pseudo_visit);
        $query_id->execute();
        $visit_id = $query_id->fetchColumn();

        $query_id = $this->container->db->prepare('SELECT id FROM users where pseudo = :pseudo');
        $query_id->bindParam(':pseudo', $_SESSION['pseudo']);
        $query_id->execute();
        $user_id = $query_id->fetchColumn();

        $query_checkVisit = $this->container->db->prepare('SELECT * FROM visite where user_id = ? AND user_visit = ?');
        $query_checkVisit->execute(array($user_id, $visit_id));
        if ($query_checkVisit->fetchColumn())
        {
            return;
        }
        else 
        {    
            $query = $this->container->db->prepare("INSERT INTO visite (user_id, user_visit) VALUES (?, ?)");
            $query->execute(array($user_id, $visit_id));
        }
        
    }

    public function getNotif($pseudo, $id)
    {
        $query = $this->container->db->prepare("SELECT users.pseudo AS pseudo, Images.img_profil AS picture FROM (users, Images) INNER JOIN visite ON visite.user_id = users.id AND Images.id = visite.user_id WHERE visite.user_visit = ?");
        $query->execute(array($id));
        $result = $query->fetchAll();
        return $result;
    }

}





