<?php
class UtilisateurManager {
	
	private $_db;


	/********************************
	**							   **
	**    	   Constructeur   	   **
	** 							   **
	** Entrée : (Utilisateur)	   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function __construct(PDO $db) {
		$this->setDb($db);
	}

	/********************************
	**							   **
	**    Ajout d'un utilisateur   **
	** 							   **
	** Entrée : (Utilisateur)	   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Utilisateur $util) {
		$req = $this->_db->prepare('
			INSERT INTO 
				utilisateurs 
			SET 
				nom = :nom,
				prenom = :prenom,
				mail = :mail,
				pseudo = :pseudo,
				mot_de_passe = :mot_de_passe,
				rang = :rang,
				tel_port = :tel_port,
				src_photo = :src_photo,
				actif = :actif
		');
		$req->bindValue(':nom', $util->getNom());
		$req->bindValue(':prenom', $util->getPrenom());
		$req->bindValue(':mail', $util->getMail());
		$req->bindValue(':pseudo', $util->getPseudo());
		$req->bindValue(':mot_de_passe', $util->getMot_de_passe());
		$req->bindValue(':rang', $util->getRang(), PDO::PARAM_INT);
		$req->bindValue(':tel_port', $util->getTel_port(), PDO::PARAM_INT);
		$req->bindValue(':src_photo', $util->getSrc_photo());
		$req->bindValue(':actif', $util->getActif(), PDO::PARAM_INT);

		$req->execute();
	}

	/**********************************
	**							     **
	** Modification d'un utilisateur **
	** 							     **
	** Entrée : (Utilisateur)	     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function modifier(Utilisateur $util) {
		$req = $this->_db->prepare('
			UPDATE
				utilisateurs 
			SET 
				nom = :nom,
				prenom = :prenom,
				mail = :mail,
				pseudo = :pseudo,
				mot_de_passe = :mot_de_passe,
				rang = :rang,
				tel_port = :tel_port,
				src_photo = :src_photo,
				actif = :actif
			WHERE
				id = :id
		');
		$req->bindValue(':id', $util->getId(), PDO::PARAM_INT);
		$req->bindValue(':nom', $util->getNom());
		$req->bindValue(':prenom', $util->getPrenom());
		$req->bindValue(':mail', $util->getMail());
		$req->bindValue(':pseudo', $util->getPseudo());
		$req->bindValue(':mot_de_passe', $util->getMot_de_passe());
		$req->bindValue(':rang', $util->getRang(), PDO::PARAM_INT);
		$req->bindValue(':tel_port', $util->getTel_port(), PDO::PARAM_INT);
		$req->bindValue(':src_photo', $util->getSrc_photo());
		$req->bindValue(':actif', $util->getActif(), PDO::PARAM_INT);
		
		$req->execute();
	}

	/*********************************
	**							    **
	** Suppression d'un utilisateur **
	** 							    **
	** Entrée : (Utilisateur)	    **
	** Sortie : (Array) || (Bool)   **
	**							    **
	*********************************/

	public function supprimer(Utilisateur $util) {
		$this->_db->exec('DELETE FROM utilisateurs WHERE id = '.$util->getId());
	}

	/**********************************
	**							     **
	** 	  Retourne un utilisateur    **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourne($options = array()) {
		$q = 'SELECT * FROM utilisateurs';

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
 			return new Utilisateur($donnees);
 		}
 		else{
 			return new Utilisateur(array());
 		}
	}/**********************************
	**							     **
	** 	  Retourne un utilisateur    **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneById($id) {
		$q = 'SELECT * FROM utilisateurs WHERE id = '.$id.' LIMIT 0, 1';

		$req = $this->_db->prepare($q);
		$req->execute();
		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
 			return new Utilisateur($donnees);
 		}
 		else{
 			return new Utilisateur(array());
 		}
	}


	/**********************************
	**							     **
	** 	 Retourne les utilisateurs   **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$utils = array();
		$q = 'SELECT * FROM utilisateurs';

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
			$utils[] = new Utilisateur($donnees);
		}
 		return $utils;
	}

	/********************************
	**							   **
	**      Test de connexion 	   **
	** 							   **
	** Entrée : (Utilisateur)	   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/
	
	public function testConnexion(Utilisateur $util) {
		$req = $this->_db->prepare('
			SELECT 
				COUNT(id) AS nbr_id, id, nom, prenom, rang
			FROM 
				utilisateurs
			WHERE 
					pseudo = :pseudo
				AND mot_de_passe = :mot_de_passe
				AND actif = 1
		');
		$req->bindValue(':pseudo', $util->getPseudo());
		$req->bindValue(':mot_de_passe', $util->getMot_de_passe());
		$req->execute();
		if($req->rowCount()>0)
			return true;
		else
			return false;

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