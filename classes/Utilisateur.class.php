<?php
class Utilisateur {
	private $_id,
			$_nom,
			$_prenom,
			$_mail,
			$_mot_de_passe,
			$_rang,
			$_tel_port,
			$_src_photo,
			$_num_licence,
			$_liste_equipes_favorites,
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

	/****************************************************
	**												   **
	** Test si l'utilisateur à accès ou non au contenu **
	** 												   **
	** Entrée : (Int) Rang 							   **
	** Sortie : (Bool)								   **							
	**												   **
	****************************************************/
	
	public function accesAutorise() {
		$rangAutorise = array(1, 2);

		if(in_array($this->_rang, $rangAutorise))
			return true;
		else
			return false;
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

	public function setPrenom($prenom) {
		$this->_prenom = $prenom;
	}

	public function setMail($mail) {
		$this->_mail = $mail;
	}

	public function setMot_de_passe($mot_de_passe) {
		$this->_mot_de_passe = $mot_de_passe;
	}

	public function setRang($rang) {
		$this->_rang = $rang;
	}

	public function setTel_port($tel_port) {
		$this->_tel_port = $tel_port;
	}

	public function setSrc_photo($src_photo) {
		$this->_src_photo = $src_photo;
	}

	public function setNum_licence($num_licence) {
		$this->_num_licence = $num_licence;
	}
    
	public function setListe_equipes_favorites($liste_equipes_favorites) {
		$this->_liste_equipes_favorites = $liste_equipes_favorites;
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

	public function getPrenom() {
		return $this->_prenom;
	}

	public function getMail() {
		return $this->_mail;
	}

	public function getMot_de_passe() {
		return $this->_mot_de_passe;
	}

	public function getRang() {
		return $this->_rang;
	}

	public function getTel_port() {
		return $this->_tel_port;
	}

	public function getSrc_photo() {
		return $this->_src_photo;
	}
    
	public function getNum_licence() {
		return $this->_num_licence;
	}
    
	public function getListe_equipes_favorites() {
		return $this->_liste_equipes_favorites;
	}

	public function getActif() {
		return $this->_actif;
	}
} ?>