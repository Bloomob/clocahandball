<?php
class Joueur {
	private $_id,
			$_id_utilisateur,
			$_date_naissance,
			$_poste,
			$_annee_arrivee,
			$_annee_depart,
			$_numero,
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
		$this->setId_utilisateur(0);
		$this->setDate_naissance(0);
		$this->setPoste(0);
		$this->setAnnee_arrivee(0);
		$this->setAnnee_depart(0);
		$this->setNumero(0);
		$this->setActif(0);
	}


	/*************************************************
	**												**
	** Remplace la date en chiffre par une String 	**
	** 												**
	** Entrée : (Void)								**
	** Sortie : (String)							**
	**												**
	*************************************************/
	
	public function date() {
		$annee = substr($this->getDate_naissance(), 0, 4);
		$mois = substr($this->getDate_naissance(), 4, 2);
		$jour = substr($this->getDate_naissance(), 6, 2);
		
		$newDate = $jour.'/'.$mois.'/'.$annee;
		
		return $newDate;
	}


	/****************
	**			   **
	** Les setters **
	**			   **
	****************/

	public function setId($id) {
		$this->_id = $id;
	}

	public function setId_utilisateur($id_utilisateur) {
		$this->_id_utilisateur = $id_utilisateur;
	}

	public function setDate_naissance($date_naissance) {
		$this->_date_naissance = $date_naissance;
	}

	public function setPoste($poste) {
		$this->_poste = $poste;
	}

	public function setAnnee_arrivee($annee_arrivee) {
		$this->_annee_arrivee = $annee_arrivee;
	}
	
	public function setAnnee_depart($annee_depart) {
		$this->_annee_depart = $annee_depart;
	}

	public function setNumero($numero) {
		$this->_numero = $numero;
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

	public function getId_utilisateur() {
		return $this->_id_utilisateur;
	}

	public function getDate_naissance() {
		return $this->_date_naissance;
	}

	public function getPoste() {
		return $this->_poste;
	}

	public function getAnnee_arrivee() {
		return $this->_annee_arrivee;
	}

	public function getAnnee_depart() {
		return $this->_annee_depart;
	}

	public function getNumero() {
		return $this->_numero;
	}

	public function getActif() {
		return $this->_actif;
	}
} ?>