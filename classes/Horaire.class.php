<?php
class Horaire {
	private $_id,
			$_categorie,
			$_jour,
			$_heure_debut,
			$_heure_fin,
			$_gymnase,
			$_annee;

	/*********************
	**					**
	** Constructeur		**
	** 					**
	** Entrée : (Array) **
	** Sortie : (Bool)  **
	**					**
	*********************/

	public function __construct(array $donnees) {
		if(!empty($donnees))
			$this->hydrate($donnees);
		else
			$this->init();
	}

	/************************
	**					   **
	** Hydrate les données **
	** 					   **
	** Entrée : (Array)	   **
	** Sortie : (Bool)	   **
	**					   **
	************************/

	public function hydrate(array $donnees) {
		foreach ($donnees as $key => $value) {
			// On récupère le nom du setter correspondant à l'attribut.
			$method = 'set'.ucfirst($key);

			// Si le setter correspondant existe.
			if (method_exists($this, $method)) {
				// On appelle le setter.
				$this->$method($value);
			}
		}
	}

	/************************
	**					   **
	** Initie les données  **
	** 					   **
	** Entrée : (Array)	   **
	** Sortie : (Bool)	   **
	**					   **
	************************/

	public function init() {
		$this->setId(0);
		$this->setCategorie(0);
		$this->setJour(0);
		$this->setHeure_debut(0);
		$this->setHeure_fin(0);
		$this->setGymnase(0);
		$this->setAnnee(0);
	}
	
	/*************************************************
	**												**
	** Remplace l'heure en chiffre par une String 	**
	** 												**
	** Entrée : (Int)								**
	** Sortie : (String)							**
	**												**
	*************************************************/
	
	public function remplace_heure($heure) {
		$longueur = strlen($heure);
		switch($longueur) {
			
			case 1:
				$minute = substr($heure, 0, 1);
				$newHeure = '00h0'.$minute;
				break;
			case 2:
				$minute = substr($heure, 0, 2);
				$newHeure = '00h'.$minute;
				break;
			case 3:
				$heureH = substr($heure, 0, 1);
				$minute = substr($heure, -2);
				if($minute=='00')
					$minute = '';
				$newHeure = $heureH.'h'.$minute;
				break;
			case 4:
				$heureH = substr($heure, 0, 2);
				$minute = substr($heure, -2);
				if($minute=='00')
					$minute = '';
				$newHeure = $heureH.'h'.$minute;
				break;
			case 0:
			default:
				$minute = substr($heure, -2);
				$heureH = substr($heure, 0, 2);
				if($minute=='00')
					$minute = '';
				$newHeure = $heureH.'h'.$minute;
				break;
		}
		return $newHeure;
	}

	/****************
	**			   **
	** Les setters **
	**			   **
	****************/

	public function setId($id) {
		$this->_id = $id;
	}
	public function setCategorie($categorie) {
		$this->_categorie = $categorie;
	}
	public function setJour($jour) {
		$this->_jour = $jour;
	}
	public function setHeure_debut($heure_debut) {
		$this->_heure_debut = $heure_debut;
	}
	public function setHeure_fin($heure_fin) {
		$this->_heure_fin = $heure_fin;
	}
	public function setGymnase($gymnase) {
		$this->_gymnase = $gymnase;
	}
	public function setAnnee($annee) {
		$this->_annee = $annee;
	}

	/****************
	**			   **
	** Les getters **
	**			   **
	****************/

	public function getId() {
		return $this->_id;
	}
	public function getCategorie() {
		return $this->_categorie;
	}
	public function getJour() {
		return $this->_jour;
	}
	public function getHeure_debut() {
		return $this->_heure_debut;
	}
	public function getHeure_fin() {
		return $this->_heure_fin;
	}
	public function getGymnase() {
		return $this->_gymnase;
	}
	public function getAnnee() {
		return $this->_annee;
	}
} ?>