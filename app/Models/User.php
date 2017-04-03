<?php

namespace App\Models;

use App\Models\Model;


class User extends Model
{
	public function createUser($request)
	{
		$query = $this->container->db->prepare("INSERT INTO users (pseudo, nom, prenom, email, password, latitude, longitude, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
		$query->execute(array($request->getParam('pseudo'), $request->getParam('nom'), $request->getParam('prenom'), $request->getParam('email'), hash('whirlpool', $request->getParam('password')), $request->getParam('lat'), $request->getParam('lng')));
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


    public function getSomeProfil($age)
    {
        $query = "SELECT users.pseudo, users.nom, users.prenom, users.date_naissance, Images.img_profil 
                                    FROM users INNER JOIN Images 
                                    ON users.pseudo = Images.pseudo WHERE users.pseudo != ?";
        if ($age == 1) 
        { 
            $query .= " AND users.date_naissance != 'NULL' AND year(users.date_naissance) >= (year(current_timestamp) - 25) AND year(users.date_naissance) <= (year(current_timestamp) - 18)";   // ne fonctionne pas...
        }
        if ($age == 2) 
        { 
            $query .= " AND users.date_naissance != 'NULL' AND year(users.date_naissance) >= (year(current_timestamp) - 40) AND year(users.date_naissance) <= (year(current_timestamp) - 26)";   // ne fonctionne pas...
        }
        if ($age == 3) 
        { 
            $query .= " AND users.date_naissance != 'NULL' AND year(users.date_naissance) >= (year(current_timestamp) - 60) AND year(users.date_naissance) <= (year(current_timestamp) - 41)";   // ne fonctionne pas...
        }
        if ($age == 4) 
        { 
            $query .= " AND users.date_naissance != 'NULL' AND year(users.date_naissance) <= (year(current_timestamp) - 61)";   // ne fonctionne pas...
        }
        $req = $this->db->prepare($query);
        $req->execute(array($_SESSION['pseudo']));
        $result = $req->fetchAll();
        
        return $result;
    }

}




