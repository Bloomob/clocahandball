<?php
class ActualiteManager {
	
	private $_db;


	/********************************
	**							   **
	**    	   Constructeur   	   **
	** 							   **
	** Entrée : (Actualite)		   **
	** Sortie : (Void)			   **
	**							   **
	********************************/

	public function __construct(PDO $db) {
		$this->setDb($db);
	}

	/********************************
	**							   **
	**    Ajout d'un utilisateur   **
	** 							   **
	** Entrée : (Actualite)	 	   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Actualite $actu) {
		$req = $this->_db->prepare('
			INSERT INTO 
				actualites 
			SET 
				titre = :titre,
				sous_titre = :sous_titre,
				contenu = :contenu,
				theme = :theme,
				tags = :tags,
				id_auteur_crea = :id_auteur_crea,
				id_auteur_modif = :id_auteur_modif,
				id_auteur_publi = :id_auteur_publi,
				date_creation = :date_creation,
				heure_creation = :heure_creation,
				date_modification = :date_modification,
				heure_modification = :heure_modification,
				date_publication = :date_publication,
				heure_publication = :heure_publication,
				image = :image,
				slider = :slider,
				importance = :importance,
				publie = :publie
		');
		$req->bindValue(':titre', $actu->getTitre());
		$req->bindValue(':sous_titre', $actu->getSous_titre());
		$req->bindValue(':contenu', $actu->getContenu());
		$req->bindValue(':theme', $actu->getTheme());
		$req->bindValue(':tags', $actu->getTags());
		$req->bindValue(':id_auteur_crea', $actu->getId_auteur_crea(), PDO::PARAM_INT);
		$req->bindValue(':id_auteur_modif', $actu->getId_auteur_modif(), PDO::PARAM_INT);
		$req->bindValue(':id_auteur_publi', $actu->getId_auteur_publi(), PDO::PARAM_INT);
		$req->bindValue(':date_creation', $actu->getDate_creation(), PDO::PARAM_INT);
		$req->bindValue(':heure_creation', $actu->getHeure_creation(), PDO::PARAM_INT);
		$req->bindValue(':date_modification', $actu->getDate_modification(), PDO::PARAM_INT);
		$req->bindValue(':heure_modification', $actu->getHeure_modification(), PDO::PARAM_INT);
		$req->bindValue(':date_publication', $actu->getDate_publication(), PDO::PARAM_INT);
		$req->bindValue(':heure_publication', $actu->getHeure_publication(), PDO::PARAM_INT);
		$req->bindValue(':image', $actu->getImage());
		$req->bindValue(':slider', $actu->getSlider(), PDO::PARAM_INT);
		$req->bindValue(':importance', $actu->getImportance(), PDO::PARAM_INT);
		$req->bindValue(':publie', $actu->getPublie(), PDO::PARAM_INT);

		if($req->execute()){
			return $this->_db->lastInsertID();
		}
		else {
			var_dump($req->errorInfo());
			return;
		}
	}

	/**********************************
	**							     **
	** Modification d'une actualité  **
	** 							     **
	** Entrée : (Actualité)	 	     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function modifier(Actualite $actu) {
		$req = $this->_db->prepare('
			UPDATE
				actualites 
			SET 
				titre = :titre,
				sous_titre = :sous_titre,
				contenu = :contenu,
				theme = :theme,
				tags = :tags,
				id_auteur_crea = :id_auteur_crea,
				id_auteur_modif = :id_auteur_modif,
				id_auteur_publi = :id_auteur_publi,
				date_creation = :date_creation,
				heure_creation = :heure_creation,
				date_modification = :date_modification,
				heure_modification = :heure_modification,
				date_publication = :date_publication,
				heure_publication = :heure_publication,
				image = :image,
				slider = :slider,
				importance = :importance,
				publie = :publie
			WHERE
				id = :id
		');
		$req->bindValue(':id', $actu->getId());
		$req->bindValue(':titre', $actu->getTitre());
		$req->bindValue(':sous_titre', $actu->getSous_titre());
		$req->bindValue(':contenu', $actu->getContenu());
		$req->bindValue(':theme', $actu->getTheme());
		$req->bindValue(':tags', $actu->getTags());
		$req->bindValue(':id_auteur_crea', $actu->getId_auteur_crea(), PDO::PARAM_INT);
		$req->bindValue(':id_auteur_modif', $actu->getId_auteur_modif(), PDO::PARAM_INT);
		$req->bindValue(':id_auteur_publi', $actu->getId_auteur_publi(), PDO::PARAM_INT);
		$req->bindValue(':date_creation', $actu->getDate_creation(), PDO::PARAM_INT);
		$req->bindValue(':heure_creation', $actu->getHeure_creation(), PDO::PARAM_INT);
		$req->bindValue(':date_modification', $actu->getDate_modification(), PDO::PARAM_INT);
		$req->bindValue(':heure_modification', $actu->getHeure_modification(), PDO::PARAM_INT);
		$req->bindValue(':date_publication', $actu->getDate_publication(), PDO::PARAM_INT);
		$req->bindValue(':heure_publication', $actu->getHeure_publication(), PDO::PARAM_INT);
		$req->bindValue(':image', $actu->getImage());
		$req->bindValue(':slider', $actu->getSlider(), PDO::PARAM_INT);
		$req->bindValue(':importance', $actu->getImportance(), PDO::PARAM_INT);
		$req->bindValue(':publie', $actu->getPublie(), PDO::PARAM_INT);
		
		return $req->execute();
	}

	/*********************************
	**							    **
	** Suppression d'une actualité  **
	** 							    **
	** Entrée : (Actualité)		    **
	** Sortie : (Void)			    **
	**							    **
	*********************************/

