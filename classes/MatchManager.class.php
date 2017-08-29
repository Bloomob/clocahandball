<?php
class MatchManager {
	
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
	**    Ajout d'un match 		   **
	** 							   **
	** Entrée : (Match)			   **
	** Sortie : (Array) || (Bool)  **
	**							   **
	********************************/

	public function ajouter(Match $match) {
		$req = $this->_db->prepare('
			INSERT INTO 
				matchs 
			SET 
				categorie = :categorie,
				date = :date,
				heure = :heure,
				competition = :competition,
				niveau = :niveau,
				lieu = :lieu,
				gymnase = :gymnase,
				adversaires = :adversaires,
				scores_dom = :scores_dom,
				scores_ext = :scores_ext,
				journee = :journee,
				tour = :tour,
				joue = :joue,
				arbitre = :arbitre,
				classement = :classement
		');
		$req->bindValue(':categorie', $match->getCategorie(), PDO::PARAM_INT);
		$req->bindValue(':date', $match->getDate(), PDO::PARAM_INT);
		$req->bindValue(':heure', $match->getHeure(), PDO::PARAM_INT);
		$req->bindValue(':competition', $match->getCompetition(), PDO::PARAM_INT);
		$req->bindValue(':niveau', $match->getNiveau(), PDO::PARAM_INT);
		$req->bindValue(':lieu', $match->getLieu(), PDO::PARAM_INT);
		$req->bindValue(':gymnase', $match->getGymnase());
		$req->bindValue(':adversaires', $match->getAdversaires());
		$req->bindValue(':scores_dom', $match->getScores_dom());
		$req->bindValue(':scores_ext', $match->getScores_ext());
		$req->bindValue(':journee', $match->getJournee(), PDO::PARAM_INT);
		$req->bindValue(':tour', $match->getTour());
		$req->bindValue(':joue', $match->getJoue(), PDO::PARAM_INT);
		$req->bindValue(':arbitre', $match->getArbitre());
		$req->bindValue(':classement', $match->getClassement(), PDO::PARAM_INT);

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
	** Modification d'un match		 **
	** 							     **
	** Entrée : (Match)			     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function modifier(Match $match) {
		$req = $this->_db->prepare('
			UPDATE
				matchs 
			SET 
				categorie = :categorie,
				date = :date,
				heure = :heure,
				competition = :competition,
				niveau = :niveau,
				lieu = :lieu,
				gymnase = :gymnase,
				adversaires = :adversaires,
				scores_dom = :scores_dom,
				scores_ext = :scores_ext,
				journee = :journee,
				tour = :tour,
				joue = :joue,
				arbitre = :arbitre,
				classement = :classement
			WHERE
				id = :id
		');
		$req->bindValue(':id', $match->getId(), PDO::PARAM_INT);
		$req->bindValue(':categorie', $match->getCategorie(), PDO::PARAM_INT);
		$req->bindValue(':date', $match->getDate(), PDO::PARAM_INT);
		$req->bindValue(':heure', $match->getHeure(), PDO::PARAM_INT);
		$req->bindValue(':competition', $match->getCompetition(), PDO::PARAM_INT);
		$req->bindValue(':niveau', $match->getNiveau(), PDO::PARAM_INT);
		$req->bindValue(':lieu', $match->getLieu(), PDO::PARAM_INT);
		$req->bindValue(':gymnase', $match->getGymnase());
		$req->bindValue(':adversaires', $match->getAdversaires());
		$req->bindValue(':scores_dom', $match->getScores_dom());
		$req->bindValue(':scores_ext', $match->getScores_ext());
		$req->bindValue(':journee', $match->getJournee(), PDO::PARAM_INT);
		$req->bindValue(':tour', $match->getTour());
		$req->bindValue(':joue', $match->getJoue(), PDO::PARAM_INT);
		$req->bindValue(':arbitre', $match->getArbitre());
		$req->bindValue(':classement', $match->getClassement(), PDO::PARAM_INT);
		
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
	** Suppression d'un match 		**
	** 							    **
	** Entrée : (Match)			    **
	** Sortie : (Array) || (Bool)   **
	**							    **
	*********************************/

	public function supprimer(Match $match) {
		$this->_db->exec('DELETE FROM matchs WHERE id = '.$match->getId());
	}

	/**********************************
	**							     **
	** 	  Retourne un match		     **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Match) || (Bool) 	 **
	**							     **
	**********************************/

	public function retourne($id) {
		$id = (int) $id;
		$req = $this->_db->prepare('SELECT * FROM matchs WHERE id = '.$id);
		$req->execute();
		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
 			return new Match($donnees);
 		}
 		return false;
	}

	/**********************************
	**							     **
	** 	 Retourne les matchs		 **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function retourneListe($options = array()) {
		$matchs = array();
		$q = 'SELECT * FROM matchs';

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
			$matchs[] = new Match($donnees);
		}
 		return $matchs;
	}

	/**********************************
	**							     **
	** Compte le nombre de matchs	 **
	** 							     **
	** Entrée : (Void)	  		     **
	** Sortie : (Int)			     **
	**							     **
	**********************************/

	public function compte() {
		$req = $this->_db->prepare('SELECT id FROM matchs');
		$req->execute();
 		return $req->rowCount();
	}
	
	/**********************************
	**							     **
	** 	Retourne un dernier match    **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function dernierMatch($id) {
		$id = (int) $id;
		$mois = date('n',time());
		$annee = date('Y',time());
		if($mois < 7):
			$annee_suiv = $annee;
			$annee--;
		else:
			$annee_suiv = $annee+1;
		endif;
		
		$req = $this->_db->prepare('SELECT * FROM matchs WHERE categorie = '.$id.' 
				AND date > '. $annee .'0701
				AND date  <= '. $annee_suiv .'0701
				AND date  <= '. date('Ymd') .'
				AND joue = 1');
		$req->execute();
		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
			return new Match($donnees);
		}
		else {
			return false;
		}
	}
	/**********************************
	**							     **
	** 	Retourne un prochain match    **
	** 							     **
	** Entrée : (Int)	  		     **
	** Sortie : (Array) || (Bool)    **
	**							     **
	**********************************/

	public function prochainMatch($id) {
		$id = (int) $id;
		$mois = date('n',time());
		$annee = date('Y',time());
		if($mois < 7):
			$annee_suiv = $annee;
			$annee--;
		else:
			$annee_suiv = $annee+1;
		endif;
		
		$req = $this->_db->prepare('
			SELECT * FROM matchs WHERE categorie = '.$id.' 
			AND date > '. $annee .'0701
			AND date  <= '. $annee_suiv .'0701
			AND date  >= '. date('Ymd') .'
			AND joue = 0
		');
		$req->execute();
		if($req->rowCount()>0){
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
			return new Match($donnees);
		}
		else {
			return false;
		}
	}

	/******************************************
	**										 **
	** Liste les statistiques 				 **
	** 										 **
	** Entrée : (Int) id 				 	 **
	** Sortie : (Array) 					 **
	**										 **
	******************************************/
	
	function liste_stats($id, $annee) {
		$id = (int) $id;
		$liste = array('nb_vic' => 0, 'nb_nul' => 0, 'nb_def' => 0, 'nb_bp' => 0, 'nb_bc' => 0, 'nb_bp_dom' => 0, 'nb_bc_dom' => 0, 'nb_bp_ext' => 0, 'nb_bc_ext' => 0);
		$annee_suiv = $annee+1;

		$req = $this->_db->prepare("
			SELECT * FROM matchs WHERE categorie = ".$id."
			AND date >= ".$annee."0701
			AND date < ".$annee_suiv."0701
			AND competition != 5
			AND joue = 1
		");
		$req->execute();
		while ($donnees = $req->fetch(PDO::FETCH_ASSOC)):
			$adversaires = explode(',', $donnees['adversaires']);
			$scores_dom = explode(',', $donnees['scores_dom']);
			$scores_ext = explode(',', $donnees['scores_ext']);
			foreach ($adversaires as $i => $val) :
				switch($donnees['lieu']):
					case 0:
						if($scores_dom[$i] > $scores_ext[$i]):
							$liste['nb_vic']++;
						elseif($scores_dom[$i] < $scores_ext[$i]):
							$liste['nb_def']++;
						else:
							$liste['nb_nul']++;
						endif;
						$liste['nb_bp'] += $scores_dom[$i];
						$liste['nb_bc'] += $scores_ext[$i];
						$liste['nb_bp_dom'] += $scores_dom[$i];
						$liste['nb_bc_dom'] += $scores_ext[$i];
					break;
					case 1:
					case 2:
						if($scores_dom[$i] < $scores_ext[$i]):
							$liste['nb_vic']++;
						elseif($scores_dom[$i] > $scores_ext[$i]):
							$liste['nb_def']++;
						else:
							$liste['nb_nul']++;
						endif;
						$liste['nb_bc'] += $scores_dom[$i];
						$liste['nb_bp'] += $scores_ext[$i];
						$liste['nb_bc_ext'] += $scores_dom[$i];
						$liste['nb_bp_ext'] += $scores_ext[$i];
					break;
				endswitch;
			endforeach;
		endwhile;
 		return $liste;
	}

	/***************************************
	**							     	  **
	** 	Retourne les 5 derniers matchs    **
	** 							     	  **
	** Entrée : (Int)	  		     	  **
	** Sortie : (String) || (Bool)    	  **
	**							     	  **
	***************************************/

	public function cinq_derniers_matchs($id) {
		$retour = '';
		$nbr_match = 0;
		$id = (int) $id;
		$mois = date('n',time());
		$annee = date('Y',time());
		if($mois < 7):
			$annee_suiv = $annee;
			$annee--;
		else:
			$annee_suiv = $annee+1;
		endif;
		
		$req = $this->_db->prepare('SELECT * FROM matchs WHERE categorie = '.$id.' 
				AND date > '. $annee .'0701
				AND date  <= '. $annee_suiv .'0701
				AND date  <= '. date('Ymd') .'
				AND joue = 1
				ORDER BY date DESC, SUBSTR(heure, 1, 2) DESC, SUBSTR(heure, 3, 2) DESC
				LIMIT 0,5');
		$req->execute();
		if($req->rowCount()>0){
			while($donnees = $req->fetch(PDO::FETCH_ASSOC)):
				$adversaires = explode(',', $donnees['adversaires']);
				$scores_dom = explode(',', $donnees['scores_dom']);
				$scores_ext = explode(',', $donnees['scores_ext']);
				foreach ($adversaires as $i => $val) :
					switch($donnees['lieu']):
						case 0:
						case 2:
						default:
							//debug($i.' : '.$scores_dom[$i].' - '.$scores_ext[$i]);
							if($scores_dom[$i]>$scores_ext[$i])
								$retour = '<span class="vert">V</span> '.$retour;
							elseif($scores_dom[$i]<$scores_ext[$i])
								$retour = '<span class="rouge">D</span> '.$retour;
							else
								$retour = '<span class="orange">N</span> '.$retour;
						break;
						case 1:
							//debug($i.' : '.$scores_dom[$i].' - '.$scores_ext[$i]);
							if($scores_dom[$i]<$scores_ext[$i])
								$retour = '<span class="vert">V</span> '.$retour;
							elseif($scores_dom[$i]>$scores_ext[$i])
								$retour = '<span class="rouge">D</span> '.$retour;
							else
								$retour = '<span class="orange">N</span> '.$retour;
						break;
					endswitch;
					$nbr_match++;
					if($nbr_match >= 5)
						break 2;
				endforeach;
			endwhile;
			while($nbr_match < 5):
				$retour = '- '.$retour;
				$nbr_match++;
			endwhile;
			return $retour;
		}
		else {
			return 'Aucune';
		}
	}

	/*****************************************************
	**									  			    **
	**  Verification de la date de match à domicile		**
	** 							   						**
	** Entrée : (date, heure)			   				**
	** Sortie : (Void)			   						**
	**							   						**
	*****************************************************/

	public function verifier_date_match_domicile(Match $match) {
		$id = $match->getId();
		$lieu = $match->getLieu();
		$date = $match->getDate();
		$heure = $match->getHeure();

		if($heure != '0' AND $lieu == 0):
			$minH = $heure - 100;
			$maxH = $heure + 100;

			$req = $this->_db->prepare('
				SELECT * FROM matchs 
				WHERE
					lieu = 0
					AND date = '.$date.' 
					AND heure < '.$maxH.' 
					AND heure > '.$minH.' 
					AND id != '.$id.' 
				LIMIT 
					0,1
			');
			$req->execute();
			if($req->rowCount()==0){
				return false;
			}
			return true;
		else:
			return false;
		endif;
	}

	/*****************************************************
	**									  			    **
	**  Verification de la date de match d'une équipe   **
	** 							   						**
	** Entrée : (id, date)			   					**
	** Sortie : (Void)			   						**
	**							   						**
	*****************************************************/

	public function verifier_date_match_equipe(Match $match) {
		$id = $match->getId();
		$cat_id = $match->getCategorie();
		$date = $match->getDate();

		$req = $this->_db->prepare('
			SELECT * FROM matchs 
			WHERE 
				id != '.$id.' 
				AND categorie = '.$cat_id.' 
				AND date = '.$date.' 
			LIMIT 
				0,1
		');
		$req->execute();
		if($req->rowCount()==0){
			return false;
		}
		return true;
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