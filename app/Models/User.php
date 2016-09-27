<?php

	namespace App\Models;

	class User 
	{

		protected $bdd; // Instance de PDO

		public function __construct($db)
		{
			$this->bdd = $db;
		}
	}