	public function supprimer(Actualite $actu) {
		return $this->_db->exec('DELETE FROM actualites WHERE id = '.$actu->getId());
	}


	/**********************************
	**							     **
	**   Existance d'une actualité   **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Bool)   		     **
	**							     **
	**********************************/

	public function existeId($id) {
		$q = 'SELECT * FROM actualites WHERE id = '. $id;
		$req = $this->_db->prepare($q);
		$req->execute();
		if($req->rowCount()>0){
 			return true;
		}
		else {
			return false;
		}
	}

	/**********************************
	**							     **
	** 	  Retourne une actualité     **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourne($options = array()) {
		$q = 'SELECT * FROM actualites';

		extract($options);
		if(isset($where))
			$q .= ' WHERE '.$where;
		if(isset($orderby))
			$q .= ' ORDER BY '.$orderby;
		$q .= ' LIMIT 0, 1';

		$req = $this->_db->prepare($q);
		$req->execute();
		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
 			return new Actualite($donnees);
		}
		else {
			return new Actualite(array());
		}
	}
	/********************************************
	**							     		   **
	** 	  Retourne une actualité par son ID    **
	** 							     		   **
	** Entrée : (Int)	  		     		   **
	** Sortie : (Array) || (Bool)    		   **
	**							     		   **
	********************************************/

	public function retourneById($id) {
		$q = 'SELECT * FROM actualites WHERE id = '.$id.' LIMIT 0,1';

		$req = $this->_db->prepare($q);
		$req->execute();
		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
 			return new Actualite($donnees);
		}
		else {
			return new Actualite(array());
		}
	}

	/**********************************
	**							     **
	** 	 Retourne les actualités     **
	** 							     **
	** Entrée : (Void)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$actus = array();

		$q = 'SELECT * FROM actualites';

		extract($options);
		if(isset($where))
			$q .= ' WHERE '.$where;
		if(isset($orderby))
			$q .= ' ORDER BY '.$orderby;
		if(isset($limit))
			$q .= ' LIMIT '.$limit;

		$req = $this->_db->prepare($q);
		$req->execute();
		if($req->rowCount()>0):
			while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
				$actus[] = new Actualite($donnees);
			}
	 		return $actus;
	 	else:
	 		return false;
	 	endif;
	}

	/********************************
	**							   **
	**    Chargement de la BDD 	   **
	** 							   **
	** Entrée : (PDO)			   **
	** Sortie : (Void)			   **
	**							   **
	********************************/

	public function setDb(PDO $db) {
		$this->_db = $db;
	}
}?>