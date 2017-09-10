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
				mot_de_passe = :mot_de_passe,
				rang = :rang,
				tel_port = :tel_port,
				src_photo = :src_photo,
				num_licence = :num_licence,
				liste_equipes_favorites = :liste_equipes_favorites,
				actif = :actif
		');
		$req->bindValue(':nom', $util->getNom());
		$req->bindValue(':prenom', $util->getPrenom());
		$req->bindValue(':mail', $util->getMail());
		$req->bindValue(':mot_de_passe', md5($util->getMot_de_passe()));
		$req->bindValue(':rang', $util->getRang(), PDO::PARAM_INT);
		$req->bindValue(':tel_port', $util->getTel_port(), PDO::PARAM_INT);
		$req->bindValue(':src_photo', $util->getSrc_photo());
		$req->bindValue(':num_licence', $util->getNum_licence());
		$req->bindValue(':liste_equipes_favorites', $util->getListe_equipes_favorites());
		$req->bindValue(':actif', $util->getActif(), PDO::PARAM_INT);

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
				mot_de_passe = :mot_de_passe,
				rang = :rang,
				tel_port = :tel_port,
				src_photo = :src_photo,
				num_licence = :num_licence,
				liste_equipes_favorites = :liste_equipes_favorites,
				actif = :actif
			WHERE
				id = :id
		');
		$req->bindValue(':id', $util->getId(), PDO::PARAM_INT);
		$req->bindValue(':nom', $util->getNom());
		$req->bindValue(':prenom', $util->getPrenom());
		$req->bindValue(':mail', $util->getMail());
		$req->bindValue(':mot_de_passe', md5($util->getMot_de_passe()));
		$req->bindValue(':rang', $util->getRang(), PDO::PARAM_INT);
		$req->bindValue(':tel_port', $util->getTel_port(), PDO::PARAM_INT);
		$req->bindValue(':src_photo', $util->getSrc_photo());
		$req->bindValue(':num_licence', $util->getNum_licence());
		$req->bindValue(':liste_equipes_favorites', $util->getListe_equipes_favorites());
		$req->bindValue(':actif', $util->getActif(), PDO::PARAM_INT);
        
		if($req->execute()){
			return $categorie->getId();
		}
		else {
			var_dump($req->errorInfo());
			return false;
		}
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
		return $this->_db->exec('DELETE FROM utilisateurs WHERE id = '.$util->getId());
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
	
	public function connexion(Utilisateur $util) {
		$req = $this->_db->prepare('
			SELECT 
				id
			FROM 
				utilisateurs
			WHERE 
					mail = :mail
				AND mot_de_passe = :mot_de_passe
				AND actif = 1
		');
		$req->bindValue(':mail', $util->getMail());
		$req->bindValue(':mot_de_passe', md5($util->getMot_de_passe()));
		$req->execute();
		if($req->rowCount()>0)
			return $req->fetch(PDO::FETCH_ASSOC);
		else
			return false;
	}

	/*****************************************
	**							   			**
	**	   Ajout d'utilisateur en ligne 	**
	** 							   			**
	**   Entrée : (Utilisateur)	   			**
	**   Sortie : (Array) || (Bool)  		**
	**							   			**
	*****************************************/

	function ajoutUserOnline($id, $ip, $page) {

		$req = $this->_db->prepare('
			INSERT INTO
				users_online 
			VALUES
				(:id, :timer, :ip, :page) 
			ON DUPLICATE KEY UPDATE
				time = :timer, id = :id, page = :page
		');
		$req->bindValue(':id', $id);
		$req->bindValue(':timer', time());
		$req->bindValue(':ip', $ip);
		$req->bindValue(':page', $page);
		$req->execute();
		

		$time_max = time() - (60 * 5);
		$req = $this->_db->prepare('
			DELETE FROM users_online WHERE time < :time_max
		');
		$req->bindValue(':time_max', $time_max);
		$req->execute();

		// Ajout de l'utlisateur
		/*$maReq = '	INSERT INTO users_online VALUES('. $id .', '. time() .','. $ip .',"'. $page .'") 
					ON DUPLICATE KEY UPDATE time = '. time() .' , id = '. $id .', page = "'. $page.'"';
		mysql_query($maReq) or die(mysql_error());
		
		// Suppression des anciens
		$time_max = time() - (60 * 5);
		$maReq2 = 'DELETE FROM users_online WHERE time < '. $time_max;
		mysql_query($maReq2) or die(mysql_error());*/
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