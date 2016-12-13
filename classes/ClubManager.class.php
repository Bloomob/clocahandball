<?php
class ClubManager {
	
	private $_db;


	/********************************
	**							   **
	**    	   Constructeur   	   **
	** 							   **
	** Entrée : (Club)	  		   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function __construct(PDO $db) {
		$this->setDb($db);
	}

	/********************************
	**							   **
	**    Ajout d'un club 		   **
	** 							   **
	** Entrée : (Club)			   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Club $club) {
		$req = $this->_db->prepare('
			INSERT INTO 
				clubs 
			SET 
				nom = :nom,
				raccourci = :raccourci,
				numero = :numero,
				ville = :ville,
				code_postal = :code_postal,
				actif = :actif
		');
		$req->bindValue(':nom', $club->getNom());
		$req->bindValue(':raccourci', $club->getRaccourci());
		$req->bindValue(':numero', $club->getNumero(), PDO::PARAM_INT);
		$req->bindValue(':ville', $club->getVille());
		$req->bindValue(':code_postal', $club->getCode_postal(), PDO::PARAM_INT);
		$req->bindValue(':actif', $club->getActif(), PDO::PARAM_INT);

		return $req->execute();
	}

	/**********************************
	**							     **
	** Modification d'un club 		 **
	** 							     **
	** Entrée : (Club)			     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function modifier(Club $club) {
		$req = $this->_db->prepare('
			UPDATE
				clubs 
			SET 
				nom = :nom,
				raccourci = :raccourci,
				numero = :numero,
				ville = :ville,
				code_postal = :code_postal,
				actif = :actif
			WHERE
				id = :id
		');
		$req->bindValue(':id', $club->getId(), PDO::PARAM_INT);
		$req->bindValue(':nom', $club->getNom());
		$req->bindValue(':raccourci', $club->getRaccourci());
		$req->bindValue(':numero', $club->getNumero(), PDO::PARAM_INT);
		$req->bindValue(':ville', $club->getVille());
		$req->bindValue(':code_postal', $club->getCode_postal(), PDO::PARAM_INT);
		$req->bindValue(':actif', $club->getActif(), PDO::PARAM_INT);
		
		return $req->execute();

	}

	/*********************************
	**							    **
	** Suppression d'un club 		**
	** 							    **
	** Entrée : (Club)			    **
	** Sortie : (Array) || (Bool)   **
	**							    **
	*********************************/

	public function supprimer(Club $club) {
		return $this->_db->exec('DELETE FROM clubs WHERE id = '.$club->getId());
	}

	/**********************************
	**							     **
	** 	 Retourne un club par id     **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneById($id) {
		$req = $this->_db->prepare('SELECT * FROM clubs WHERE id = '.$id);
		$req->execute();
		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
 			return new Club($donnees);
		}
		else {
			return new Club(array());
		}
	}

	/**********************************
	**							     **
	** 	  Retourne un club 		     **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourne($id) {
		$req = $this->_db->prepare('SELECT * FROM clubs WHERE id = '.$id);
		$req->execute();
		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
 			return new Club($donnees);
		}
		else {
			return new Club(array());
		}
	}

	/**********************************
	**							     **
	** 	 Retourne les clubs			 **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$clubs = array();
		$q = 'SELECT * FROM clubs';

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
			$clubs[] = new Club($donnees);
		}
 		return $clubs;
	}

	/**********************************
	**							     **
	** Compte le nombre de clubs	 **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function compte() {
		$req = $this->_db->prepare('SELECT id FROM clubs');
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