<?php
class Menu_managerManager {
	
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
	**   Ajout d'un menu manager   **
	** 							   **
	** Entrée : (Menu_manager)	   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Menu_manager $menu_manager) {
		$req = $this->_db->prepare('
			INSERT INTO 
				menu_manager 
			SET 
				nom = :nom,
				lien = :lien,
				image = :image,
				parent = :parent,
				ordre = :ordre,
				estSupprimable = :estSupprimable,
				actif = :actif
		');
		$req->bindValue(':nom', $menu_manager->getNom());
		$req->bindValue(':lien', $menu_manager->getLien());
		$req->bindValue(':image', $menu_manager->getImage());
		$req->bindValue(':parent', $menu_manager->getParent(), PDO::PARAM_INT);
		$req->bindValue(':ordre', $menu_manager->getOrdre(), PDO::PARAM_INT);
		$req->bindValue(':estSupprimable', $menu_manager->getEstSupprimable(), PDO::PARAM_INT);
		$req->bindValue(':actif', $menu_manager->getActif(), PDO::PARAM_INT);

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

	public function modifier(Menu_manager $menu_manager) {
		$req = $this->_db->prepare('
			UPDATE
				menu_manager 
			SET 
				nom = :nom,
				lien = :lien,
				image = :image,
				parent = :parent,
				ordre = :ordre,
				estSupprimable = :estSupprimable,
				actif = :actif
			WHERE
				id = :id
		');
		$req->bindValue(':nom', $menu_manager->getNom());
		$req->bindValue(':lien', $menu_manager->getLien());
		$req->bindValue(':image', $menu_manager->getImage());
		$req->bindValue(':parent', $menu_manager->getParent(), PDO::PARAM_INT);
		$req->bindValue(':ordre', $menu_manager->getOrdre(), PDO::PARAM_INT);
		$req->bindValue(':estSupprimable', $menu_manager->getEstSupprimable(), PDO::PARAM_INT);
		$req->bindValue(':actif', $menu_manager->getActif(), PDO::PARAM_INT);
		
		$req->execute();
	}

	/*************************************
	**							    	**
	**  Suppression d'un menu manager  	**
	** 							    	**
	** Entrée : (Actualité)		    	**
	** Sortie : (Void)			    	**
	**							    	**
	*************************************/

	public function supprimer(Menu_manager $menu_manager) {
		$this->_db->exec('DELETE FROM menu_manager WHERE id = '.$actu->getId());
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
		$q = 'SELECT * FROM menu_manager WHERE id = '. $id;
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

	public function retourne($id) {
		$id = (int) $id;
		$req = $this->_db->prepare('SELECT * FROM menu_manager WHERE id = '.$id);
		$req->execute();
		$donnees = $req->fetch(PDO::FETCH_ASSOC);
 		return new Menu_manager($donnees);
	}

	/**********************************
	**							     **
	** 	 Retourne les menu manager   **
	** 							     **
	** Entrée : (Void)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$menus = array();

		$q = 'SELECT * FROM menu_manager';

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
			$menus[] = new Menu_manager($donnees);
		}
 		return $menus;
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