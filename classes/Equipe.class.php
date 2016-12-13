<?php
class Equipe {
	private $_id,
			$_categorie,
			$_niveau,
			$_championnat,
			$_annee,
			$_entraineurs,
			$_entrainements,
			$_id_photo_equipe,
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
		$this->setCategorie(0);
		$this->setNiveau(0);
		$this->setChampionnat(0);
		$this->setAnnee(0);
		$this->setEntraineurs('');
		$this->setEntrainements('');
		$this->setId_photo_equipe(0);
		$this->setActif(0);
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
	public function setNiveau($niveau) {
		$this->_niveau = $niveau;
	}
	public function setChampionnat($championnat) {
		$this->_championnat = $championnat;
	}
	public function setAnnee($annee) {
		$this->_annee = $annee;
	}
	public function setEntraineurs($entraineurs) {
		$this->_entraineurs = $entraineurs;
	}
	public function setEntrainements($entrainements) {
		$this->_entrainements = $entrainements;
	}
	public function setId_photo_equipe($id_photo_equipe) {
		$this->_id_photo_equipe = $id_photo_equipe;
	}
	public function setActif($actif) {
		$this->_actif = $actif;
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
	public function getNiveau() {
		return $this->_niveau;
	}
	public function getChampionnat() {
		return $this->_championnat;
	}
	public function getAnnee() {
		return $this->_annee;
	}
	public function getEntraineurs() {
		return $this->_entraineurs;
	}
	public function getEntrainements() {
		return $this->_entrainements;
	}
	public function getId_photo_equipe() {
		return $this->_id_photo_equipe;
	}
	public function getActif() {
		return $this->_actif;
	}
} ?>