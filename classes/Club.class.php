<?php
class Club {
	private $_id,
			$_nom,
			$_raccourci,
			$_numero,
			$_ville,
			$_code_postal,
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
		$this->setRaccourci('');
		$this->setNumero(0);
		$this->setVille('');
		$this->setCode_postal(0);
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

	public function setRaccourci($raccourci) {
		$this->_raccourci = $raccourci;
	}

	public function setNumero($numero) {
		$this->_numero = $numero;
	}

	public function setVille($ville) {
		$this->_ville = $ville;
	}

	public function setCode_postal($code_postal) {
		$this->_code_postal = $code_postal;
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
	public function getRaccourci() {
		return $this->_raccourci;
	}

	public function getNumero() {
		return $this->_numero;
	}

	public function getVille() {
		return $this->_ville;
	}

	public function getCode_postal() {
		return $this->_code_postal;
	}

	public function getActif() {
		return $this->_actif;
	}

} ?>