<?php
class Menu_manager {
	private $_id,
			$_nom,
			$_lien,
			$_image,
			$_parent,
			$_ordre,
			$_estSupprimable,
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
		$this->hydrate($donnees);
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

	public function setLien($lien) {
		$this->_lien = $lien;
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

	public function setEstSupprimable($estSupprimable) {
		$this->_estSupprimable = $estSupprimable;
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

	public function getLien() {
		return $this->_lien;
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

	public function getEstSupprimable() {
		return $this->_estSupprimable;
	}

	public function getActif() {
		return $this->_actif;
	}

} ?>