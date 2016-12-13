<?php
class Tarif {
	private $_id,
			$_date_naissance,
			$_categorie,
			$_genre,
			$_prix_old,
			$_prix_nv,
			$_condition_old,
			$_condition_nv,
			$_annee,
			$_actif;


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
		$this->setDate_naissance('');
		$this->setCategorie('');
		$this->setGenre(0);
		$this->setPrix_old(0);
		$this->setPrix_nv(0);
		$this->setCondition_old(0);
		$this->setCondition_nv(0);
		$this->setAnnee(0);
		$this->setActif(0);
	}

	/****************
	**			   **
	** Les setters **
	**			   **
	****************/

	public function setId($id) {
		$this->_id = intval($id);
	}

	public function setDate_naissance($date_naissance) {
		$this->_date_naissance = strval($date_naissance);
	}

	public function setCategorie($categorie) {
		$this->_categorie = strval($categorie);
	}

	public function setGenre($genre) {
		$this->_genre = intval($genre);
	}

	public function setPrix_old($prix_old) {
		$this->_prix_old = intval($prix_old);
	}

	public function setPrix_nv($prix_nv) {
		$this->_prix_nv = intval($prix_nv);
	}

	public function setCondition_old($condition_old) {
		$this->_condition_old = intval($condition_old);
	}

	public function setCondition_nv($condition_nv) {
		$this->_condition_nv = intval($condition_nv);
	}

	public function setAnnee($annee) {
		$this->_annee = intval($annee);
	}

	public function setActif($actif) {
		$this->_actif = intval($actif);
	}

	/****************
	**			   **
	** Les getters **
	**			   **
	****************/

	public function getId() {
		return $this->_id;
	}

	public function getDate_naissance() {
		return $this->_date_naissance;
	}

	public function getCategorie() {
		return $this->_categorie;
	}

	public function getGenre() {
		return $this->_genre;
	}

	public function getPrix_old() {
		return $this->_prix_old;
	}

	public function getPrix_nv() {
		return $this->_prix_nv;
	}

	public function getCondition_old() {
		return $this->_condition_old;
	}

	public function getCondition_nv() {
		return $this->_condition_nv;
	}

	public function getAnnee() {
		return $this->_annee;
	}

	public function getActif() {
		return $this->_actif;
	}
	
} ?>