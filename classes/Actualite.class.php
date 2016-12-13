<?php
class Actualite {
	private $_id,
			$_titre,
			$_sous_titre,
			$_contenu,
			$_theme,
			$_tags,
			$_id_auteur_crea,
			$_id_auteur_modif,
			$_id_auteur_publi,
			$_date_creation,
			$_heure_creation,
			$_date_modification,
			$_heure_modification,
			$_date_publication,
			$_heure_publication,
			$_image,
			$_slider,
			$_importance,
			$_publie;


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
		$this->setSous_titre('');
		$this->setTitre('');
		$this->setContenu('');
		$this->setTheme('');
		$this->setTags('');
		$this->setId_auteur_crea(0);
		$this->setId_auteur_modif(0);
		$this->setId_auteur_publi(0);
		$this->setDate_creation(0);
		$this->setHeure_creation(0);
		$this->setDate_modification(0);
		$this->setHeure_modification(0);
		$this->setDate_publication(0);
		$this->setHeure_publication(0);
		$this->setImage('');
		$this->setSlider(0);
		$this->setImportance(0);
		$this->setPublie(0);
	}

	/***************************************
	**								      **
	**   Affichage de la date simple 	  **
	** 					 				  **
	** Entrée : (Void)	   				  **
	** Sortie : (String)	 			  **
	**					 				  **
	***************************************/

	public function dateSimple() {
		return $this->remplace_date($this->getDate_creation());
	}
	
	/***************************************
	**								      **
	**   Affichage de l'heure simple      **
	** 					 				  **
	** Entrée : (Void)	   				  **
	** Sortie : (String)	 			  **
	**					 				  **
	***************************************/

	public function heureSimple() {
		return $this->remplace_heure($this->getHeure_creation());
	}

	/***************************************
	**								      **
	**   Affichage de la date type news   **
	** 					 				  **
	** Entrée : (Void)	   				  **
	** Sortie : (String)	 			  **
	**					 				  **
	***************************************/

	public function dateTypeNews() {
		$today = date('Ymd');
		
		if($this->getDate_creation() == $today)
			return $this->remplace_heure($this->getHeure_creation());
		else
			return $this->remplace_date($this->getDate_creation());
	}

	/*************************************************
	**												**
	** Remplace la date en chiffre par une String 	**
	** 												**
	** Entrée : (Int)								**
	** Sortie : (String)							**
	**												**
	*************************************************/
	
	public function remplace_date($date) {
		$mois = substr($date, 4, 2);
		$jour = substr($date, 6, 2);
		
		$newDate = $jour.'/'.$mois;
		
		return $newDate;
	}
	
	/*************************
	**						**
	** Retourne l'année		**
	** 						**
	** Entrée : (Void)		**
	** Sortie : (Int)		**
	**						**
	*************************/
	
	public function getAnneeC() {
		return substr($this->getDate_creation(), 0, 4);
	}

	/*************************
	**						**
	** Retourne le mois		**
	** 						**
	** Entrée : (Void)		**
	** Sortie : (Int)		**
	**						**
	*************************/
	
	public function getMoisC() {
		return substr($this->getDate_creation(), 4, 2);
	}

	/*************************
	**						**
	** Retourne le jour		**
	** 						**
	** Entrée : (Void)		**
	** Sortie : (Int)		**
	**						**
	*************************/
	
	public function getJourC() {
		return substr($this->getDate_creation(), 6, 2);
	}
	
	/*************************
	**						**
	** Retourne l'année		**
	** 						**
	** Entrée : (Void)		**
	** Sortie : (Int)		**
	**						**
	*************************/
	
	public function getAnneeP() {
		return substr($this->getDate_publication(), 0, 4);
	}

	/*************************
	**						**
	** Retourne le mois		**
	** 						**
	** Entrée : (Void)		**
	** Sortie : (Int)		**
	**						**
	*************************/
	
	public function getMoisP() {
		return substr($this->getDate_publication(), 4, 2);
	}

	/*************************
	**						**
	** Retourne le jour		**
	** 						**
	** Entrée : (Void)		**
	** Sortie : (Int)		**
	**						**
	*************************/
	
	public function getJourP() {
		return substr($this->getDate_publication(), 6, 2);
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

	/*************************************************
	**												**
	** Récupére l'heure et la minute 			 	**
	** 												**
	** Entrée : (Int)								**
	** Sortie : (Array)							**
	**												**
	*************************************************/
	
	public function recupere_h_m($heure) {
		$tab = array();
		$longueur = strlen($heure);
		switch($longueur) {
			
			case 1:
				$tab[1] = intval(substr($heure, 0, 1));
				$tab[0] = 0;
				break;
			case 2:
				$minute = intval(substr($heure, 0, 2));
				$newHeure = 0;
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

	public function setTitre($titre) {
		$this->_titre = $titre;
	}

	public function setSous_titre($sous_titre) {
		$this->_sous_titre = $sous_titre;
	}

	public function setContenu($contenu) {
		$this->_contenu = $contenu;
	}

	public function setTheme($theme) {
		$this->_theme = $theme;
	}

	public function setTags($tags) {
		$this->_tags = $tags;
	}

	public function setId_auteur_crea($id_auteur_crea) {
		$this->_id_auteur_crea = $id_auteur_crea;
	}

	public function setId_auteur_modif($id_auteur_modif) {
		$this->_id_auteur_modif = $id_auteur_modif;
	}

	public function setId_auteur_publi($id_auteur_publi) {
		$this->_id_auteur_publi = $id_auteur_publi;
	}

	public function setDate_creation($date_creation) {
		$this->_date_creation = $date_creation;
	}

	public function setHeure_creation($heure_creation) {
		$this->_heure_creation = $heure_creation;
	}

	public function setDate_modification($date_modification) {
		$this->_date_modification = $date_modification;
	}

	public function setHeure_modification($heure_modification) {
		$this->_heure_modification = $heure_modification;
	}

	public function setDate_publication($date_publication) {
		$this->_date_publication = $date_publication;
	}

	public function setHeure_publication($heure_publication) {
		$this->_heure_publication = $heure_publication;
	}

	public function setImage($image) {
		$this->_image = $image;
	}

	public function setSlider($slider) {
		$this->_slider = $slider;
	}

	public function setImportance($importance) {
		$this->_importance = $importance;
	}

	public function setPublie($publie) {
		$this->_publie = $publie;
	}

	/****************
	**			   **
	** Les getters **
	**			   **
	****************/

	public function getId() {
		return $this->_id;
	}

	public function getTitre() {
		return $this->_titre;
	}

	public function getSous_titre() {
		return $this->_sous_titre;
	}

	public function getContenu() {
		return $this->_contenu;
	}

	public function getTheme() {
		return $this->_theme;
	}

	public function getTags() {
		return $this->_tags;
	}

	public function getId_auteur_crea() {
		return $this->_id_auteur_crea;
	}

	public function getId_auteur_modif() {
		return $this->_id_auteur_modif;
	}

	public function getId_auteur_publi() {
		return $this->_id_auteur_publi;
	}

	public function getDate_creation() {
		return $this->_date_creation;
	}

	public function getHeure_creation() {
		return $this->_heure_creation;
	}

	public function getDate_modification() {
		return $this->_date_modification;
	}

	public function getHeure_modification() {
		return $this->_heure_modification;
	}

	public function getDate_publication() {
		return $this->_date_publication;
	}

	public function getHeure_publication() {
		return $this->_heure_publication;
	}

	public function getImage() {
		return $this->_image;
	}

	public function getSlider() {
		return $this->_slider;
	}

	public function getImportance() {
		return $this->_importance;
	}

	public function getPublie() {
		return $this->_publie;
	}
} ?>