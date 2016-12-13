?php
class Match {
	private $_id,
			$_categorie,
			$_competition,
			$_adversaires,
			$_scores_dom,
			$_scores_ext,
			$_date,
			$_heure,
			$_lieu,
			$_gymnase,
			$_journee,
			$_tour,
			$_table,
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

	public function setPhotos($photos) {
		$this->_photos = $photos;
	}

	public function setVideos($videos) {
		$this->_videos = $videos;
	}

	public function setAuteur($auteur) {
		$this->_auteur = $auteur;
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

	public function setImage($image) {
		$this->_image = $image;
	}

	public function setSlider($slider) {
		$this->_slider = $slider;
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

	public function getPhotos() {
		return $this->_photos;
	}

	public function getVideos() {
		return $this->_videos;
	}

	public function getAuteur() {
		return $this->_auteur;
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

	public function getImage() {
		return $this->_image;
	}

	public function getSlider() {
		return $this->_slider;
	}

	public function getPublie() {
		return $this->_publie;
	}
} ?>