<?php
class TarifManager {
	
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
	**    Ajout d'un tarif 		   **
	** 							   **
	** Entrée : (Tarif)		 	   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Tarif $tarif) {
		$req = $this->_db->prepare('
			INSERT INTO 
				tarifs 
			SET 
				date_naissance = :date_naissance,
				categorie = :categorie,
				genre = :genre,
				prix_old = :prix_old,
				prix_nv = :prix_nv,
				condition_old = :condition_old,
				condition_nv = :condition_nv,
				annee = :annee,
				actif = :actif
		');

		$req->bindValue(':date_naissance', $tarif->getDate_naissance());
		$req->bindValue(':categorie', $tarif->getCategorie());
		$req->bindValue(':genre', $tarif->getGenre(), PDO::PARAM_INT);
		$req->bindValue(':prix_old', $tarif->getPrix_old(), PDO::PARAM_INT);
		$req->bindValue(':prix_nv', $tarif->getPrix_nv(), PDO::PARAM_INT);
		$req->bindValue(':condition_old', $tarif->getCondition_old(), PDO::PARAM_INT);
		$req->bindValue(':condition_nv', $tarif->getCondition_nv(), PDO::PARAM_INT);
		$req->bindValue(':annee', $tarif->getAnnee(), PDO::PARAM_INT);
		$req->bindValue(':actif', $tarif->getActif(), PDO::PARAM_INT);

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
	** Modification d'un tarif		 **
	** 							     **
	** Entrée : (Tarif)	 	    	 **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function modifier(Tarif $tarif) {
		$req = $this->_db->prepare('
			UPDATE
				tarifs 
			SET 
				date_naissance = :date_naissance,
				categorie = :categorie,
				genre = :genre,
				prix_old = :prix_old,
				prix_nv = :prix_nv,
				condition_old = :condition_old,
				condition_nv = :condition_nv,
				annee = :annee,
				actif = :actif
			WHERE
				id = :id
		');
		$req->bindValue(':id', $tarif->getId(), PDO::PARAM_INT);
		$req->bindValue(':date_naissance', $tarif->getDate_naissance());
		$req->bindValue(':categorie', $tarif->getCategorie());
		$req->bindValue(':genre', $tarif->getGenre(), PDO::PARAM_INT);
		$req->bindValue(':prix_old', $tarif->getPrix_old(), PDO::PARAM_INT);
		$req->bindValue(':prix_nv', $tarif->getPrix_nv(), PDO::PARAM_INT);
		$req->bindValue(':condition_old', $tarif->getCondition_old(), PDO::PARAM_INT);
		$req->bindValue(':condition_nv', $tarif->getCondition_nv(), PDO::PARAM_INT);
		$req->bindValue(':annee', $tarif->getAnnee(), PDO::PARAM_INT);
		$req->bindValue(':actif', $tarif->getActif(), PDO::PARAM_INT);
		
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
	** Suppression d'un tarif 		**
	** 							    **
	** Entrée : (Tarif)			    **
	** Sortie : (Void)			    **
	**							    **
	*********************************/

	public function supprimer(Tarif $tarif) {
		$this->_db->exec('DELETE FROM tarifs WHERE id = '.$tarif->getId());
	}


	/**********************************
	**							     **
	**   Existance d'un tarif		 **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Bool)   		     **
	**							     **
	**********************************/

	public function existeId($id) {
		$q = 'SELECT * FROM tarifs WHERE id = '. $id;
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
	** 	  	Retourne un tarif	     **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourne($options = array()) {
		$q = 'SELECT * FROM tarifs';

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
 			return new Tarif($donnees);
		}
		else {
			return new Tarif(array());
		}
	}

	/**********************************
	**							     **
	** 	 Retourne les tarifs	     **
	** 							     **
	** Entrée : (Void)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$tarifs = array();

		$q = 'SELECT * FROM tarifs';

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
			$tarifs[] = new Tarif($donnees);
		}
 		return $tarifs;
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