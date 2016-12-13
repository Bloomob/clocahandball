<?php
class MenuManager {
	
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
	**   Ajout d'un menu 		   **
	** 							   **
	** Entrée : (Menu)			   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Menu $menu) {
		$req = $this->_db->prepare('
			INSERT INTO 
				menu 
			SET 
				nom = :nom,
				url = :url,
				image = :image,
				parent = :parent,
				ordre = :ordre,
				actif = :actif
		');
		$req->bindValue(':nom', htmlentities(stripslashes($menu->getNom()), ENT_QUOTES, "UTF-8"));
		$req->bindValue(':url', htmlentities(stripslashes($menu->getUrl()), ENT_QUOTES, "UTF-8"));
		$req->bindValue(':image', htmlentities(stripslashes($menu->getImage()), ENT_QUOTES, "UTF-8"));
		$req->bindValue(':parent', $menu->getParent(), PDO::PARAM_INT);
		$req->bindValue(':ordre', $menu->getOrdre(), PDO::PARAM_INT);
		$req->bindValue(':actif', $menu->getActif(), PDO::PARAM_INT);

		$req->execute();
	}

	/**************************************
	**							    	 **
	**  Modification d'un menu manager 	 **
	** 							    	 **
	** Entrée : (Actualité)	 	  	   	 **
	** Sortie : (Array) || (Bool)  		 **
	**							   	  	 **
	**************************************/

	public function modifier(Menu $menu) {
		$req = $this->_db->prepare('
			UPDATE
				menu 
			SET 
				nom = :nom,
				url = :url,
				image = :image,
				parent = :parent,
				ordre = :ordre,
				actif = :actif
			WHERE
				id = :id
		');
		$req->bindValue(':id', $menu->getId(), PDO::PARAM_INT);
		$req->bindValue(':nom', htmlentities(stripslashes($menu->getNom()), ENT_QUOTES, "UTF-8"));
		$req->bindValue(':url', htmlentities(stripslashes($menu->getUrl()), ENT_QUOTES, "UTF-8"));
		$req->bindValue(':image', htmlentities(stripslashes($menu->getImage()), ENT_QUOTES, "UTF-8"));
		$req->bindValue(':parent', $menu->getParent(), PDO::PARAM_INT);
		$req->bindValue(':ordre', $menu->getOrdre(), PDO::PARAM_INT);
		$req->bindValue(':actif', $menu->getActif(), PDO::PARAM_INT);
		
		$req->execute();
	}

	/*************************************
	**							    	**
	**  Suppression d'un menu 		  	**
	** 							    	**
	** Entrée : (Actualité)		    	**
	** Sortie : (Void)			    	**
	**							    	**
	*************************************/

	public function supprimer(Menu $menu) {
		$this->_db->exec('DELETE FROM menu WHERE id = '.$menu->getId());
	}

	/**********************************
	**							     **
	**   Existance d'un menu		 **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Bool)   		     **
	**							     **
	**********************************/

	public function existeId($id) {
		$q = 'SELECT * FROM menu WHERE id = '. $id;
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
	** 	 Retourne un menu manager    **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourne($options = array()) {
		$q = 'SELECT * FROM menu';

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
 			return new Menu($donnees);
		}
		else {
			return new Menu(array());
		}
	}

	/**********************************
	**							     **
	** 	 Retourne les menu 			 **
	** 							     **
	** Entrée : (Void)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$menus = array();

		$q = 'SELECT * FROM menu';

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
			$menus[] = new Menu($donnees);
		}
 		return $menus;
	}

	/**********************************
	**							     **
	** 	 Retourne les menus triés	 **
	** 							     **
	** Entrée : (Array)	  		     **
	** Sortie : (Array)			     **
	**							     **
	**********************************/

	public function triListe(Array $menus) {
		$liste = array();

		foreach($menus as $menu){
			if($menu->getParent() == 0)
				$liste[$menu->getId()][] = $menu;
			else
				$liste[$menu->getParent()][] = $menu;
			// $this->triListe($menu);
		}

		return $liste;
	}

	/*************************************
	**							    	**
	**  Suppression de tous les menus  	**
	** 							    	**
	** Entrée : (Void)			    	**
	** Sortie : (Void)			    	**
	**							    	**
	*************************************/

	public function truncate() {
		$this->_db->exec('TRUNCATE TABLE menu');
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