<?php
class JoueurManager {
	
	private $_db;


	/********************************
	**							   **
	**    	   Constructeur   	   **
	** 							   **
	** Entrée : (Joueur)		   **
	** Sortie : (Void)			   **
	**							   **
	********************************/

	public function __construct(PDO $db) {
		$this->setDb($db);
	}

	/********************************
	**							   **
	**    Ajout d'un Joueur 	   **
	** 							   **
	** Entrée : (Joueur)	 	   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Joueur $joueur) {
		$req = $this->_db->prepare('
			INSERT INTO 
				joueurs 
			SET 
				id_utilisateur = :id_utilisateur,
				date_naissance = :date_naissance,
				poste = :poste,
				annee_arrivee = :annee_arrivee,
				annee_depart = :annee_depart,
				numero = :numero,
				actif = :actif
		');
		$req->bindValue(':id_utilisateur', $joueur->getId_utilisateur(), PDO::PARAM_INT);
		$req->bindValue(':date_naissance', $joueur->getDate_naissance(), PDO::PARAM_INT);
		$req->bindValue(':poste', $joueur->getPoste(), PDO::PARAM_INT);
		$req->bindValue(':annee_arrivee', $joueur->getAnnee_arrive(), PDO::PARAM_INT);
		$req->bindValue(':annee_depart', $joueur->getAnnee_depart(), PDO::PARAM_INT);
		$req->bindValue(':numero', $joueur->getNumero(), PDO::PARAM_INT);
		$req->bindValue(':actif', $joueur->getActif(), PDO::PARAM_INT);

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
	** Modification d'un joueur 	 **
	** 							     **
	** Entrée : (Joueur)	 	     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function modifier(Joueur $joueur) {
		$req = $this->_db->prepare('
			UPDATE
				actualites 
			SET 
				id_utilisateur = :id_utilisateur,
				date_naissance = :date_naissance,
				poste = :poste,
				annee_arrivee = :annee_arrivee,
				annee_depart = :annee_depart,
				numero = :numero,
				actif = :actif
			WHERE
				id = :id
		');
		$req->bindValue(':id_utilisateur', $joueur->getId_utilisateur(), PDO::PARAM_INT);
		$req->bindValue(':date_naissance', $joueur->getDate_naissance(), PDO::PARAM_INT);
		$req->bindValue(':poste', $joueur->getPoste(), PDO::PARAM_INT);
		$req->bindValue(':annee_arrivee', $joueur->getAnnee_arrive(), PDO::PARAM_INT);
		$req->bindValue(':annee_depart', $joueur->getAnnee_depart(), PDO::PARAM_INT);
		$req->bindValue(':numero', $joueur->getNumero(), PDO::PARAM_INT);
		$req->bindValue(':actif', $joueur->getActif(), PDO::PARAM_INT);
		
		return $req->execute();
	}

	/*********************************
	**							    **
	** Suppression d'un joueur 		**
	** 							    **
	** Entrée : (Joueur)		    **
	** Sortie : (Void)			    **
	**							    **
	*********************************/

	public function supprimer(Joueur $joueur) {
		return $this->_db->exec('DELETE FROM joueurs WHERE id = '.$joueur->getId());
	}


	/**********************************
	**							     **
	**   Existance d'un joueur 		 **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Bool)   		     **
	**							     **
	**********************************/

	public function existeId($id) {
		$q = 'SELECT * FROM joueurs WHERE id = '. $id;
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
	** 	  Retourne un joueur 	     **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourne($options = array()) {
		$q = 'SELECT * FROM joueurs';

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
 			return new Joueur($donnees);
		}
		else {
			return new Joueur(array());
		}
	}
	/********************************************
	**							     		   **
	** 	  Retourne un joueur par son ID  	   **
	** 							     		   **
	** Entrée : (Int)	  		     		   **
	** Sortie : (Array) || (Bool)    		   **
	**							     		   **
	********************************************/

	public function retourneById($id) {
		$q = 'SELECT * FROM joueurs WHERE id = '.$id.' LIMIT 0,1';

		$req = $this->_db->prepare($q);
		$req->execute();
		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
 			return new Joueur($donnees);
		}
		else {
			return new Joueur(array());
		}
	}

	/**********************************
	**							     **
	** 	 Retourne les joueurs 	     **
	** 							     **
	** Entrée : (Void)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$joueurs = array();

		$q = 'SELECT * FROM joueurs';

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
				$joueurs[] = new Joueur($donnees);
			}
	 		return $joueurs;
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