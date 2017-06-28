<?php
class CategorieManager {
	
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
	**   Ajout d'une categorie 	   **
	** 							   **
	** Entrée : (Categorie)	 	   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Categorie $categorie) {
		$req = $this->_db->prepare('
			INSERT INTO 
				categories
			SET 
				categorie = :categorie,
				genre = :genre,
				numero = :numero,
				raccourci = :raccourci,
				ordre = :ordre,
				actif = :actif
		');

		$req->bindValue(':categorie', $categorie->getCategorie());
		$req->bindValue(':genre', $categorie->getGenre());
		$req->bindValue(':numero', $categorie->getnumero(), PDO::PARAM_INT);
		$req->bindValue(':raccourci', $categorie->getRaccourci());
		$req->bindValue(':ordre', $categorie->getOrdre(), PDO::PARAM_INT);
		$req->bindValue(':actif', $categorie->getActif(), PDO::PARAM_INT);

		return $req->execute();
	}

	/**********************************
	**							     **
	** Modification d'une categorie	 **
	** 							     **
	** Entrée : (Categorie)	 	   	 **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function modifier(Categorie $categorie) {
		$req = $this->_db->prepare('
			UPDATE
				categories 
			SET 
				nom = :nom,
				parent = :parent,
				raccourci = :raccourci,
				ordre = :ordre,
				actif = :actif
			WHERE
				id = :id
		');
		$req->bindValue(':id', $categorie->getId());
		$req->bindValue(':categorie', $categorie->getCategorie());
		$req->bindValue(':genre', $categorie->getGenre());
		$req->bindValue(':numero', $categorie->getnumero(), PDO::PARAM_INT);
		$req->bindValue(':raccourci', $categorie->getRaccourci());
		$req->bindValue(':ordre', $categorie->getOrdre(), PDO::PARAM_INT);
		$req->bindValue(':actif', $categorie->getActif(), PDO::PARAM_INT);
		
		return $req->execute();
	}

	/*********************************
	**							    **
	** Suppression d'une categorie	**
	** 							    **
	** Entrée : (Categorie)		    **
	** Sortie : (Void)			    **
	**							    **
	*********************************/

	public function supprimer(Categorie $categorie) {
		$this->_db->exec('DELETE FROM categories WHERE id = '.$categorie->getId());
	}

	/**********************************
	**							     **
	** 	 Retourne une categorie	     **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneById($id) {
		$req = $this->_db->prepare(
			'SELECT * FROM categories WHERE id = :id LIMIT 0, 1'
		);
		$req->bindValue(':id', $id, PDO::PARAM_INT);
		$req->execute();
		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
 			return new Categorie($donnees);
		}
		else {
			return new Categorie(array());
		}
	}

	/**********************************
	**							     **
	** 	 Retourne une categorie	     **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourne($options = array()) {
		$q = 'SELECT * FROM categories';

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
 			return new Categorie($donnees);
		}
		else {
			return new Categorie(array());
		}
	}

	/**********************************
	**							     **
	** 	 Retourne les categories     **
	** 							     **
	** Entrée : (Void)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$categories = array();

		$q = 'SELECT * FROM categories';

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
			$categories[] = new Categorie($donnees);
		}
 		return $categories;
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