<?php
class FonctionManager {
	
	private $_db;


	/********************************
	**							   **
	**    	   Constructeur   	   **
	** 							   **
	** Entrée : (Fonction)	       **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function __construct(PDO $db) {
		$this->setDb($db);
	}

	/********************************
	**							   **
	**    Ajout d'un fonction	   **
	** 							   **
	** Entrée : (Fonction)		   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Fonction $fonction) {
		$req = $this->_db->prepare('
			INSERT INTO 
				fonctions 
			SET 
				type = :type,
				role = :role,
				id_utilisateur = :id_utilisateur,
				annee_debut = :annee_debut,
				annee_fin = :annee_fin
		');
		$req->bindValue(':type', $fonction->getType(), PDO::PARAM_INT);
		$req->bindValue(':role', $fonction->getRole(), PDO::PARAM_INT);
		$req->bindValue(':id_utilisateur', $fonction->getId_utilisateur(), PDO::PARAM_INT);
		$req->bindValue(':annee_debut', $fonction->getAnnee_debut(), PDO::PARAM_INT);
		$req->bindValue(':annee_fin', $fonction->getAnnee_fin(), PDO::PARAM_INT);

		return $req->execute();
	}

	/**********************************
	**							     **
	** Modification d'un fonction	 **
	** 							     **
	** Entrée : (Fonction)		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function modifier(Fonction $fonction) {
		$req = $this->_db->prepare('
			UPDATE
				fonctions 
			SET 
				type = :type,
				role = :role,
				id_utilisateur = :id_utilisateur,
				annee_debut = :annee_debut,
				annee_fin = :annee_fin
			WHERE
				id = :id
		');
		$req->bindValue(':id', $fonction->getId(), PDO::PARAM_INT);
		$req->bindValue(':type', $fonction->getType(), PDO::PARAM_INT);
		$req->bindValue(':role', $fonction->getRole(), PDO::PARAM_INT);
		$req->bindValue(':id_utilisateur', $fonction->getId_utilisateur(), PDO::PARAM_INT);
		$req->bindValue(':annee_debut', $fonction->getAnnee_debut(), PDO::PARAM_INT);
		$req->bindValue(':annee_fin', $fonction->getAnnee_fin(), PDO::PARAM_INT);
		
		return $req->execute();
	}

	/*********************************
	**							    **
	** Suppression d'un fonction	**
	** 							    **
	** Entrée : (Fonction)		    **
	** Sortie : (Array) || (Bool)   **
	**							    **
	*********************************/

	public function supprimer(Fonction $fonction) {
		return $this->_db->exec('DELETE FROM fonctions WHERE id = '.$fonction->getId());
	}

	/**********************************
	**							     **
	** 	  Retourne un fonction 	     **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneById($id) {
		$q = 'SELECT * FROM fonctions WHERE id = '.$id. ' LIMIT 0,1';

		$req = $this->_db->prepare($q);
		$req->execute();
 		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
 			return new Fonction($donnees);
		}
		else {
			return new Fonction(array());
		}
	}

	/**********************************
	**							     **
	** 	  Retourne un fonction 	     **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourne($options = array()) {
		$q = 'SELECT * FROM fonctions';

		extract($options);
		if(isset($where))
			$q .= ' WHERE '.$where;
		if(isset($orderby))
			$q .= ' ORDER BY '.$orderby;
		if(isset($limit))
			$q .= ' LIMIT '.$limit;

		$req = $this->_db->prepare($q);
		$req->execute();
 		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
 			return new Fonction($donnees);
		}
		else {
			return new Fonction(array());
		}
	}

	/**********************************
	**							     **
	** 	 Retourne les fonctions		 **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$fonctions = array();
		$q = 'SELECT * FROM fonctions';

		extract($options);
		if(isset($where))
			$q .= ' WHERE '.$where;
		if(isset($orderby))
			$q .= ' ORDER BY '.$orderby;
		if(isset($limit))
			$q .= ' LIMIT '.$limit;

		$req = $this->_db->prepare($q);
		$req->execute();
		while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
			$fonctions[] = new Fonction($donnees);
		}
 		return $fonctions;
	}

	/**********************************
	**							     **
	** Compte le nombre de fonctions **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function compte() {
		$req = $this->_db->prepare('SELECT id FROM fonctions');
		$req->execute();
 		return $req->rowCount();
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