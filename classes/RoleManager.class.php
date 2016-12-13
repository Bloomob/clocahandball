<?php
class RoleManager {
	
	private $_db;


	/********************************
	**							   **
	**    	   Constructeur   	   **
	** 							   **
	** Entrée : (PDO)			   **
	** Sortie : (Void)			   **
	**							   **
	********************************/

	public function __construct(PDO $db) {
		$this->setDb($db);
	}

	/********************************
	**							   **
	**    Ajout d'un rôle 		   **
	** 							   **
	** Entrée : (Role)		 	   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Role $role) {
		$req = $this->_db->prepare('
			INSERT INTO 
				roles 
			SET 
				nom = :nom,
				parent = :parent,
				raccourci = :raccourci,
				ordre = :ordre,
				actif = :actif
		');

		$req->bindValue(':nom', $role->getNom());
		$req->bindValue(':parent', $role->getParent(), PDO::PARAM_INT);
		$req->bindValue(':raccourci', $role->getRaccourci());
		$req->bindValue(':ordre', $role->getOrdre(), PDO::PARAM_INT);
		$req->bindValue(':actif', $role->getActif(), PDO::PARAM_INT);

		return $req->execute();
	}

	/**********************************
	**							     **
	** Modification d'un rôle		 **
	** 							     **
	** Entrée : (Role)	 	    	 **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function modifier(Role $role) {
		$req = $this->_db->prepare('
			UPDATE
				roles 
			SET 
				nom = :nom,
				parent = :parent,
				raccourci = :raccourci,
				ordre = :ordre,
				actif = :actif
			WHERE
				id = :id
		');
		$req->bindValue(':id', $role->getId());
		$req->bindValue(':nom', $role->getNom());
		$req->bindValue(':parent', $role->getParent(), PDO::PARAM_INT);
		$req->bindValue(':raccourci', $role->getRaccourci());
		$req->bindValue(':ordre', $role->getOrdre(), PDO::PARAM_INT);
		$req->bindValue(':actif', $role->getActif(), PDO::PARAM_INT);
		
		return $req->execute();
	}

	/*********************************
	**							    **
	** Suppression d'un role 		**
	** 							    **
	** Entrée : (Role)			    **
	** Sortie : (Void)			    **
	**							    **
	*********************************/

	public function supprimer(Role $role) {
		$this->_db->exec('DELETE FROM roles WHERE id = '.$role->getId());
	}


	/**********************************
	**							     **
	**   Existance d'un role		 **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Bool)   		     **
	**							     **
	**********************************/

	public function existeId($id) {
		$q = 'SELECT * FROM roles WHERE id = '. $id;
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
	** 	  	Retourne un rôle	     **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourne($options = array()) {
		$q = 'SELECT * FROM roles';

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
 			return new Role($donnees);
		}
		else {
			return new Role(array());
		}
	}

	/**********************************
	**							     **
	** 	 Retourne les rôles		     **
	** 							     **
	** Entrée : (Void)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$roles = array();

		$q = 'SELECT * FROM roles';

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
			$roles[] = new Role($donnees);
		}
 		return $roles;
	}

	/***************************************
	**							    	  **
	** Retourne les id des rôles triés    **
	** 							   		  **
	** Entrée : (Void)	  		   		  **
	** Sortie : (Array) || (Bool)  		  **
	**							   		  **
	***************************************/

	public function retourneListeTries() {
		$roles = array();

		$q = 'SELECT * FROM roles ORDER BY parent, ordre';

		$req = $this->_db->prepare($q);
		$req->execute();
		while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
			if($donnees['parent'] == 0)
				$roles[$donnees['id']] = array();
			else
				$roles[$donnees['parent']][] = $donnees['id'];
		}
 		return $roles;
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