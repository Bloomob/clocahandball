<?php
class Fonction {
	private $_id,
			$_type,
			$_role,
			$_id_utilisateur,
			$_annee_debut,
			$_annee_fin;


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
		$this->setType(0);
		$this->setRole(0);
		$this->setId_utilisateur(0);
		$this->setAnnee_debut(0);
		$this->setAnnee_fin(0);
	}

	/****************
	**			   **
	** Les setters **
	**			   **
	****************/

	public function setId($id) {
		$this->_id = $id;
	}

	public function setType($type) {
		$this->_type = $type;
	}

	public function setRole($role) {
		$this->_role = $role;
	}

	public function setId_utilisateur($id_utilisateur) {
		$this->_id_utilisateur = $id_utilisateur;
	}

	public function setAnnee_debut($annee_debut) {
		$this->_annee_debut = $annee_debut;
	}

	public function setAnnee_fin($annee_fin) {
		$this->_annee_fin = $annee_fin;
	}

	/****************
	**			   **
	** Les getters **
	**			   **
	****************/

	public function getId() {
		return $this->_id;
	}

	public function getType() {
		return $this->_type;
	}

	public function getRole() {
		return $this->_role;
	}

	public function getId_utilisateur() {
		return $this->_id_utilisateur;
	}

	public function getAnnee_debut() {
		return $this->_annee_debut;
	}

	public function getAnnee_fin() {
		return $this->_annee_fin;
	}
} ?>