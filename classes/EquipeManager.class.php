<?php
class EquipeManager {
	
	private $_db;


	/********************************
	**							   **
	**    	   Constructeur   	   **
	** 							   **
	** Entrée : (Equipe)	  	   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function __construct(PDO $db) {
		$this->setDb($db);
	}

	/********************************
	**							   **
	**    Ajout d'une equipe	   **
	** 							   **
	** Entrée : (Equipe)		   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Equipe $equipe) {
		$req = $this->_db->prepare('
			INSERT INTO 
				equipes 
			SET 
				categorie = :categorie,
				niveau = :niveau,
				championnat = :championnat,
				annee = :annee,
				entraineurs = :entraineurs,
				entrainements = :entrainements,
				id_photo_equipe = :id_photo_equipe,
				actif = :actif
		');
		$req->bindValue(':categorie', $equipe->getCategorie(), PDO::PARAM_INT);
		$req->bindValue(':niveau', $equipe->getNiveau(), PDO::PARAM_INT);
		$req->bindValue(':championnat', $equipe->getChampionnat(), PDO::PARAM_INT);
		$req->bindValue(':annee', $equipe->getAnnee(), PDO::PARAM_INT);
		$req->bindValue(':entraineurs', $equipe->getEntraineurs());
		$req->bindValue(':entrainements', $equipe->getEntrainements());
		$req->bindValue(':id_photo_equipe', $equipe->getId_photo_equipe(), PDO::PARAM_INT);
		$req->bindValue(':actif', $equipe->getActif(), PDO::PARAM_INT);

		if($req->execute()){
			return $this->_db->lastInsertID();
		}
		else {
			var_dump($req->errorInfo());
			return false;
		}
	}

	/**********************************
	**							     **
	** Modification d'une equipe	 **
	** 							     **
	** Entrée : (Equipe)		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function modifier(Equipe $equipe) {
		$req = $this->_db->prepare('
			UPDATE
				equipes 
			SET 
				categorie = :categorie,
				niveau = :niveau,
				championnat = :championnat,
				annee = :annee,
				entraineurs = :entraineurs,
				entrainements = :entrainements,
				id_photo_equipe = :id_photo_equipe,
				actif = :actif
			WHERE
				id = :id
		');
		$req->bindValue(':id', $equipe->getId(), PDO::PARAM_INT);
		$req->bindValue(':categorie', $equipe->getCategorie(), PDO::PARAM_INT);
		$req->bindValue(':niveau', $equipe->getNiveau(), PDO::PARAM_INT);
		$req->bindValue(':championnat', $equipe->getChampionnat(), PDO::PARAM_INT);
		$req->bindValue(':annee', $equipe->getAnnee(), PDO::PARAM_INT);
		$req->bindValue(':entraineurs', $equipe->getEntraineurs());
		$req->bindValue(':entrainements', $equipe->getEntrainements());
		$req->bindValue(':id_photo_equipe', $equipe->getId_photo_equipe(), PDO::PARAM_INT);
		$req->bindValue(':actif', $equipe->getActif(), PDO::PARAM_INT);
        
		if($req->execute()){
			return $this->_db->lastInsertID();
		}
		else {
			var_dump($req->errorInfo());
			return false;
		}
	}

	/*********************************
	**							    **
	** Suppression d'une equipe		**
	** 							    **
	** Entrée : (Equipe)		    **
	** Sortie : (Array) || (Bool)   **
	**							    **
	*********************************/

	public function supprimer(Equipe $equipe) {
		return $this->_db->exec('DELETE FROM equipes WHERE id = '.$equipe->getId());
	}

	/**********************************
	**							     **
	** 	  Retourne une equipe	     **
	** 							     **
	** Entrée : (Array)  		     **
	** Sortie : (Equipe)    		 **
	**							     **
	**********************************/

	public function retourne($options = array()) {
		$q = 'SELECT * FROM equipes';

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
 			return new Equipe($donnees);
		}
		else {
			return new Equipe(array());
		}
	}

	/**********************************
	**							     **
	** 	 Retourne les equipes		 **
	** 							     **
	** Entrée : (Array)	  		     **
	** Sortie : (Array) 			 **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$equipes = array();
		$q = 'SELECT * FROM equipes';

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
			$equipes[] = new Equipe($donnees);
		}
 		return $equipes;
	}

	/**********************************
	**							     **
	** Compte le nombre d'equipe	 **
	** 							     **
	** Entrée : (Void)	  		     **
	** Sortie : (Int) 			     **
	**							     **
	**********************************/

	public function compte() {
		$req = $this->_db->prepare('SELECT id FROM equipes');
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