<?php
class Match {
	private $_id,
			$_categorie,
			$_date,
			$_heure,
			$_competition,
			$_niveau,
			$_lieu,
			$_gymnase,
			$_adversaires,
			$_scores_dom,
			$_scores_ext,
			$_journee,
			$_tour,
			$_joue,
			$_arbitre,
			$_classement;


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
		$this->setDate(0);
		$this->setHeure(0);
		$this->setCompetition(0);
		$this->setNiveau(0);
		$this->setLieu(0);
		$this->setGymnase('');
		$this->setAdversaires('');
		$this->setScores_dom('');
		$this->setScores_ext('');
		$this->setJournee(0);
		$this->setTour('');
		$this->setJoue(0);
		$this->setArbitre('');
		$this->setClassement('');
	}

	/*************************************************
	**												**
	** Remplace la date en chiffre par une String 	**
	** 												**
	** Entrée : (Int)								**
	** Sortie : (String)							**
	**												**
	*************************************************/
	
	public function remplace_date($format) {
		// FORMAT = 1
		if($format == 1):
			$newDate = $this->getJour().'/'.$this->getMois();
		elseif($format == 2):
			$mois_de_lannee = array(6 => "Juillet", 7 => "Ao&ucirc;t", 8 => "Septembre", 9 => "Octobre", 10 => "Novembre", 11 => "D&eacute;cembre", 0 => "Janvier", 1 => "F&eacute;vrier", 2 => "Mars", 3 => "Avril", 4 => "Mai", 5 => "Juin");
			$newDate = $this->getJour().' '.substr($mois_de_lannee[$this->getMois()-1], 0, 3);
		endif;
		
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
	
	public function getAnnee() {
		return intval(substr($this->getDate(), 0, 4));
	}

	/*************************
	**						**
	** Retourne le mois		**
	** 						**
	** Entrée : (Void)		**
	** Sortie : (Int)		**
	**						**
	*************************/
	
	public function getMois() {
		return intval(substr($this->getDate(), 4, 2));
	}

	/*************************
	**						**
	** Retourne le jour		**
	** 						**
	** Entrée : (Void)		**
	** Sortie : (Int)		**
	**						**
	*************************/
	
	public function getJour() {
		return intval(substr($this->getDate(), 6, 2));
	}

	/*************************************************
	**												**
	** Remplace l'heure en chiffre par une String 	**
	** 												**
	** Entrée : (Int)								**
	** Sortie : (String)							**
	**												**
	*************************************************/
	
	public function remplace_heure() {
		$longueur = strlen($this->getHeure());
		switch($longueur) {
			
			case 1:
				$minute = substr($this->getHeure(), 0, 1);
				$newHeure = '00h0'.$minute;
				break;
			case 2:
				$minute = substr($this->getHeure(), 0, 2);
				$newHeure = '00h'.$minute;
				break;
			case 3:
				$heureH = substr($this->getHeure(), 0, 1);
				$minute = substr($this->getHeure(), -2);
				if($minute=='00')
					$minute = '';
				$newHeure = $heureH.'h'.$minute;
				break;
			case 4:
				$heureH = substr($this->getHeure(), 0, 2);
				$minute = substr($this->getHeure(), -2);
				if($minute=='00')
					$minute = '';
				$newHeure = $heureH.'h'.$minute;
				break;
			case 0:
			default:
				$minute = substr($this->getHeure(), -2);
				$heureH = substr($this->getHeure(), 0, 2);
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
		$this->_id = (int) $id;
	}

	public function setCategorie($categorie) {
		$this->_categorie = (int) $categorie;
	}

	public function setDate($date) {
		$this->_date = (int) $date;
	}

	public function setHeure($heure) {
		$this->_heure = (int) $heure;
	}

	public function setCompetition($competition) {
		$this->_competition = (int) $competition;
	}

	public function setNiveau($niveau) {
		$this->_niveau = (int) $niveau;
	}

	public function setLieu($lieu) {
		$this->_lieu = (int) $lieu;
	}

	public function setGymnase($gymnase) {
		$this->_gymnase = (string) $gymnase;
	}

	public function setAdversaires($adversaires) {
		$this->_adversaires = (string) $adversaires;
	}

	public function setScores_dom($scores_dom) {
		$this->_scores_dom = (string) $scores_dom;
	}

	public function setScores_ext($scores_ext) {
		$this->_scores_ext = (string) $scores_ext;
	}

	public function setJournee($journee) {
		$this->_journee = (int) $journee;
	}

	public function setTour($tour) {
		$this->_tour = (string) $tour;
	}

	public function setJoue($joue) {
		$this->_joue = (int) $joue;
	}

	public function setArbitre($arbitre) {
		$this->_arbitre = (string) $arbitre;
	}

	public function setClassement($classement) {
		$this->_classement = (string) $classement;
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

	public function getDate() {
		return $this->_date;
	}

	public function getHeure() {
		return $this->_heure;
	}

	public function getCompetition() {
		return $this->_competition;
	}
	
	public function getNiveau() {
		return $this->_niveau;
	}

	public function getLieu() {
		return $this->_lieu;
	}

	public function getGymnase() {
		return $this->_gymnase;
	}

	public function getAdversaires() {
		return $this->_adversaires;
	}

	public function getScores_dom() {
		return $this->_scores_dom;
	}

	public function getScores_ext() {
		return $this->_scores_ext;
	}

	public function getJournee() {
		return $this->_journee;
	}

	public function getTour() {
		return $this->_tour;
	}

	public function getJoue() {
		return $this->_joue;
	}

	public function getArbitre() {
		return $this->_arbitre;
	}

	public function getClassement() {
		return $this->_classement;
	}
} ?>