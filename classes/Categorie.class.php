<?php
class Categorie {
	private $_id,
			$_categorie,
			$_genre,
			$_numero,
			$_raccourci,
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
		$this->setCategorie('');
		$this->setGenre('');
		$this->setNumero(0);
		$this->setRaccourci('');
		$this->setOrdre(0);
		$this->setActif(0);
	}

	/*****************************************
	**					  					**
	** Retourne la categorie/niveau/genre  	**
	** 					   					**
	** Entrée : (Void)	   					**
	** Sortie : (String)					**
	**					 					**
	*****************************************/

	public function getCategorieAll() {
		$str = $this->_categorie;
		$str .= ($this->_genre != '') ? ' '.$this->_genre : '';
		$str .= ($this->_numero != 0) ? ' '.$this->_numero : '';
		return $str;
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

	public function setGenre($genre) {
		$this->_genre = $genre;
	}

	public function setNumero($numero) {
		$this->_numero = $numero;
	}

	public function setRaccourci($raccourci) {
		$this->_raccourci = $raccourci;
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

	public function getCategorie() {
		return $this->_categorie;
	}

	public function getGenre() {
		return $this->_genre;
	}

	public function getNumero() {
		return $this->_numero;
	}

	public function getRaccourci() {
		return $this->_raccourci;
	}

	public function getOrdre() {
		return $this->_ordre;
	}

	public function getActif() {
		return $this->_actif;
	}
	
} ?>