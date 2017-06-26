<?php
class HoraireManager {
	
	private $_db;


	/********************************
	**							   **
	**    	   Constructeur   	   **
	** 							   **
	** Entrée : (Horaire)	  	   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function __construct(PDO $db) {
		$this->setDb($db);
	}

	/********************************
	**							   **
	**    Ajout d'un horaire	   **
	** 							   **
	** Entrée : (Horaire)		   **
	** Sortie : (Bool) 			   **
	**							   **
	********************************/

	public function ajouter(Horaire $horaire) {
		$req = $this->_db->prepare('
			INSERT INTO 
				horaires 
			SET 
				categorie = :categorie,
				jour = :jour,
				heure_debut = :heure_debut,
				heure_fin = :heure_fin,
				gymnase = :gymnase,
				annee = :annee
		');
		$req->bindValue(':categorie', $horaire->getCategorie(), PDO::PARAM_INT);
		$req->bindValue(':jour', $horaire->getJour(), PDO::PARAM_INT);
		$req->bindValue(':heure_debut', $horaire->getHeure_debut(), PDO::PARAM_INT);
		$req->bindValue(':heure_fin', $horaire->getHeure_fin(), PDO::PARAM_INT);
		$req->bindValue(':gymnase', $horaire->getGymnase());
		$req->bindValue(':annee', $horaire->getAnnee(), PDO::PARAM_INT);

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
	** Modification d'un horaire	 **
	** 							     **
	** Entrée : (Horaire)		     **
	** Sortie : (Bool)  			 **
	**							     **
	**********************************/

	public function modifier(Horaire $horaire) {
		$req = $this->_db->prepare('
			UPDATE
				horaires 
			SET 
				categorie = :categorie,
				jour = :jour,
				heure_debut = :heure_debut,
				heure_fin = :heure_fin,
				gymnase = :gymnase,
				annee = :annee
			WHERE
				id = :id
		');
		$req->bindValue(':id', $horaire->getId(), PDO::PARAM_INT);
		$req->bindValue(':categorie', $horaire->getCategorie(), PDO::PARAM_INT);
		$req->bindValue(':jour', $horaire->getJour(), PDO::PARAM_INT);
		$req->bindValue(':heure_debut', $horaire->getHeure_debut(), PDO::PARAM_INT);
		$req->bindValue(':heure_fin', $horaire->getHeure_fin(), PDO::PARAM_INT);
		$req->bindValue(':gymnase', $horaire->getGymnase());
		$req->bindValue(':annee', $horaire->getAnnee(), PDO::PARAM_INT);
		
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
	** Suppression d'un horaire		**
	** 							    **
	** Entrée : (Horaire)		    **
	** Sortie : (Array)			    **
	**							    **
	*********************************/

	public function supprimer(Horaire $horaire) {
		return $this->_db->exec('DELETE FROM horaires WHERE id = '.$horaire->getId());
	}

	/**********************************
	**							     **
	** 	  Retourne un horaire	     **
	** 							     **
	** Entrée : (Array)  		     **
	** Sortie : (Horaire)    		 **
	**							     **
	**********************************/

	public function retourne($options = array()) {
		$q = 'SELECT * FROM horaires';

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
 			return new Horaire($donnees);
		}
		else {
			return new Horaire(array());
		}
	}

	/**********************************
	**							     **
	** 	 Retourne les horaires		 **
	** 							     **
	** Entrée : (Array)	  		     **
	** Sortie : (Array) 			 **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$horaires = array();
		$q = 'SELECT * FROM horaires';

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
			$horaires[] = new Horaire($donnees);
		}
 		return $horaires;
	}

	/**********************************
	**							     **
	** 	 Retourne l'horaire min		 **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Int) 				 **
	**							     **
	**********************************/

	public function heureMin($annee = 0) {
		$q = 'SELECT MIN(heure_debut) FROM horaires WHERE annee = '. $annee;
		$req = $this->_db->prepare($q);
		$req->execute();
		$donnees = $req->fetch(PDO::FETCH_ASSOC);
 		return $donnees['MIN(heure_debut)'];
	}

	/**********************************
	**							     **
	** 	 Retourne l'horaire max		 **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Int) 				 **
	**							     **
	**********************************/

	public function heureMax($annee = 0) {
		$q = 'SELECT MAX(heure_fin) FROM horaires WHERE annee = '. $annee;
		$req = $this->_db->prepare($q);
		$req->execute();
		$donnees = $req->fetch(PDO::FETCH_ASSOC);
 		return $donnees['MAX(heure_fin)'];
	}

	/**********************************
	**							     **
	** 	 Retourne l'horaire max		 **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Int) 				 **
	**							     **
	**********************************/

	public function nombreGymnaseParJour($annee = 0, $jour = 0) {
		$q = 'SELECT COUNT(DISTINCT gymnase) AS nbr_gymnase FROM horaires WHERE jour = '. $jour .' AND annee = '. $annee;
		$req = $this->_db->prepare($q);
		$req->execute();
		$donnees = $req->fetch(PDO::FETCH_ASSOC);
 		return $donnees['nbr_gymnase'];
	}
    
    /******************************************
	**							             **
	** 	 Retourne le planning horaires		 **
	** 							             **
	** Entrée : (Int)	  		             **
	** Sortie : (Bool | Int)		         **
	**							             **
	******************************************/
    
    function planningHoraires($annee) {
		$liste = array();
		$raccourci = '';
		$jour = 0;
		$gymnase = '';
		$heure_debut = 0;
		$heure_fin = 0;
		
        $req = $this->_db->prepare("
			SELECT 
				C.raccourci, H.jour, H.heure_debut, H.heure_fin, H.gymnase 
			FROM 
				categories AS C, horaires AS H
			WHERE 
				C.id = H.categorie 
				AND annee = :annee
			ORDER BY H.jour, H.heure_debut, H.gymnase
		");
        $req->bindValue(':annee', $annee, PDO::PARAM_INT);
		$req->execute();
        
 		if($req->rowCount()>0) {
            while ($d = $req->fetch(PDO::FETCH_ASSOC)) {
                if($d['jour'] == $jour && $d['gymnase'] == $gymnase && $d['heure_debut'] == $heure_debut && $d['heure_fin'] == $heure_fin)
                        $raccourci .= '-'.$d['raccourci'];
                else
                    $raccourci = $d['raccourci'];
                $liste[$d['jour']][$d['gymnase']][$d['heure_debut'].'-'.$d['heure_fin']] = $raccourci;
                extract($d);
            }
            return $liste;
		} else {
			return false;
		}
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