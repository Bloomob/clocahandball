<?php
class Menu {
	private $_id,
			$_nom,
			$_url,
			$_image,
			$_parent,
			$_ordre,
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
		$this->setNom('');
		$this->setUrl('');
		$this->setImage('');
		$this->setParent(0);
		$this->setOrdre(0);
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

	public function setNom($nom) {
		$this->_nom = $nom;
	}

	public function setUrl($url) {
		$this->_url = $url;
	}

	public function setImage($image) {
		$this->_image = $image;
	}

	public function setParent($parent) {
		$this->_parent = $parent;
	}

	public function setOrdre($ordre) {
		$this->_ordre = $ordre;
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

	public function getNom() {
		return $this->_nom;
	}

	public function getUrl() {
		return $this->_url;
	}

	public function getImage() {
		return $this->_image;
	}

	public function getParent() {
		return $this->_parent;
	}

	public function getOrdre() {
		return $this->_ordre;
	}

	public function getActif() {
		return $this->_actif;
	}

} ?>