<?php
	include_once("connexion_bdd.php");
	include_once("constantes.php");
	include_once("date.php");
	
	/*****************************************************
	**
	** Test de connexion
	** 
	** Entrée : (String) Pseudo, (String) Mot de passe
	** Sortie : (Array) si ok || (Bool) sinon
	**
	*****************************************************/
	
	function test_connexion($pseudo, $mot_de_passe){
		$liste = array();
		$maReq = "
			SELECT 
				COUNT(id) AS nbr_id, id, nom, prenom, rang
			FROM 
				utilisateurs
			WHERE 
				pseudo = '".$pseudo."'
				AND mot_de_passe = '".$mot_de_passe."'
				AND actif = 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		if($d['nbr_id']>0){
			$liste['id'] = $d['id'];
			$liste['nom'] = $d['nom'];
			$liste['prenom'] = $d['prenom'];
			$liste['rang'] = $d['rang'];
			return $liste;
		}
		else
			return false;
	}
	
    /*****************************************************
	**
	** Test s
	** 
	** Entrée : (String) Pseudo, (String) Mot de passe
	** Sortie : (Array) si ok || (Bool) sinon
	**
	*****************************************************/
	
	function accesAutorise($rang){
		$rangAutorise = array(1, 2);

		if(in_array($rang, $rangAutorise))
			return true;
		else
			return false;
	}

    /*******************************
	**
	** Test si la personne est admin
	** 
	** Entrée : (Int) Rang
	** Sortie : (Bool)
	**
	*******************************/
	
	function estAdmin($rang){
		$rangAutorise = array(1);

		if(in_array($rang, $rangAutorise))
			return true;
		else
			return false;
	}

    /************************************
	**
	** Test si la personne est rédactrice
	** 
	** Entrée : (Int) Rang
	** Sortie : (Bool)
	**
	************************************/
	
	function estRedacteur($rang){
		$rangAutorise = array(2);

		if(in_array($rang, $rangAutorise))
			return true;
		else
			return false;
	}

	/*******************************
	**
	** Liste des équipes entrainées
	** 
	** Entrée : (Int) Id
	** Sortie : (Array)  Raccourci, Fonction
	**
	*******************************/
	
	function liste_equipes_entrainees($id) {
		$liste = array();
		$maReq = "
			SELECT 
				LC.raccourci, LC.categorie, LC.type, LC.numero
			FROM 
				utilisateurs AS U, fonctions AS F, liste_categories AS LC
			WHERE 
				U.id = F.id_membre_bureau 
				AND F.categorie = LC.id 
				AND F.actif=1 
				AND F.type_fonction = 'entraineurs'
				AND U.id = '".$id."'
			ORDER BY LC.ordre DESC
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['raccourci'] = $d['raccourci'];
				$tab['fonction'] = (!empty($d['numero'])) ? $d['type'] .' '. $d['numero'] : $d['type'];
				$tab['fonction'] = (!empty($d['type'])) ? $d['categorie'] .' '. $tab['fonction'] : $d['categorie'];
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/*****************************************
	**
	** Retourne les fonctions d'une personne
	** 
	** Entrée : (Int) Id
	** Sortie : (Array)  Raccourci, Fonction
	**
	*****************************************/
	
	function retourne_fonctions($id) {
		$liste = array();
		$maReq = "
			SELECT 
				LC.raccourci, LC.categorie, LC.type, LC.numero
			FROM 
				fonctions AS F, liste_categories AS LC
			WHERE 
				".$id." = F.id_membre_bureau 
				AND F.categorie = LC.id 
				AND F.actif=1 
			ORDER BY LC.ordre DESC
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['raccourci'] = $d['raccourci'];
				$tab['fonction'] = (!empty($d['numero'])) ? $d['type'] .' '. $d['numero'] : $d['type'];
				$tab['fonction'] = (!empty($d['type'])) ? $d['categorie'] .' '. $tab['fonction'] : $d['categorie'];
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/******************************
	**
	** Liste des membres du bureau
	** 
	** Entrée : (String) Fonction
	** Sortie : (Array) 
	**
	******************************/
	
	function liste_membres_bureau($fonction = false) {
		$tab = array();
		$liste = array();
		$where = '';
		
		if($fonction !== false)
			$where .= " AND F.type_fonction = '".$fonction."' ";
		
		$maReq = "
			SELECT 
				U.id, U.nom, U.prenom, U.mail, U.tel_port, U.src_photo, F.annee_debut, LC.categorie, LC.type, LC.numero 
			FROM 
				utilisateurs AS U, fonctions AS F, liste_categories AS LC
			WHERE 
				U.id = F.id_membre_bureau 
				AND F.categorie = LC.id 
				AND F.actif=1 
				".$where."
			ORDER BY LC.ordre, F.ordre, U.nom
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['id'] = $d['id'];
				$tab['nom'] = $d['nom'];
				$tab['prenom'] = $d['prenom'];
				$tab['mail'] = $d['mail'];
				$tab['tel_port'] = ($d['tel_port']!=0)?$d['tel_port']:'06 ** ** ** **';
				$verifChemin = file_exists('image/photo_'. $d['id'] .'.png');
				$tab['src_photo'] = (!empty($d['src_photo']) && $d['src_photo'] && $verifChemin)? 'photo_'. $d['id'] .'.png' : 'inconnu.gif';
				$tab['annee_debut'] = (!empty($d['annee_debut']))?$d['annee_debut']:'20**';
				$fonction = (!empty($d['numero'])) ? $d['type'].' '.$d['numero'] : $d['type'];
				$tab['fonction'] = (!empty($d['type'])) ? $d['categorie'] .' '. $fonction : $d['categorie'];
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/******************************
	**
	** Liste des entraineurs
	** 
	** Entrée : (String) Fonction
	** Sortie : (Array) 
	**
	******************************/
	
	function liste_utilisateurs_auto($search = false) {
		$tab = array();
		$liste = array();
		$where = '';
		
		if($search !== false)
			$where .= " AND (U.nom LIKE '%".$search."%' OR U.prenom LIKE '%".$search."%') ";
		
		$maReq = "
			SELECT 
				U.id, U.nom, U.prenom 
			FROM 
				utilisateurs AS U
			WHERE 
				1 = 1
				".$where."
			ORDER BY U.nom
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['id'] = $d['id'];
				$tab['nom'] = $d['nom'];
				$tab['prenom'] = $d['prenom'];
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/******************************
	**
	** Liste des fonctions
	** 
	** Entrée : (String) Fonction
	** Sortie : (Array) 
	**
	******************************/
	
	function liste_fonctions($fonction = false) {
		$tab = array();
		$liste = array();
		
		if($fonction !== false)
			$where = " AND F.type_fonction = '".$fonction."' ";
		
		$maReq = "
			SELECT 
				U.id, U.nom, U.prenom, U.mail, U.tel_port, U.src_photo, F.type_fonction, F.annee_debut, F.actif, LC.categorie, LC.type, LC.numero 
			FROM 
				utilisateurs AS U, fonctions AS F, liste_categories AS LC
			WHERE 
				U.id = F.id_membre_bureau 
				AND F.categorie = LC.id 
				".$where."
			ORDER BY F.type_fonction, LC.ordre, U.nom
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['id'] = $d['id'];
				$tab['nom'] = $d['nom'];
				$tab['prenom'] = $d['prenom'];
				$tab['mail'] = $d['mail'];
				$tab['tel_port'] = ($d['tel_port']!=0)?$d['tel_port']:'06 ** ** ** **';
				$verifChemin = file_exists('image/photo_'. $d['id'] .'.png');
				$tab['src_photo'] = (!empty($d['src_photo']) && $d['src_photo'] && $verifChemin)? 'photo_'. $d['id'] .'.png' : 'inconnu.gif';
				$tab['annee_debut'] = (!empty($d['annee_debut']))?$d['annee_debut']:'20**';
				$fonction = (!empty($d['numero'])) ? $d['type'].' '.$d['numero'] : $d['type'];
				$tab['fonction'] = (!empty($d['type'])) ? $d['categorie'] .' '. $fonction : $d['categorie'];
				$tab['type'] = $d['type_fonction'];
				$tab['actif'] = $d['actif'];
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/******************************
	**
	** Liste de l'organnigramme
	** 
	** Entrée : (Array) Filtres
	** Sortie : (Array) 
	**
	******************************/
	
	function liste_organigramme($filtres = false) {
		$tab = array();
		$liste = array();
		$where = '';
		
		if(isset($filtres['type']))
			$where .= " AND F.type_fonction = '".$filtres['type']."' ";
		if(isset($filtres['actif']))
			$where .= ($filtres['actif'] == 'on') ? " AND F.actif = 1 " : " AND F.actif = 0 ";
		
		$maReq = "
			SELECT 
				U.id, U.nom, U.prenom, U.mail, U.tel_port, U.src_photo, F.type_fonction, F.annee_debut, F.actif, LC.categorie, LC.type, LC.numero 
			FROM 
				utilisateurs AS U, fonctions AS F, liste_categories AS LC
			WHERE 
				U.id = F.id_membre_bureau 
				AND F.categorie = LC.id 
				".$where."
			ORDER BY F.type_fonction, LC.ordre, U.nom
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['id'] = $d['id'];
				$tab['nom'] = $d['nom'];
				$tab['prenom'] = $d['prenom'];
				$tab['mail'] = $d['mail'];
				$tab['tel_port'] = ($d['tel_port']!=0)?$d['tel_port']:'06 ** ** ** **';
				$verifChemin = file_exists('image/photo_'. $d['id'] .'.png');
				$tab['src_photo'] = (!empty($d['src_photo']) && $d['src_photo'] && $verifChemin)? 'photo_'. $d['id'] .'.png' : 'inconnu.gif';
				$tab['annee_debut'] = (!empty($d['annee_debut']))?$d['annee_debut']:'20**';
				$fonction = (!empty($d['numero'])) ? $d['type'].' '.$d['numero'] : $d['type'];
				$tab['fonction'] = (!empty($d['type'])) ? $d['categorie'] .' '. $fonction : $d['categorie'];
				$tab['type'] = $d['type_fonction'];
				$tab['actif'] = $d['actif'];
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/******************************
	**
	** Liste des types de fonctions
	** 
	** Entrée : (Void)
	** Sortie : (Array) 
	**
	******************************/
	
	function liste_organigramme_types() {
		$liste = array();
		
		$maReq = "
			SELECT 
				F.type_fonction
			FROM 
				fonctions AS F
			GROUP BY F.type_fonction
			ORDER BY F.type_fonction
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$liste[] = $d['type_fonction'];
			}
			return $liste;
		}
		else
			return false;
	}
	
	/******************************
	**
	** Liste des fonctions de fonctions
	** 
	** Entrée : (Void)
	** Sortie : (Array) 
	**
	******************************/
	
	function liste_organigramme_fonctions() {
		$tab = array();
		$liste = array();
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero
			FROM 
				liste_categories AS LC
			ORDER BY LC.ordre
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$fonction = (!empty($d['numero'])) ? $d['type'].' '.$d['numero'] : $d['type'];
				$liste[] = (!empty($d['type'])) ? $d['categorie'] .' '. $fonction : $d['categorie'];
			}
			return $liste;
		}
		else
			return false;
	}
	
	/******************************
	**
	** Liste des utilisateurs
	** 
	** Entrée : (Void)
	** Sortie : (Array) 
	**
	******************************/
	
	function liste_utilisateurs($num_page = 1, $nb_par_page = 25) {
		$liste = array();
		$tab = array();
		$num_page = (($num_page-1)*$nb_par_page);

		$maReq = "
			SELECT 
				*
			FROM 
				utilisateurs AS U
			ORDER BY
				U.nom
			LIMIT
				".$num_page.", ".$nb_par_page."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['id'] = $d['id'];
				$tab['nom'] = $d['nom'];
				$tab['prenom'] = $d['prenom'];
				$tab['mail'] = $d['mail'];
				$tab['rang'] = $d['rang'];
				$tab['actif'] = $d['actif'];
				$tab['tel_port'] = ($d['tel_port']!=0)?$d['tel_port']:'06 ** ** ** **';
				$verifChemin = file_exists('images/photos/photo_'. $d['id'] .'.png');
				$tab['src_photo'] = (!empty($d['src_photo']) && $d['src_photo'] && $verifChemin)? 'photo_'. $d['id'] .'.png' : 'inconnu.gif';
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/***********************************
	**
	** Le nombre d'utilisateur retourné
	** 
	** Entrée : (Void)
	** Sortie : (Array) 
	**
	***********************************/
	
	function nbr_utilisateurs() {

		$maReq = "
			SELECT 
				COUNT(id)
			FROM 
				utilisateurs
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		return $d['COUNT(id)'];
	}
	
	/***********************************
	**
	** Le nombre de joueur retourné
	** 
	** Entrée : (Void)
	** Sortie : (Array) 
	**
	***********************************/
	
	function nbr_joueurs() {

		$maReq = "
			SELECT 
				COUNT(id)
			FROM 
				joueurs
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		return $d['COUNT(id)'];
	}
	
	/*******************************************************
	**
	** Liste des matchs à venir dans les 7 jours
	** 
	** Entrée : (String) Date / (Int) Limite / (bool) Ordre
	** Sortie : (Array) 
	**
	********************************************************/
	
	function liste_matchs_a_venir($date, $limite=15, $ordre=0) {
		$liste = array();
		$date_plus_7J = date_plus_7J($date);
		global $mois_de_lannee;
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, LC.raccourci, C.id as id_match, C.date, C.heure, C.adversaire1, C.adversaire2, C.adversaire3, C.journee, C.lieu, C.gymnase, C.table, C.tour, C.arbitre, C.classement, LCo.id AS id_compet, LCo.nom AS nom_compet, LN.id AS id_niveau, LN.nom AS nom_niveau
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN
			WHERE 
				C.categorie = LC.id 
				AND C.date >= '".$date."' 
				AND C.date < '".$date_plus_7J."' 
				AND C.joue = 0
				AND C.compet = LCo.id
				AND C.niveau = LN.id
			ORDER BY C.date, C.heure, LC.ordre
			LIMIT 0, ".$limite."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['id'] = $d['id_match'];
				if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
				if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
				$tab['raccourci'] = $d['raccourci'];
				
				$tab['annee'] = substr($d['date'], 0, 4);
				$tab['mois'] = substr($d['date'], 4, 2);
				$tab['jour'] = substr($d['date'], 6, 2);
				$tab['newDate'] = $tab['jour'].' '.$mois_de_lannee[$tab['mois']-1];
				$tab['newHeure'] = remplace_heure($d['heure']);
				
				$tab['img_competition'] = "competition_". $d['id_compet'] ."_". $d['id_niveau'];
				
				$tab['competition'] = $d['nom_compet'];
				$tab['competition'] .= ($d['journee']!=0)?'<br/>Journée '.$d['journee']:'';
				$tab['competition'] .= ($d['tour']!='')?'<br/>'.$d['tour']:'';
				
				$tab['adversaire'] = ($d['adversaire3'] != '')?$d['adversaire2'].'<br/>'.$d['adversaire3']:$d['adversaire2'];
				$tab['adversaire'] = ($d['adversaire2'] != '')?$d['adversaire1'].'<br/>'.$tab['adversaire']:$d['adversaire1'];
				
				switch($d['lieu']) {
					case 0:
						$tab['dom_ext'] = 'Dom';
					break;
					case 1:
						$tab['dom_ext'] = 'Ext';
					break;
					case 2:
					default:
						$tab['dom_ext'] = 'Neu';
					break;
				}
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/*********************************
	**
	** Liste des matchs à venir export
	** 
	** Entrée : (String) Date
	** Sortie : (Array) 
	**
	*********************************/
	
	function liste_matchs_a_venir_exp($date) {
		$liste = array();
		$date_plus_7J = date_plus_7J($date);
		global $mois_de_lannee;
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, LC.raccourci, C.id as id_match, C.date, C.heure, C.adversaire1, C.adversaire2, C.adversaire3, C.journee, C.lieu, C.gymnase, C.table, C.tour, C.arbitre, C.classement, LCo.id AS id_compet, LCo.nom AS nom_compet, LN.id AS id_niveau, LN.nom AS nom_niveau
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN
			WHERE 
				C.categorie = LC.id 
				AND C.date >= '".$date."' 
				AND C.date < '".$date_plus_7J."' 
				AND C.joue = 0
				AND C.compet = LCo.id
				AND C.niveau = LN.id
			ORDER BY C.lieu, C.date, SUBSTR(C.heure, 1, 2), SUBSTR(C.heure, 3, 2), LC.ordre
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['id'] = $d['id_match'];
				if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
				if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
				$tab['categorie'] = $d['cat'];
				
				$tab['annee'] = substr($d['date'], 0, 4);
				$tab['mois'] = substr($d['date'], 4, 2);
				$tab['jour'] = substr($d['date'], 6, 2);
				$tab['newDate'] = $tab['jour'].' '.$mois_de_lannee[$tab['mois']-1];
				$tab['newHeure'] = remplace_heure($d['heure']);
				
				$tab['compet'] = $d['nom_compet'];
				
				$tab['adversaire1'] = $d['adversaire1'];
				$tab['adversaire2'] = $d['adversaire2'];
				$tab['adversaire3'] = $d['adversaire3'];
				
				$tab['lieu'] = $d['lieu'];
				
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/*******************************************************
	**
	** Liste des matchs par jour de match dans les 7 jours
	** 
	** Entrée : (String) Date / (Int) Limite / (bool) Ordre
	** Sortie : (Array) 
	**
	********************************************************/
	
	function liste_matchs_par_jour($date, $limite=15, $ordre=0) {
		$liste = array();
		$date_plus_7J = date_plus_7J($date);
		global $mois_de_lannee;
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, LC.raccourci, C.date, C.heure, C.adversaire1, C.adversaire2, C.adversaire3, C.journee, C.lieu, C.gymnase, C.table, C.tour, C.arbitre, C.classement, LCo.id AS id_compet, LCo.nom AS nom_compet, LN.id AS id_niveau, LN.nom AS nom_niveau
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN
			WHERE 
				C.categorie = LC.id 
				AND C.date >= '".$date."' 
				AND C.date < '".$date_plus_7J."' 
				AND C.joue = 0
				AND C.compet = LCo.id
				AND C.niveau = LN.id
			ORDER BY LC.ordre, C.date, SUBSTR(C.heure, 1, 2), SUBSTR(C.heure, 3, 2)
			LIMIT 0, ".$limite."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {				
				$tab['raccourci'] = $d['raccourci'];
				
				$mois = substr($d['date'], 4, 2);
				$jour = substr($d['date'], 6, 2);
				$tab['newDate'] = $jour.' '.substr($mois_de_lannee[$mois-1], 0, 3);
				$H = substr($d['heure'], 0, 2);
				$M = substr($d['heure'], 2, 2);
				if($M == '') $M = '00';
				$dateTotal = $d['date'].$H.$M;
				
				if($dateTotal > 201209292135) {
					$tab['info_match'] = "<img src='images/a_venir.png' alt='A_venir' title='A venir'/>";
				}
				elseif($dateTotal+200 > 201209292135 && $dateTotal < 201209292135) {
					$tab['info_match'] = "<img src='images/en_cours.png' alt='En_cours' title='En cours'/>";
				}
				else {
					$tab['info_match'] = "<img src='images/terminee.png' alt='Terminée' title='Terminée'/>";
				}
				
				$tab['lieu'] = $d['lieu'];
				for($i=1; $i<=3; $i++) {
					if($d['adversaire'.$i] != '') {
						$tab['score'] = $d['score_dom'.$i]."<br/>".$d['score_ext'.$i];
						$tab['adversaire'] = $d['adversaire'.$i];
						$liste[] = $tab;
					}
					else
						break;
				}				
			}
			return $liste;
		}
		else
			return false;
	}
	
	/************************************************************
	**
	** Liste des résultats de matchs datant des derniers 7 jours
	** 
	** Entrée : (String) Date, (Int) Limite
	** Sortie : (Array) 
	**
	*************************************************************/
	
	function liste_resultats_semaine($date, $limite=15) {
		$liste = array();
		$date_moins_7J = date_moins_7J($date);
		global $mois_de_lannee;
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, LC.raccourci, C.date, C.heure, C.adversaire1, C.adversaire2, C.adversaire3, C.lieu, C.gymnase, C.table, C.journee, C.tour, C.score_dom1, C.score_ext1, C.score_dom2, C.score_ext2, C.score_dom3, C.score_ext3, C.joue, C.arbitre, C.classement, LCo.id AS id_compet, LCo.nom AS nom_compet, LN.id AS id_niveau, LN.nom AS nom_niveau
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN
			WHERE 
				C.categorie = LC.id 
				AND C.date < '".$date."' 
				AND C.date > '".$date_moins_7J."' 
				AND joue = 1
				AND C.compet = LCo.id
				AND C.niveau = LN.id
			ORDER BY C.date, SUBSTR(C.heure, 1, 2), SUBSTR(C.heure, 3, 2), LC.ordre
			LIMIT 0, ". $limite ."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
				if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
				$d['annee'] = substr($d['date'], 0, 4);
				$d['mois'] = substr($d['date'], 4, 2);
				$d['jour'] = substr($d['date'], 6, 2);
				
				$d['newDate'] = $d['jour'].' '.$mois_de_lannee[$d['mois']-1];
				
				$d['newHeure'] = remplace_heure($d['heure']);
				
				$d['img_competition'] = "competition_". $d['id_compet'] ."_". $d['id_niveau'];
				
				$d['competition'] = $d['nom_compet'];
				$d['competition'] .= ($d['journee']!=0)?'<br/>Journée '.$d['journee']:'';
				$d['competition'] .= ($d['tour']!='')?'<br/>'.$d['tour']:'';
				
				$d['adversaire'] = ($d['adversaire3'] != '')?$d['adversaire2'].'<br/>'.$d['adversaire3']:$d['adversaire2'];
				$d['adversaire'] = ($d['adversaire2'] != '')?$d['adversaire1'].'<br/>'.$d['adversaire']:$d['adversaire1'];
				
				$d['score'] = '';
				
				for($i=1; $i<=3; $i++) {
					if($d['score_dom'.$i] != 0 || $d['score_ext'.$i] != 0) {
						switch($d['lieu']) {
							case 0:
								$d['dom_ext'] = 'D';
								if($d['score_dom'.$i]>$d['score_ext'.$i])
									$couleur = 'vert';
								elseif($d['score_dom'.$i]<$d['score_ext'.$i])
									$couleur = 'rouge';
								else
									$couleur = 'orange';
							break;
							case 1:
								$d['dom_ext'] = 'E';
								if($d['score_dom'.$i]<$d['score_ext'.$i])
									$couleur = 'vert';
								elseif($d['score_dom'.$i]>$d['score_ext'.$i])
									$couleur = 'rouge';
								else
									$couleur = 'orange';
							break;
							case 2:
							default:
								$d['dom_ext'] = 'N';
								if($d['score_dom'.$i]>$d['score_ext'.$i])
									$couleur = 'vert';
								elseif($d['score_dom'.$i]<$d['score_ext'.$i])
									$couleur = 'rouge';
								else
									$couleur = 'orange';
							break;
						}
						$d['score'] .= '<strong class="'. $couleur .'">' .$d['score_dom'.$i].'-'.$d['score_ext'.$i]. '</strong><br/>';
					}
				}
				
				if(!$d['joue']) {
					$d['score'] = '-';
				}
				else {
					$d['score'] = substr($d['score'], 0, strlen($d['score'])-5);
				}
				
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	
	/*******************************************************
	**
	** Liste des matchs par jour de match dans les 7 jours
	** 
	** Entrée : (String) Date / (Int) Limite / (bool) Ordre
	** Sortie : (Array) 
	**
	********************************************************/
	
	function liste_matchs_jour($date) {
		$liste = array();
		$now = date('YmdHi');
		global $mois_de_lannee;
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, LC.raccourci, C.date, C.heure, C.adversaire1, C.adversaire2, C.adversaire3, C.journee, C.lieu, C.gymnase, C.table, C.tour, C.arbitre, C.classement, LCo.id AS id_compet, LCo.nom AS nom_compet, LN.id AS id_niveau, LN.nom AS nom_niveau
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN
			WHERE 
				C.categorie = LC.id 
				AND C.date = '".$date."'
				AND C.joue = 0
				AND C.compet = LCo.id
				AND C.niveau = LN.id
			ORDER BY LC.ordre, C.date, SUBSTR(C.heure, 1, 2), SUBSTR(C.heure, 3, 2)
			LIMIT 0, 8
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {				
				$mois = substr($d['date'], 4, 2);
				$jour = substr($d['date'], 6, 2);
				$tab['newDate'] = $jour.' '.substr($mois_de_lannee[$mois-1], 0, 3);
				$H = substr($d['heure'], 0, 2);
				$M = substr($d['heure'], 2, 2);
				if($M == '') $M = '00';
				$dateTotal = $d['date'].$H.$M;
				
				$tab['raccourci'] = $d['raccourci'];
				
				if($dateTotal > $now) {
					$tab['info_match'] = "<img src='images/a_venir.png' alt='A_venir' title='A venir'/>";
				}
				elseif($dateTotal+200 > $now && $dateTotal < $now) {
					$tab['info_match'] = "<img src='images/direct.png' alt='Direct' title='Direct'/>";
				}
				else {
					$tab['info_match'] = "<img src='images/terminee.png' alt='Terminée' title='Terminée'/>";
				}
				
				$tab['lieu'] = $d['lieu'];
				for($i=1; $i<=3; $i++) {
					if($d['adversaire'.$i] != '') {
						$tab['score'] = $d['score_dom'.$i]."<br/>".$d['score_ext'.$i];
						$tab['adversaire'] = $d['adversaire'.$i];
						$liste[] = $tab;
					}
					else
						break;
				}				
			}
			return $liste;
		}
		else
			return false;
	}
	
	/*******************************************************
	**
	** Liste des evènements par jour
	** 
	** Entrée : (String) Date
	** Sortie : (Array) 
	**
	********************************************************/
	
	function liste_event_jour($date) {
		$liste = array();
		$now = date('YmdHi');
		$annee = retourne_annee();
		global $mois_de_lannee;

		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, LC.raccourci, C.date, C.heure, C.adversaire1, C.adversaire2, C.adversaire3, C.journee, C.lieu, C.gymnase, C.table, C.tour, C.arbitre, C.classement, LCo.id AS id_compet, LCo.nom AS nom_compet, LN.id AS id_niveau, LN.nom AS nom_niveau, LCh.nom AS nom_championnat, E.championnat
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN, liste_championnat AS LCh, equipes AS E
			WHERE 
				C.categorie = LC.id 
				AND C.date = '".$date."'
				AND C.compet = LCo.id
				AND C.niveau = LN.id
				AND (E.championnat = LCh.id
					OR (E.championnat = 0 AND LCh.id = 1))
				AND E.categorie = C.categorie
				AND E.annee = ".$annee."
			ORDER BY SUBSTR(C.heure, 1, 2), SUBSTR(C.heure, 3, 2), LC.ordre
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['raccourci'] = $d['raccourci'];
				
				$numero = ($d['numero'] != 0) ? " ".$d['numero'] : "" ;
				$tab['equipe'] = $d['categorie']." ".$d['type'].$numero ;
				
				$tab['id_compet'] = $d['id_compet'];
				$tab['id_niveau'] = $d['id_niveau'];
				if($d['id_compet'] == 1)
					$tab['competition'] = $d['nom_compet'].' '.$d['nom_niveau'].' '.$d['nom_championnat'];
				elseif($d['id_compet'] == 4)
					$tab['competition'] = $d['nom_compet'].' '.$d['nom_niveau'];
				else
					$tab['competition'] = $d['nom_compet'];
				
				$H = substr($d['heure'], 0, 2);
				$M = substr($d['heure'], 2, 2);
				$tab['horaire'] = remplace_heure($H.$M);
				
				$tab['lieu'] = $d['lieu'];
				$tab['adversaire'] = "";
				
				$tab['journee'] = ($d['tour'] == '') ? "Journée ".$d['journee'] : $d['tour'];
				
				for($i=1; $i<=3; $i++) {
					if($d['adversaire'.$i] != '') {
						$tab['adversaire'] .= $d['adversaire'.$i]." / ";
						
					}
					else
						break;
				}
				$tab['adversaire'] = substr($tab['adversaire'], 0, -3);
				$liste[] = $tab;				
			}
			return $liste;
		}
		else
			return false;
	}
	
	/*********************************
	**
	** Retourne la photo d'une équipe
	** 
	** Entrée : (String) Categorie
	** Sortie : (Array) 
	**
	*********************************/
	
	function retournePhoto($cat) {
		
		if(idate('m')<7)
			$annee_actuelle = idate('Y')-1;
		else
			$annee_actuelle = idate('Y');
		
		$maReq = "
			SELECT 
				E.nom_photo, E.affiche_photo 
			FROM 
				liste_categories AS LCa, equipes AS E 
			WHERE 
				LCa.raccourci = '".$cat."'
				AND E.annee = ". $annee_actuelle ."
				AND E.categorie = LCa.id
			LIMIT 0,1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				if(!empty($d['nom_photo']) && $d['affiche_photo'])
					return "<img src='images/".$d['nom_photo']."' alt='". $cat ."' width='100%' />";
				else
					return "<img src='images/equipe_lambda.png' alt='". $cat ."' width='100%' />";
			}
		}
		return "Aucune photo ne correspond à cette catégorie.";
	}
	
	/*********************************
	**
	** Retourne la fiche d'une équipe
	** 
	** Entrée : (String) Categorie
	** Sortie : (Array) 
	**
	*********************************/
	
	function fiche_equipe($cat, $annee) {
		$liste = array();
		$id_membre_bureau = array();
		global $jours;
		global $gymnases;
		
		$entraineurs = '';
		$entrainement = '';
		
		$maReq = "
			SELECT 
				E.niveau AS niv, E.championnat AS champ, E.entraineur1, E.entraineur2, E.entrainement1, E.entrainement2 
			FROM 
				liste_categories AS LCa, equipes AS E 
			WHERE 
				E.categorie = LCa.id 
				AND LCa.raccourci = '".$cat."'
				AND E.annee = ". $annee ."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
			
				$niveau = retourneNiveauById($d['niv']);
				if($niveau === false) $niveau = '-';
				
				$championnat = retourneChampionnatById($d['champ']);
				if($championnat === false) $championnat = 'Délayage';
				
				$entraineur1 = retourneEntraineurById($d['entraineur1']);
				$entraineur2 = retourneEntraineurById($d['entraineur2']);
				if($entraineur1 !== false){
					$entraineurs .= $entraineur1['prenom'].' '.$entraineur1['nom'].'<br/>';
					$label_entraineurs = 'Entraineur';
				}
				if($entraineur2 !== false) {
					$entraineurs .= $entraineur2['prenom'].' '.$entraineur2['nom'].'<br/>';
					$label_entraineurs = 'Entraineurs';
				}
				if($entraineur1 === false && $entraineur2 === false) {
					$entraineurs = 'Non défini';
					$label_entraineurs = 'Entraineur';
				}
				
				$entrainement1 = retourneHoraireById($d['entrainement1']);
				$entrainement2 = retourneHoraireById($d['entrainement2']);
				if($entrainement1 !== false)
					$entrainement .= 'Le '.$jours[$entrainement1['jour']].' de '. remplace_heure($entrainement1['heure_debut']) .' &agrave; '. remplace_heure($entrainement1['heure_fin']) .'<br/>Gymnase ' .$gymnases[$entrainement1['gymnase']] .'<br/>';
				if($entrainement2 !== false)
					$entrainement .= 'Le '.$jours[$entrainement2['jour']].' de '. remplace_heure($entrainement2['heure_debut']) .' &agrave; '. remplace_heure($entrainement2['heure_fin']) .'<br/>Gymnase ' .$gymnases[$entrainement2['gymnase']];
				if($entrainement1 === false && $entrainement2 === false)
					$entrainement = 'Non défini';

				$liste_stats = liste_stats($cat, $annee);
				if(is_array($liste_stats)) {
					$bilan = '<span class="vert">'.$liste_stats['nb_vic'].'V</span> <span class="orange">'.$liste_stats['nb_nul'].'N</span> <span class="rouge">'.$liste_stats['nb_def'].'D</span>';
				}
			}
			
			$liste[] = array('Niveau', $niveau);
			$liste[] = array('Championnat', $championnat);
			$liste[] = array($label_entraineurs, substr($entraineurs, 0, strlen($entraineurs)-5));
			$liste[] = array('Horaires', $entrainement);
			$liste[] = array('Série', cinq_dernier_match($cat, $annee));
			$liste[] = array('Bilan', $bilan);
			return $liste;
		}
		else {
			$liste[] = array('Niveau', '-');
			$liste[] = array('Championnat', '-');
			$liste[] = array('Entraineurs', '-');
			$liste[] = array('Horaires', '-');
			$liste[] = array('Série', '-');
			$liste[] = array('Bilan', '-');
			return $liste;
		}
	}
	
	/********************************
	**
	** Liste les matchs d'une équipe
	** 
	** Entrée : (String) Categorie
	** Sortie : (Array) 
	**
	*********************************/
	
	function liste_matchs_par_equipe($cat, $annee=false) {
		$liste = array();
		global $mois_de_lannee;
		
		if($annee === false)
			$annee = date('Y');
		$annee_suiv = $annee+1;
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, C.id, C.date, C.heure, C.compet, C.niveau, C.adversaire1, C.adversaire2, C.adversaire3, C.lieu, C.gymnase, C.table, C.journee, C.tour, C.score_dom1, C.score_ext1, C.score_dom2, C.score_ext2, C.score_dom3, C.score_ext3, C.joue, C.arbitre, C.classement, LCo.id AS id_compet, LCo.nom AS nom_compet, LN.id AS id_niveau, LN.nom AS nom_niveau
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN
			WHERE 
				C.categorie = LC.id 
				AND LC.raccourci = '".$cat."'
				AND C.compet = LCo.id
				AND C.niveau = LN.id
				AND C.date > ". $annee ."0701
				AND C.date  <= ". $annee_suiv ."0701
			ORDER BY LC.ordre, C.date, SUBSTR(C.heure, 1, 2), SUBSTR(C.heure, 3, 2), C.journee
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				// Données retournées :
				// Date / Compétition / Images / Cat / Score / Adversaire(s) 
				
				if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
				if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
				$annee = substr($d['date'], 0, 4);
				$mois = (substr($d['date'], 4, 1) == 0)? substr($d['date'], 5, 1):substr($d['date'], 4, 2);
				$jour = substr($d['date'], 6, 2);
				$d['laDate'] = $jour.' '.substr($mois_de_lannee[$mois-1], 0, 3);
				$d['mois'] = $mois_de_lannee[$mois-1]." ".$annee;
				
				$d['newHeure'] = remplace_heure($d['heure']);
				
				$d['img_competition'] = "competition_". $d['compet'] ."_". $d['niveau'] ;
				
				$d['competition'] = $d['nom_compet'];
				$d['competition'] .= ($d['journee']!=0)?'<br/>Journée '.$d['journee']:'';
				$d['competition'] .= ($d['tour']!='')?'<br/>'.$d['tour']:'';
				
				$d['adversaire'] = ($d['adversaire3'] != '')?$d['adversaire2'].'<br/>'.$d['adversaire3']:$d['adversaire2'];
				$d['adversaire'] = ($d['adversaire2'] != '')?$d['adversaire1'].'<br/>'.$d['adversaire']:$d['adversaire1'];

				$d['score'] = '';
				
				for($i=1; $i<=3; $i++) {
					if($d['score_dom'.$i] != 0 || $d['score_ext'.$i] != 0) {
						switch($d['lieu']) {
							case 0:
								if($d['score_dom'.$i]>$d['score_ext'.$i])
									$couleur = 'vert';
								elseif($d['score_dom'.$i]<$d['score_ext'.$i])
									$couleur = 'rouge';
								else
									$couleur = 'orange';
							break;
							case 1:
								if($d['score_dom'.$i]<$d['score_ext'.$i])
									$couleur = 'vert';
								elseif($d['score_dom'.$i]>$d['score_ext'.$i])
									$couleur = 'rouge';
								else
									$couleur = 'orange';
							break;
							case 2:
							default:
								if($d['score_dom'.$i]>$d['score_ext'.$i])
									$couleur = 'vert';
								elseif($d['score_dom'.$i]<$d['score_ext'.$i])
									$couleur = 'rouge';
								else
									$couleur = 'orange';
							break;
						}
						$d['score'] .= '<span class="'. $couleur .'">' .$d['score_dom'.$i].'-'.$d['score_ext'.$i]. '</span><br/>';
					}
				}
				
				if(!$d['joue']) {
					$d['score'] = '-';
				}
				else {
					$d['score'] = substr($d['score'], 0, strlen($d['score'])-5);
				}
				
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/*****************************
	**
	** Liste des 5 derniers matchs
	** 
	** Entrée : (String) Equipe
	** Sortie : (Array) 
	**
	******************************/
	
	function cinq_dernier_match($rac, $annee) {
		$liste = array();
		$retour = '';
		$nbr_match = 0;
		$annee_suiv = $annee+1;
		
		$maReq = "
			SELECT 
				lieu, score_dom, score_ext
			FROM 
				matchs AS M, liste_categories AS LC
			WHERE 
				M.categorie = LC.id 
				AND LC.raccourci = '". $rac ."' 
				AND M.joue = 1
				AND M.date > ". $annee ."0701
				AND M.date  <= ". $annee_suiv ."0701
			ORDER BY M.date DESC, SUBSTR(M.heure, 1, 2) DESC, SUBSTR(M.heure, 3, 2) DESC
			LIMIT 0,5
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				for($i=1; $i<=3; $i++) {
					if($d['score_dom'.$i] != 0 || $d['score_ext'.$i] != 0) {
						switch($d['lieu']) {
							case 0:
								if($d['score_dom'.$i]>$d['score_ext'.$i])
									$retour = '<span class="vert">V</span> '.$retour;
								elseif($d['score_dom'.$i]<$d['score_ext'.$i])
									$retour = '<span class="rouge">D</span> '.$retour;
								else
									$retour = '<span class="orange">N</span> '.$retour;
							break;
							case 1:
								if($d['score_dom'.$i]<$d['score_ext'.$i])
									$retour = '<span class="vert">V</span> '.$retour;
								elseif($d['score_dom'.$i]>$d['score_ext'.$i])
									$retour = '<span class="rouge">D</span> '.$retour;
								else
									$retour = '<span class="orange">N</span> '.$retour;
							break;
							case 2:
							default:
								if($d['score_dom'.$i]>$d['score_ext'.$i])
									$retour = '<span class="vert">V</span> '.$retour;
								elseif($d['score_dom'.$i]<$d['score_ext'.$i])
									$retour = '<span class="rouge">D</span> '.$retour;
								else
									$retour = '<span class="orange">N</span> '.$retour;
							break;
						}
						$nbr_match++;
						if($nbr_match >= 5)
							break 2;
					}
				}
			}
			while($nbr_match < 5) {
				$retour = '- '.$retour;
				$nbr_match++;
			}
			return $retour;
		}
		else
			return "- - - - -";
	}
	
	/********************************
	**
	** Retourne le dernier match joué
	** 
	** Entrée : (String) Equipe
	** Sortie : (Array) 
	**
	*********************************/
	
	function dernier_match($equipe, $annee) {
		global $mois_de_lannee;
		$annee_suiv = $annee+1;
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, C.id AS id_match, C.date, C.heure, C.compet, C.niveau, C.adversaire1, C.adversaire2, C.adversaire3, C.lieu, C.gymnase, C.table, C.journee, C.tour, C.score_dom1, C.score_ext1, C.score_dom2, C.score_ext2, C.score_dom3, C.score_ext3, C.joue, C.arbitre, C.classement, LCo.id AS id_compet, LCo.nom AS nom_compet, LN.id AS id_niveau, LN.nom AS nom_niveau
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN
			WHERE 
				C.categorie = LC.id 
				AND LC.raccourci = '".$equipe."' 
				AND C.date > ". $annee ."0701
				AND C.date  <= ". $annee_suiv ."0701
				AND C.date  <= ". date('Ymd') ."
				AND C.joue = 1
				AND C.compet = LCo.id
				AND C.niveau = LN.id
				
			ORDER BY C.date DESC, SUBSTR(C.heure, 1, 2) DESC, SUBSTR(C.heure, 3, 2) DESC
			LIMIT 0,1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			$d = mysql_fetch_array($q);
			// Données retournées :
			// Date / Compétition / Images / Cat/ Score  / Adversaire(s) 
			
			if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
			if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
			$annee = substr($d['date'], 0, 4);
			$mois = (substr($d['date'], 4, 1) == 0)? substr($d['date'], 5, 1):substr($d['date'], 4, 2);
			$jour = substr($d['date'], 6, 2);
			$d['laDate'] = $jour.' '.substr($mois_de_lannee[$mois-1], 0, 3);
			$d['mois'] = $mois_de_lannee[$mois-1]." ".$annee;
			
			$d['img_competition'] = "competition_". $d['compet'] ."_". $d['niveau'] ;
			
			$d['competition'] = $d['nom_compet'] ." ". $d['nom_niveau'];
			$d['competition'] .= ($d['journee']!=0)?'<br/>Journée '.$d['journee']:'';
			$d['competition'] .= ($d['tour']!='')?'<br/>'.$d['tour']:'';
			
			$d['adversaire'] = ($d['adversaire3'] != '')?'<span>'.$d['adversaire2'].'</span><br/><span>'.$d['adversaire3'].'</span>':'<span>'.$d['adversaire2'].'</span>';
			$d['adversaire'] = ($d['adversaire2'] != '')?'<span>'.$d['adversaire1'].'</span><br/>'.$d['adversaire']:'<span>'.$d['adversaire1'].'</span>';

			$d['images'] = '';
			$d['score'] = '';
			
			for($i=1; $i<=3; $i++) {
				if($d['score_dom'.$i] != 0 || $d['score_ext'.$i] != 0) {
					switch($d['lieu']) {
						case 0:
							if($d['score_dom'.$i]>$d['score_ext'.$i])
								$couleur = 'vert';
							elseif($d['score_dom'.$i]<$d['score_ext'.$i])
								$couleur = 'rouge';
							else
								$couleur = 'orange';
						break;
						case 1:
							if($d['score_dom'.$i]<$d['score_ext'.$i])
								$couleur = 'vert';
							elseif($d['score_dom'.$i]>$d['score_ext'.$i])
								$couleur = 'rouge';
							else
								$couleur = 'orange';
						break;
						case 2:
						default:
							if($d['score_dom'.$i]>$d['score_ext'.$i])
								$couleur = 'vert';
							elseif($d['score_dom'.$i]<$d['score_ext'.$i])
								$couleur = 'rouge';
							else
								$couleur = 'orange';
						break;
					}						
					$d['score'] .= '<strong class="'. $couleur .'">' .$d['score_dom'.$i].'-'.$d['score_ext'.$i]. '</strong><br/>';
				}
			}
			
			if(!$d['joue']) {
				$d['score'] = '-';
			}
			else {
				$d['score'] = substr($d['score'], 0, strlen($d['score'])-5) ;
			}
			
			return $d;
		}
		else
			return false;
	}
	
	/****************************
	**
	** Retourne le match à venir
	** 
	** Entrée : (String) Equipe
	** Sortie : (Array) 
	**
	****************************/
	
	function prochain_match($equipe, $annee) {
		global $mois_de_lannee;
		$annee_suiv = $annee+1;
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, C.id AS id_match, C.date, C.heure, C.compet, C.niveau, C.adversaire1, C.adversaire2, C.adversaire3, C.lieu, C.gymnase, C.table, C.journee, C.tour, C.score_dom1, C.score_ext1, C.score_dom2, C.score_ext2, C.score_dom3, C.score_ext3, C.joue, C.arbitre, C.classement, LCo.id AS id_compet, LCo.nom AS nom_compet, LN.id AS id_niveau, LN.nom AS nom_niveau
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN
			WHERE 
				C.categorie = LC.id 
				AND LC.raccourci = '".$equipe."' 
				AND C.joue = 0
				AND C.date  > ". date('Ymd') ."
				AND C.date > ". $annee ."0701
				AND C.date  <= ". $annee_suiv ."0701
				AND C.compet = LCo.id
				AND C.niveau = LN.id
			ORDER BY C.date, C.heure
			LIMIT 0,1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			$d = mysql_fetch_array($q);
			// Données retournées :
			// Date / Compétition / Images / Cat/ Score  / Adversaire(s) 
			
			if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
			if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
			$annee = substr($d['date'], 0, 4);
			$mois = (substr($d['date'], 4, 1) == 0)? substr($d['date'], 5, 1):substr($d['date'], 4, 2);
			$jour = substr($d['date'], 6, 2);
			$d['laDate'] = $jour.' '.substr($mois_de_lannee[$mois-1], 0, 3);
			$d['lHeure'] = ($d['heure'] != 0)?remplace_heure($d['heure']):'';
			
			$d['img_competition'] = "competition_". $d['nom_compet'] ."_". $d['nom_niveau'] ;
			
			$d['competition'] = $d['nom_compet'] ." ". $d['nom_niveau'];
			$d['competition'] .= ($d['journee']!=0)?'<br/>Journée '.$d['journee']:'';
			$d['competition'] .= ($d['tour']!='')?'<br/>'.$d['tour']:'';
			
			switch($compet) {
				case 'Amical':
					$d['nbr_joueurs_max'] = 25;
				break;
				case 'Coupe de France':
					$d['nbr_joueurs_max'] = 14;
				break;
				case 'Coupe des Yvelines':
				case 'Délayage Régional':
				case 'Délayage Départemental':
				case 'Championnat':
				default:
					$d['nbr_joueurs_max'] = 12;
				break;
			}
			
			$d['adversaire'] = ($d['adversaire3'] != '')?$d['adversaire2'].'<br/>'.$d['adversaire3']:$d['adversaire2'];
			$d['adversaire'] = ($d['adversaire2'] != '')?$d['adversaire1'].'<br/>'.$d['adversaire']:$d['adversaire1'];

			$d['score'] = '';
			
			for($i=1; $i<=3; $i++) {
				if($d['score_dom'.$i] != 0 && $d['score_ext'.$i] != 0) {
					switch($d['lieu']) {
						case 0:
							if($d['score_dom'.$i]>$d['score_ext'.$i])
								$couleur = 'vert';
							elseif($d['score_dom'.$i]<$d['score_ext'.$i])
								$couleur = 'rouge';
							else
								$couleur = 'orange';
						break;
						case 1:
							if($d['score_dom'.$i]<$d['score_ext'.$i])
								$couleur = 'vert';
							elseif($d['score_dom'.$i]>$d['score_ext'.$i])
								$couleur = 'rouge';
							else
								$couleur = 'orange';
						break;
						case 2:
						default:
							if($d['score_dom'.$i]>$d['score_ext'.$i])
								$couleur = 'vert';
							elseif($d['score_dom'.$i]<$d['score_ext'.$i])
								$couleur = 'rouge';
							else
								$couleur = 'orange';
						break;
					}
					$d['score'] .= '<strong class="'. $couleur .'">' .$d['score_dom'.$i].'-'.$d['score_ext'.$i]. '</strong><br/>';
				}
			}
			
			if(!$d['joue']) {
				$d['score'] = '-';
			}
			else {
				$d['score'] = substr($d['score'], 0, strlen($d['score'])-5);
			}
			return $d;
		}
		else
			return false;
	}

	/****************************
	**
	** Retourne les matchs à venir
	** 
	** Entrée : (String) Equipe
	** Sortie : (Array) 
	**
	****************************/
	
	function listeProchainsMatchs() {
		global $mois_de_lannee;
		$tab = array();
		$tableau = array();
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, LC.raccourci, C.id AS id_match, C.date, C.heure, C.compet, C.niveau, C.adversaire1, C.adversaire2, C.adversaire3, C.lieu, C.gymnase, C.table, C.journee, C.tour, C.score_dom1, C.score_ext1, C.score_dom2, C.score_ext2, C.score_dom3, C.score_ext3, C.joue, C.arbitre, C.classement, LCo.id AS id_compet, LCo.nom AS nom_compet, LN.id AS id_niveau, LN.nom AS nom_niveau
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN
			WHERE 
				C.categorie = LC.id 
				AND C.joue = 0
				AND C.date  >= ". date('Ymd') ."
				AND C.date  <= ". date_plus_7J(date('Ymd')) ."
				AND C.compet = LCo.id
				AND C.niveau = LN.id
			ORDER BY C.date, C.heure
			LIMIT 0,10
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {

				$tab['raccourci'] = $d['raccourci'];
				$mois = (substr($d['date'], 4, 1) == 0) ? substr($d['date'], 5, 1) : substr($d['date'], 4, 2);
				$tab['mois'] = substr($mois_de_lannee[$mois-1], 0, 3);
				$tab['jour'] = substr($d['date'], 6, 2);
				$tab['lHeure'] = ($d['heure'] != 0)?remplace_heure($d['heure']):'';
				
				$tab['nom_compet'] = $d['nom_compet'];
				
				$tab['adversaire'] = ($d['adversaire3'] != '') ? $d['adversaire2'].'<br/>'.$d['adversaire3'] : $d['adversaire2'];
				$tab['adversaire'] = ($d['adversaire2'] != '') ? $d['adversaire1'].'<br/>'.$tab['adversaire'] : $d['adversaire1'];

				$tab['lieu'] = $d['lieu'];
				
				$tableau[] = $tab;

			}

			return $tableau;
		}
		else
			return false;
	}
	
	/*********************************************
	**
	** Liste les statistiques de l'année passée
	** 
	** Entrée : (String) rac, (Int) annee
	** Sortie : (Array) 
	**
	*********************************************/
	
	function liste_stats($rac, $annee) {
		$liste = array('nb_vic' => 0, 'nb_nul' => 0, 'nb_def' => 0, 'nb_bp' => 0, 'nb_bc' => 0);
		$annee_actuelle = $annee + 1;
		$maReq = "
			SELECT 
				*
			FROM 
				calendrier AS C, liste_categories AS LC
			WHERE 
				C.categorie = LC.id 
				AND LC.raccourci = '".$rac."'
				AND C.date >= ".$annee."0701
				AND C.date < ".$annee_actuelle."0701
				AND C.compet != 5
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				for($i=1; $i<=3; $i++) {
					if($d['score_dom'.$i] != 0 && $d['score_ext'.$i] != 0) {
						switch($d['lieu']) {
							case 0:
								if($d['score_dom'.$i]>$d['score_ext'.$i]) {
									$liste['nb_vic']++;
									$liste['nb_bp'] += $d['score_dom'.$i];
									$liste['nb_bc'] += $d['score_ext'.$i];
								}
								elseif($d['score_dom'.$i]<$d['score_ext'.$i]) {
									$liste['nb_def']++;
									$liste['nb_bp'] += $d['score_dom'.$i];
									$liste['nb_bc'] += $d['score_ext'.$i];
								}
								else {
									$liste['nb_nul']++;
									$liste['nb_bp'] += $d['score_dom'.$i];
									$liste['nb_bc'] += $d['score_ext'.$i];
								}
							break;
							case 1:
								if($d['score_dom'.$i]<$d['score_ext'.$i]) {
									$liste['nb_vic']++;
									$liste['nb_bc'] += $d['score_dom'.$i];
									$liste['nb_bp'] += $d['score_ext'.$i];
								}
								elseif($d['score_dom'.$i]>$d['score_ext'.$i]) {
									$liste['nb_def']++;
									$liste['nb_bc'] += $d['score_dom'.$i];
									$liste['nb_bp'] += $d['score_ext'.$i];
								}
								else {
									$liste['nb_nul']++;
									$liste['nb_bc'] += $d['score_dom'.$i];
									$liste['nb_bp'] += $d['score_ext'.$i];
								}
							break;
							case 2:
							default:
								if($d['score_dom'.$i]>$d['score_ext'.$i]) {
									$liste['nb_vic']++;
									$liste['nb_bc'] += $d['score_dom'.$i];
									$liste['nb_bp'] += $d['score_ext'.$i];
								}
								elseif($d['score_dom'.$i]<$d['score_ext'.$i]) {
									$liste['nb_def']++;
									$liste['nb_bc'] += $d['score_dom'.$i];
									$liste['nb_bp'] += $d['score_ext'.$i];
								}
								else {
									$liste['nb_nul']++;
									$liste['nb_bc'] += $d['score_dom'.$i];
									$liste['nb_bp'] += $d['score_ext'.$i];
								}
							break;
						}
					}
				}
			}
			return $liste;
		}
		else
			return false;
	}
	
	/***************************************
	**
	** Récupère la catégorie par l'id_match
	** 
	** Entrée : (Int) id_match
	** Sortie : (Array) 
	**
	***************************************/
	
	function recupCatByIdMatch($id_match) {
		$maReq = "
			SELECT 
				 LC.raccourci
			FROM 
				calendrier AS C, liste_categories AS LC
			WHERE 
				C.categorie = LC.id 
				AND C.id = '".$id_match."'
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			$d = mysql_fetch_array($q);
			
			return $d['raccourci'];
		}
		else
			return false;
	}
	
	function liste_joueurs($num_page = 1, $nb_par_page = 25) {
		$liste = array();
		$tab = array();
		$now = date('Ymd', time());
		$num_page = (($num_page-1)*$nb_par_page);
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, U.nom, U.prenom, U.src_photo, J.id_utilisateur, J.numero AS num, J.date_de_naissance, J.annee_arrivee, LP.poste, J.actif AS actif
			FROM 
				joueurs AS J, utilisateurs AS U, liste_categories AS LC, liste_poste AS LP
			WHERE 
				U.id = J.id_utilisateur
				AND J.categorie = LC.id 
				AND LP.id = J.poste
			ORDER BY
				LP.id, U.nom, U.prenom
			LIMIT
				".$num_page.", ".$nb_par_page."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
				if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
				if($d['date_de_naissance'] != 0) {
					$date_de_naissance =  $now - $d['date_de_naissance'];
					$d['age'] = substr($date_de_naissance, 0, 2)." ans";
				}
				else
					$d['age'] = "-";
				$d['nom'] = strtoupper($d['nom']);
				
				if($d['src_photo']) {
					$d['affiche_photo'] = 'oui';
					$nomPhoto = strtolower(stripAccents($d['prenom'].'_'.$d['nom']));
					$extension = 'png';
				}
				else {
					$d['affiche_photo'] = 'non';
					$nomPhoto = 'inconnu';
					$extension = 'gif';
				}
				
				$d['photo'] = '<img src="images/'. $nomPhoto .'.'. $extension .'" alt="'. $nomPhoto .'" width="102px">';
				
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	function liste_joueurs_par_equipe($equipe, $annee) {
		$liste = array();
		$now = date('Ymd', time());
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, U.nom, U.prenom, U.src_photo, J.numero AS num, J.date_de_naissance, J.annee_arrivee, LP.poste
			FROM 
				joueurs AS J, utilisateurs AS U, liste_categories AS LC, liste_poste AS LP
			WHERE 
				U.id = J.id_utilisateur
				AND J.categorie = LC.id 
				AND LP.id = J.poste
				AND LC.raccourci = '".$equipe."' 
				AND J.actif = 1
			ORDER BY LP.id, U.nom, U.prenom
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
				if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
				if($d['date_de_naissance'] != 0) {
					$date_de_naissance =  $now - $d['date_de_naissance'];
					$d['age'] = substr($date_de_naissance, 0, 2)." ans";
				}
				else
					$d['age'] = "-";
				$d['nom'] = strtoupper($d['nom']);
				
				if($d['src_photo']) {
					$d['affiche_photo'] = 'oui';
					$nomPhoto = strtolower(stripAccents($d['prenom'].'_'.$d['nom']));
					$extension = 'png';
				}
				else {
					$d['affiche_photo'] = 'non';
					$nomPhoto = 'inconnu';
					$extension = 'gif';
				}
				
				$d['photo'] = '<img src="images/'. $nomPhoto .'.'. $extension .'" alt="'. $nomPhoto .'" width="102px">';
				
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	function liste_matchs_coupe($num_compet, $annee) {
		$liste = array();
		global $mois_de_lannee;
		$annee_suiv = $annee + 1;
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, C.date, C.heure, C.competition, C.compet, C.niveau, C.adversaire1, C.adversaire2, C.adversaire3, C.lieu, C.gymnase, C.table, C.journee, C.tour, C.score_dom1, C.score_ext1, C.score_dom2, C.score_ext2, C.score_dom3, C.score_ext3, C.joue, C.arbitre, C.classement
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN
			WHERE 
				C.categorie = LC.id 
				AND C.compet = ".$num_compet."
				AND C.compet = LCo.id
				AND C.niveau = LN.id
				AND C.date > ". $annee ."0701
				AND C.date  <= ". $annee_suiv ."0701
			ORDER BY LC.ordre, C.date, C.heure
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
				if(!empty($d['type'])) $tab['cat'] = $d['categorie'].' '.$d['type'];
				
				$tab['mois'] = substr($d['date'], 4, 2);
				$tab['jour'] = substr($d['date'], 6, 2);
				$tab['newDate'] = $tab['jour'].' '.substr($mois_de_lannee[$tab['mois']-1], 0, 3);
				$tab['newHeure'] = remplace_heure($d['heure']);
				
				$tab['adversaire'] = ($d['adversaire3'] != '')?$d['adversaire2'].'<br/>'.$d['adversaire3']:$d['adversaire2'];
				$tab['adversaire'] = ($d['adversaire2'] != '')?$d['adversaire1'].'<br/>'.$tab['adversaire']:$d['adversaire1'];
				$tab['tour'] = $d['tour'];
				$tab['images'] = '';
				
				$tab['score'] = '';
				
				for($i=1; $i<=3; $i++) {
					if($d['score_dom'.$i] != 0 && $d['score_ext'.$i] != 0) {
						switch($d['lieu']) {
							case 0:
								$tab['dom_ext'] = 'D';
								if($d['score_dom'.$i]>$d['score_ext'.$i])
									$couleur = 'vert';
								elseif($d['score_dom'.$i]<$d['score_ext'.$i])
									$couleur = 'rouge';
								else
									$couleur = 'orange';
							break;
							case 1:
								$tab['dom_ext'] = 'E';
								if($d['score_dom'.$i]<$d['score_ext'.$i])
									$couleur = 'vert';
								elseif($d['score_dom'.$i]>$d['score_ext'.$i])
									$couleur = 'rouge';
								else
									$couleur = 'orange';
							break;
							case 2:
							default:
								$tab['dom_ext'] = 'N';
								if($d['score_dom'.$i]>$d['score_ext'.$i])
									$couleur = 'vert';
								elseif($d['score_dom'.$i]<$d['score_ext'.$i])
									$couleur = 'rouge';
								else
									$couleur = 'orange';
							break;
						}
						$tab['score'] .= '<strong class="'. $couleur .'">' .$d['score_dom'.$i].'-'.$d['score_ext'.$i]. '</strong><br/>';
					}
				}
				
				if(!$d['joue']) {
					$tab['score'] = '-';
				}
				else {
					$tab['score'] = substr($tab['score'], 0, strlen($tab['score'])-5);
				}
				
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	function liste_calendrier($filtres, $annee) {
		global $mois_de_lannee;
		$liste = array();
		$annee_suiv = $annee + 1;
		
		$where = "";
		$order = "ORDER BY C.date, C.heure , LC.ordre";

		if(!empty($filtres)) {
			if(isset($filtres['competition']))
				$where .= " AND C.compet = ".$filtres['competition'];
			if(isset($filtres['categorie'])) {
				$where .= " AND C.categorie = ".$filtres['categorie'];
				$order = "ORDER BY C.date DESC, C.heure DESC, LC.ordre";
			}
			if(isset($filtres['date']))
				$where .= " AND SUBSTR(C.date, -8, 6) = ".$filtres['date'];
		}
		else
			$where .= " AND C.joue = 0";
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, C.id, C.date, C.heure, C.compet, C.niveau, C.adversaire1, C.adversaire2, C.adversaire3, C.lieu, C.gymnase, C.adresse, C.ville, C.code_postal, C.table, C.journee, C.tour, C.score_dom1, C.score_ext1, C.score_dom2, C.score_ext2, C.score_dom3, C.score_ext3, C.joue, C.arbitre, C.classement, LCo.id AS id_compet, LCo.nom AS nom_compet, LN.id AS id_niveau, LN.nom AS nom_niveau, LCh.nom AS nom_champ
			FROM 
				calendrier AS C, equipes AS E, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN, liste_championnat AS LCh
			WHERE 
				C.categorie = LC.id
				AND C.categorie = E.categorie
				AND C.compet = LCo.id
				AND E.niveau = LN.id
				AND (E.championnat = LCh.id
					OR (E.championnat = 0 AND LCh.id = 1))
				AND E.annee = ". $annee ."
				AND C.date >= ". $annee ."0701 
				AND C.date < ". $annee_suiv ."0701 
				". $where ."
			". $order ." 
			LIMIT 0, 30
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
				if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
				$annee = substr($d['date'], 0, 4);
				$mois = substr($d['date'], 4, 2);
				$jour = substr($d['date'], 6, 2);
				$d['newDate'] = $jour.' '.substr($mois_de_lannee[$mois-1], 0, 3);
				$d['newDate'] .= ($d['heure']==0 || empty($d['heure']))?'':' à '.remplace_heure($d['heure']);
				
				$d['adversaire'] = ($d['adversaire3'] != '')?$d['adversaire2'].'<br/>'.$d['adversaire3']:$d['adversaire2'];
				$d['adversaire'] = ($d['adversaire2'] != '')?$d['adversaire1'].'<br/>'.$d['adversaire']:$d['adversaire1'];
				
				$d['img_competition'] = "competition_". $d['compet']."_". $d['niveau'] ;
				
				$d['competition'] = $d['nom_compet'];
				$d['competition'] .= ($d['journee']!=0)?'<br/>Journée '.$d['journee']:'';
				$d['competition'] .= ($d['tour']!='')?'<br/>'.$d['tour']:'';
				
				if($d['joue']) $d['etat'] = 'Joué'; else $d['etat'] = 'Non joué';
				
				$heure = ($d['heure']==0 || empty($d['heure']))?'0000':((strlen($d['heure'])==2)?$d['heure'].'00':$d['heure']);
				if($d['date'].$heure < date('YmdHi',time()+3600*6)) {
					if(!$d['joue']) {
						$date = "<span class='red'>La date du match est passée et le match n'est pas enregistré</span><br/>";
					}
				}
				else {
					$date ="Le match est à venir<br/>";
				}
				
				$gymnase = (empty($d['gymnase']))?"<span class='red'>Aucun gymnase enregistré</span><br/>":"";
				$adresse = (empty($d['adresse']) || empty($d['ville']) || empty($d['code_postal']))?"<span class='red'>Pas d'adresse enregistrée</span><br/>":"";
				$table = (empty($d['table']) && $d['lieu']==0)?"Pas de table enregistré<br/>":"";
				$arbitre = (empty($d['arbitre']))?"<span class='red'>Pas d'arbitre enregistré</span><br/>":"";
				$classement = (empty($d['classement']))?"Pas de classement associé<br/>":"";
				$termine = "<span class='vert'>Terminé</span><br/>";
				if($d['date'].$heure < date('YmdHi',time()+3600*6)) {
					if($d['joue']) {
						$d['commentaires'] = $termine.$classement;
					}
					else {
						$d['commentaires'] = $date.$gymnase.$adresse.$table.$arbitre;
						$d['commentaires'] = substr($d['commentaires'], 0, strlen($d['commentaires'])-5);
					}
				}
				else {
					$d['commentaires'] = $date.$gymnase.$adresse.$table.$arbitre;
					$d['commentaires'] = substr($d['commentaires'], 0, strlen($d['commentaires'])-5);
				}
				
				$d['score'] = '';
				
				if($d['joue']) {
					for($i=1; $i<=3; $i++) {
						if($d['score_dom'.$i] != 0 || $d['score_ext'.$i] != 0) {
							switch($d['lieu']) {
								case 0:
									$d['dom_ext'] = 'D';
									if($d['score_dom'.$i]>$d['score_ext'.$i])
										$couleur = 'vert';
									elseif($d['score_dom'.$i]<$d['score_ext'.$i])
										$couleur = 'rouge';
									else
										$couleur = 'orange';
								break;
								case 1:
									$d['dom_ext'] = 'E';
									if($d['score_dom'.$i]<$d['score_ext'.$i])
										$couleur = 'vert';
									elseif($d['score_dom'.$i]>$d['score_ext'.$i])
										$couleur = 'rouge';
									else
										$couleur = 'orange';
								break;
								case 2:
								default:
									$d['dom_ext'] = 'N';
									if($d['score_dom'.$i]>$d['score_ext'.$i])
										$couleur = 'vert';
									elseif($d['score_dom'.$i]<$d['score_ext'.$i])
										$couleur = 'rouge';
									else
										$couleur = 'orange';
								break;
							}
							$d['score'] .= '<strong class="'. $couleur .'">' .$d['score_dom'.$i].'-'.$d['score_ext'.$i]. '</strong><br/>';
						}
					}
					$d['score'] = substr($d['score'], 0, strlen($d['score'])-5);
				}
				else{
					switch($d['lieu']) {
						case 0:
							$d['dom_ext'] = 'D';
						break;
						case 1:
							$d['dom_ext'] = 'E';
						break;
						case 2:
						default:
							$d['dom_ext'] = 'N';
						break;
					}
					$d['score'] = '-';
				}
				
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	function retourneUnMatch($id) {
		global $mois_de_lannee;
		
		$maReq = "
			SELECT 
				LC.id AS id_categorie, LC.categorie, LC.type, LC.numero, C.id, C.date, C.heure AS horaire, C.competition, C.compet, C.niveau, C.adversaire1, C.adversaire2, C.adversaire3, C.lieu, C.gymnase, C.adresse, C.ville, C.code_postal, C.table, C.journee, C.tour, C.score_dom1, C.score_ext1, C.score_dom2, C.score_ext2, C.score_dom3, C.score_ext3, C.joue, C.arbitre, C.classement
			FROM 
				calendrier AS C, liste_categories AS LC, liste_competition AS LCo, liste_niveau AS LN
			WHERE 
				C.id = ". $id ." 
				AND C.categorie = LC.id
				AND C.compet = LCo.id
				AND C.niveau = LN.id
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			$d = mysql_fetch_array($q);
			
			if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
			if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
			
			/**** Début - La date *****/
			$d['annee'] = substr($d['date'], 0, 4);
			
			if(substr($d['date'], 4, 1)==0)
				$d['mois'] = substr($d['date'], 5, 1);
			else
				$d['mois'] = substr($d['date'], 4, 2);
				
			if(substr($d['date'], 6, 1)==0)
				$d['jour'] = substr($d['date'], 7, 1);
			else
				$d['jour'] = substr($d['date'], 6, 2);
			
			$d['laDate'] = $d['jour'].' '.$mois_de_lannee[$d['mois']].' '.$d['annee'];
			/**** Fin - La date *****/
			
			/**** Début - L'heure *****/
			if(substr($d['horaire'], 0, 1)==0)
				$d['heure'] = substr($d['horaire'], 1, 1);
			else
				$d['heure'] = substr($d['horaire'], 0, 2);
			
			if(substr($d['horaire'], 2, 1)==0)
				$d['minute'] = substr($d['horaire'], 3, 1);
			else
				$d['minute'] = substr($d['horaire'], 2, 2);
			
			$d['lHeure'] = remplace_heure($d['horaire']);
			/**** Fin - L'heure *****/
			
			$d['competition'] .= ($d['journee']!=0)?'<br/>Journée '.$d['journee']:'<br/>'.$d['tour'];
			
			$d['adversaire'] = $d['adversaire1'];
			
			for($i=2; $i<=3; $i++) {
				if($d['adversaire'.$i] != '') {
					$d['adversaire'] .= "<br/>".$d['adversaire'.$i];
				}
			}
			
			$d['score'] = '';
			
			for($i=1; $i<=3; $i++) {
				if($d['score_dom'.$i] != 0 && $d['score_ext'.$i] != 0) {
					switch($d['lieu']) {
						case 0:
							$d['dom_ext'] = 'D';
							if($d['score_dom'.$i]>$d['score_ext'.$i])
								$couleur = 'vert';
							elseif($d['score_dom'.$i]<$d['score_ext'.$i])
								$couleur = 'rouge';
							else
								$couleur = 'orange';
						break;
						case 1:
							$d['dom_ext'] = 'E';
							if($d['score_dom'.$i]<$d['score_ext'.$i])
								$couleur = 'vert';
							elseif($d['score_dom'.$i]>$d['score_ext'.$i])
								$couleur = 'rouge';
							else
								$couleur = 'orange';
						break;
						case 2:
						default:
							$d['dom_ext'] = 'N';
							if($d['score_dom'.$i]>$d['score_ext'.$i])
								$couleur = 'vert';
							elseif($d['score_dom'.$i]<$d['score_ext'.$i])
								$couleur = 'rouge';
							else
								$couleur = 'orange';
						break;
					}
					$d['score'] .= '<strong class="'. $couleur .'">' .$d['score_dom'.$i].'-'.$d['score_ext'.$i]. '</strong><br/>';
				}
			}
			$d['score'] = substr($d['score'], 0, strlen($d['score'])-5);
				
			return $d;
		}
		else
			return false;
	}
	
	function liste_categorie($raccourci = false) {
		$liste = array();
		
		if($raccourci)
			$where = " AND LC.raccourci = '".$raccourci."' ";
		else
			$where = "";
		
		$maReq = "
			SELECT 
				DISTINCT LC.id, LC.categorie, LC.type, LC.numero
			FROM 
				liste_categories AS LC 
			WHERE
				type != ''
				". $where ."
			ORDER BY 
				LC.ordre
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
				if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
				
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	function liste_competition() {
		$liste = array();
		
		$maReq = "
			SELECT 
				LC.id, LC.nom
			FROM 
				liste_competition AS LC
			ORDER BY 
				LC.id
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$liste[$d['id']] = $d['nom'];
			}
			return $liste;
		}
		else
			return false;
	}
	
	function liste_date($annee) {
		$liste = array();
		global $mois_de_lannee;
		
		$maReq = "
			SELECT 
				date
			FROM 
				matchs
			WHERE
				date > ".$annee."0701
			ORDER BY 
				date
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$annee = substr($d['date'], 0, 4);
			
				if(substr($d['date'], 4, 1)==0)
					$mois = substr($d['date'], 5, 1);
				else
					$mois = substr($d['date'], 4, 2);
					
				$liste[$annee.substr($d['date'], 4, 2)] = $mois_de_lannee[$mois-1].' '.$annee;
			}
			return $liste;
		}
		else
			return false;
	}
	
	function liste_championnat() {
		$liste = array();
		
		$maReq = "
			SELECT 
				id, nom
			FROM 
				liste_championnat
			ORDER BY 
				id
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$liste[$d['id']] = $d['nom'];
			}
			return $liste;
		}
		else
			return false;
	}
	
	
	function liste_niveau() {
		$liste = array();
		
		$maReq = "
			SELECT 
				id, nom
			FROM 
				liste_niveau
			ORDER BY 
				id
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$liste[$d['id']] = $d['nom'];
			}
			return $liste;
		}
		else
			return false;
	}
	
	function retournePosteById($id) {
		$maReq = "
			SELECT 
				poste
			FROM 
				liste_poste
			WHERE
				id = ".$id."
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			return $d['poste'];
		}
		else
			return false;
	}
	
	function retourneCompetitionById($id) {
		$maReq = "
			SELECT 
				nom
			FROM 
				liste_competition
			WHERE
				id = ".$id."
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			return $d['nom'];
		}
		else
			return false;
	}
	
	function retourneRaccourciById($id) {
		$maReq = "
			SELECT 
				raccourci
			FROM 
				categories
			WHERE 
				id = '".$id."'
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			$d = mysql_fetch_array($q);
			
			return $d['raccourci'];
		}
		else
			return false;
	}
	
	function retourneCategorieById($id) {
		$maReq = "
			SELECT 
				DISTINCT id, categorie, genre, numero
			FROM 
				categories 
			WHERE
				id = ".$id."
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			if(!empty($d['numero'])) $d['genre'] .= ' '.$d['numero'];
			if(!empty($d['genre'])) $d['cat'] = $d['categorie'].' '.$d['genre'];
			
			return $d['cat'];
		}
		else
			return false;
	}
	
	function retourneDetailsCategorieById($id) {
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, LC.raccourci
			FROM 
				liste_categories AS LC 
			WHERE
				id = ".$id."
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			$tab['numero'] = $d['numero'];
			$tab['type'] = $d['type'];
			$tab['type_num'] = $d['type'];
			$tab['categorie'] = $d['categorie'];
			$tab['cat'] = $d['categorie'];
			if(!empty($d['numero'])) $tab['type_num'] .= ' '.$d['numero'];
			if(!empty($d['type_num'])) $tab['cat'] = $d['categorie'].' '.$d['type_num'];
			
			return $tab;
		}
		else
			return false;
	}
	
	
	function retourneNiveauById($id) {
		$maReq = "
			SELECT 
				LN.nom
			FROM 
				liste_niveau AS LN
			WHERE
				id = ". $id ."
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			return $d['nom'];
		}
		else
			return false;
	}
	
	function retourneChampionnatById($id) {
		$maReq = "
			SELECT 
				LC.nom
			FROM 
				liste_championnat AS LC
			WHERE
				id = ". $id ."
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			return $d['nom'];
		}
		else
			return 'D&eacute;layage';
	}
	
	function retourneEntraineurById($id) {
		$maReq = "
			SELECT 
				U.id, U.prenom, U.nom
			FROM 
				utilisateurs as U
			WHERE
				U.id = ". $id ."
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			$liste['id'] = $d['id'];
			$liste['prenom'] = $d['prenom'];
			$liste['nom'] = $d['nom'];
			return $liste;
		}
		else
			return false;
	}
	
	function retourneHoraireById($id) {
		$maReq = "
			SELECT 
				H.jour, H.heure_debut, H.heure_fin, H.gymnase
			FROM 
				horaires as H
			WHERE
				H.id = ". $id ."
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			$liste['jour'] = $d['jour'];
			$liste['heure_debut'] = $d['heure_debut'];
			$liste['heure_fin'] = $d['heure_fin'];
			$liste['gymnase'] = $d['gymnase'];
			return $liste;
		}
		else
			return false;
	}
	
	function planning_horaires($annee) {
		$liste = array();
		$raccourci = '';
		$jour = 0;
		$gymnase = '';
		$heure_debut = 0;
		$heure_fin = 0;
		
		$maReq = "
			SELECT 
				C.raccourci, H.jour, H.heure_debut, H.heure_fin, H.gymnase 
			FROM 
				categories AS C, horaires AS H
			WHERE 
				C.id = H.categorie 
				AND annee = ".$annee."
			ORDER BY H.jour, H.heure_debut, H.gymnase
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				if($d['jour'] == $jour && $d['gymnase'] == $gymnase && $d['heure_debut'] == $heure_debut && $d['heure_fin'] == $heure_fin)
					$raccourci .= '-'.$d['raccourci'];
				else
					$raccourci = $d['raccourci'];
				$liste[$d['jour']][$d['gymnase']][$d['heure_debut'].'-'.$d['heure_fin']] = $raccourci;
				extract($d);
			}
			return $liste;
		}
		else
			return false;
	}
	
	function catToutesLettres($rac) {
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero 
			FROM 
				liste_categories AS LC 
			WHERE 
				LC.raccourci LIKE '".$rac."'
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			if($d['numero']==0) $d['numero'] = '';
			if(!empty($d['type'])) $d['categorie'] .= ' '.substr(ucfirst($d['type']), 0, 1).$d['numero'];
			return $d['categorie'];
		}
		else
			return false;
	}
	
	function liste_tarifs($annee){
		$liste = array();
		$maReq = "
			SELECT 
				LC.categorie, LC.type AS LC_type, T.annees, T.categories, T.type AS afficheType, T.prix, T.condition
			FROM 
				liste_categories AS LC, tarifs AS T
			WHERE
				LC.id = T.categories
				AND annee = ".$annee."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)){
				$d['categorie'] = ($d['afficheType']==1)?$d['categorie'].' '.$d['LC_type'] : $d['categorie'];
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	function liste_news($infos=1, $onglet=false, $annee=false) {
		global $mois_de_lannee;
		$liste = array();
		$where = "";
		
		if($onglet !== false)
			$where .= " AND LC.raccourci = '". $onglet . "'";
		
		if($annee !== false) {
			$annee_suiv = $annee + 1;
			$where .= " AND N.date_news >= ". $annee . "0701 AND N.date_news < ". $annee_suiv . "0701 ";
		}
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, N.id, N.affiche_type, N.affiche_numero, N.titre, N.date_news, N.heure_news, N.important
			FROM 
				liste_categories AS LC, news AS N
			WHERE
				(
					LC.id = N.categorie
					OR (N.categorie = 0 
						AND LC.id = 1)
				)
				AND infos = ". $infos ."
				AND publie = 1 
				". $where ."
			ORDER BY
				date_news DESC, heure_news DESC
			LIMIT 0,3
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)){
				$d['categorie'] = ($d['affiche_type']==1) ? $d['categorie'].' '. substr($d['type'], 0, 1) : $d['categorie'];
				$d['categorie'] = ($d['affiche_numero']==1) ? $d['categorie'] . substr($d['numero'], 0, 1) : $d['categorie'];
				
				$d['titre_news'] = ($d['affiche_numero']==0) ? $d['titre'] : $d['categorie'] ." - ". $d['titre'];
				
				$annee = substr($d['date_news'], 0, 4);
				$mois = substr($d['date_news'], 4, 2);
				$jour = substr($d['date_news'], 6, 2);
				if(date('YmdHi'))
				$d['laDate'] = $jour.' '.$mois_de_lannee[$mois-1].' '.$annee;
				$d['lHeure'] = ($d['heure_news']==0 || empty($d['heure_news']))?'-':remplace_heure($d['heure_news']);
				$d['laDate'] .= " à ". $d['lHeure'];
				
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	function listeNews($param = array()) {
		global $mois_de_lannee;
		$liste = array();
		$where = "";
		
		// if($onglet !== false)
			// $where .= " AND LC.raccourci = '". $onglet . "'";
		
		// if($annee !== false) {
			// $annee_suiv = $annee + 1;
			// $where .= " AND N.date_news >= ". $annee . "0701 AND N.date_news < ". $annee_suiv . "0701 ";
		// }
		
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, N.id, N.affiche_type, N.affiche_numero, N.titre, N.date_news, N.heure_news, N.important
			FROM 
				liste_categories AS LC, news AS N
			WHERE
				LC.id = N.categorie
				". $where ."
			ORDER BY
				date_news DESC, heure_news DESC
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)){
				$d['categorie'] = ($d['affiche_type']==1) ? $d['categorie'].' '. substr($d['type'], 0, 1) : $d['categorie'];
				$d['categorie'] = ($d['affiche_numero']==1) ? $d['categorie'] . substr($d['numero'], 0, 1) : $d['categorie'];
				
				$d['titre_news'] = $d['categorie'] ." - ". $d['titre'];
				
				$annee = substr($d['date_news'], 0, 4);
				$mois = substr($d['date_news'], 4, 2);
				$jour = substr($d['date_news'], 6, 2);
				$d['laDate'] = $jour.' '.$mois_de_lannee[$mois-1].' '.$annee;
				$d['lHeure'] = ($d['heure_news']==0 || empty($d['heure_news']))?'-':remplace_heure($d['heure_news']);
				$d['laDate'] .= " à ". $d['lHeure'];
				
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	function liste_news_iphone($infos=1) {
		global $mois_de_lannee;
		$liste = array();
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, N.id, N.date_news, N.heure_news, N.affiche_type, N.affiche_numero, N.titre
			FROM 
				liste_categories AS LC, news AS N
			WHERE
				LC.id = N.categorie
				AND infos = ". $infos ."
				AND publie = 1
			ORDER BY
				date_news DESC
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)){
				$d['categorie'] = ($d['affiche_type']==1) ? $d['categorie'].' - '.$d['type'] : $d['categorie'];
				$d['categorie'] = ($d['affiche_numero']==1) ? $d['categorie'].' '.$d['numero'] : $d['categorie'];
				
				$mois = substr($d['date_news'], 4, 2);
				$jour = substr($d['date_news'], 6, 2);
				$d['date_news2'] = $jour.'/'.$mois;
				
				$tab['id_breve'] = $d['id'];
				$tab['titre_news'] = $d['categorie'] ."<br/><strong>". $d['titre'] ."</strong>";
				if($d['date_news'] != date("Ymd")) {
					$tab['date_heure'] = $d['date_news2'];
				}
				else {
					$tab['date_heure'] = remplace_heure($d['heure_news']);
				}
				
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	function infos_news($id) {
		$liste = array();
		global $mois_de_lannee;
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, N.id, N.date_news, N.heure_news, N.affiche_type, N.affiche_numero, N.titre, N.contenu, N.date_news, N.important, MB.prenom
			FROM 
				liste_categories AS LC, news AS N, utilisateurs AS MB
			WHERE
				LC.id = N.categorie
				AND N.auteur = MB.id
				AND N.id = ". $id ."
				AND publie = 1
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			$d = mysql_fetch_array($q);
			$d['categorie'] = ($d['affiche_type']==1) ? $d['categorie'].' '.$d['type'] : $d['categorie'];
			$d['categorie'] = ($d['affiche_numero']==1) ? $d['categorie'].' '.$d['numero'] : $d['categorie'];
			
			$annee = substr($d['date_news'], 0, 4);
			$mois = (substr($d['date_news'], 4, 1) == 0)? substr($d['date_news'], 5, 1):substr($d['date_news'], 4, 2);
			$jour = substr($d['date_news'], 6, 2);
			$laDate = $jour.' '.$mois_de_lannee[$mois-1]. ' '.$annee;
			
			$d['auteur_date'] = "R&eacute;dig&eacute; par ". $d['prenom'] .", le ".$laDate;
			
			return $d;
		}
		else
			return false;
	}
	
	function ajoutClassement($raccourci, $tab, $date = 2012) {
		$id = recupIdEquipe($raccourci);
		$derniere_maj = date('Ymd');
		if(existeClassement($id, $date)) {
			$maReq = '
				UPDATE 
					classements_equipes
				SET 
					classement = "'. $tab .'", derniere_maj = '. $derniere_maj .'
				WHERE
					categorie = "'. $id .'"
					AND annee = '. $date .'
			';
		}
		else {
			$maReq = '
				INSERT INTO 
					classements_equipes
				VALUES 
					("", '. $id .', "'. $tab .'", '. $date .', '. $derniere_maj .')
			';
		}
		
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function recupIdEquipe($raccourci) {
		$maReq = "
			SELECT 
				LC.id
			FROM 
				liste_categories AS LC
			WHERE
				LC.raccourci = '". $raccourci ."'
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			$d = mysql_fetch_array($q);
			return $d['id'];
		}
		else {
			return 0;
		}
	}
	
	function existeClassement($id, $date) {
		$maReq = "
			SELECT 
				id
			FROM 
				classements_equipes
			WHERE
				categorie = '". $id ."'
				AND annee = ". $date ."
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function retourne_tous_classements($date = 2012) {
		$liste = array();
		$retour = array();
		global $mois_de_lannee;
		$maReq = "
			SELECT 
				LC.categorie, LC.type, LC.numero, CE.classement, CE.derniere_maj
			FROM 
				classements_equipes AS CE, liste_categories AS LC
			WHERE
				LC.id = CE.categorie
				AND CE.annee = ". $date ."
			ORDER BY LC.ordre
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$d['type'] = (!empty($d['numero'])) ? $d['type'].' '.$d['numero'] : $d['type'];
				$liste['categorie'] = (!empty($d['type'])) ? $d['categorie'].' '.$d['type'] : $d['categorie'];
				$liste['classement'] = $d['classement'];
				$liste['newDate'] = substr($d['derniere_maj'], 6, 2) .' '. substr($mois_de_lannee[substr($d['derniere_maj'], 4, 2)-1], 0, 3) .' '. substr($d['derniere_maj'], 2, 2);
				$retour[] = $liste;
			}
			return $retour;
		}
		else {
			return false;
		}
	}
	
	function retourne_classement($equipe, $annee = false) {
		$liste = array();
		global $mois_de_lannee;
		
		if($annee === false)
			$annee = date('Y');
		
		$maReq = "
			SELECT 
				CE.classement, CE.derniere_maj
			FROM 
				classements_equipes AS CE, liste_categories AS LC
			WHERE
				LC.raccourci = '". $equipe ."'
				AND LC.id = CE.categorie
				AND CE.annee = ". $annee ."
			LIMIT 0, 1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			$d = mysql_fetch_array($q);
			$liste['classement'] = $d['classement'];
			$liste['newDate'] = substr($d['derniere_maj'], 6, 2) .' '. substr($mois_de_lannee[substr($d['derniere_maj'], 4, 2)-1], 0, 3) .' '. substr($d['derniere_maj'], 2, 2);
			return $liste;
		}
		else {
			return false;
		}
	}

	function update_match($id, $cat, $date, $heure, $lieu, $gymnase, $adresse, $ville, $code_postal, $competition, $niveau, $journee, $tour, $adversaire1, $adversaire2, $adversaire3, $dom1, $ext1, $dom2, $ext2, $dom3, $ext3, $joue, $arbitre, $classement) {
		$maReq = "
			UPDATE 
				calendrier AS C
			SET 
				C.categorie = ". $cat .",
				C.date = ". $date .",
				C.heure = ". $heure .",
				C.lieu = ". $lieu .",
				C.gymnase = '". $gymnase ."',
				C.adresse = '". $adresse ."',
				C.ville = '". $ville ."',
				C.code_postal = ". $code_postal .",
				C.compet = '". $competition ."',
				C.niveau = ". $niveau .",
				C.journee = ". $journee .",
				C.tour = '". $tour ."',
				C.adversaire1 = '". $adversaire1 ."',
				C.adversaire2 = '". $adversaire2 ."',
				C.adversaire3 = '". $adversaire3 ."',
				C.score_dom1 = ". $dom1 .",
				C.score_ext1 = ". $ext1 .",
				C.score_dom2 = ". $dom2 .",
				C.score_ext2 = ". $ext2 .",
				C.score_dom3 = ". $dom3 .",
				C.score_ext3 = ". $ext3 .",
				C.joue = ". $joue .",
				C.arbitre = '". $arbitre ."',
				C.classement = '". $classement ."'
			WHERE
				C.id = ". $id ."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function ajout_match($cat, $date, $heure, $lieu, $gymnase, $adresse, $ville, $code_postal, $competition, $niveau, $journee, $tour, $adversaire1, $adversaire2, $adversaire3, $dom1, $ext1, $dom2, $ext2, $dom3, $ext3, $joue, $arbitre, $classement) {
		$maReq = "
			INSERT INTO 
				calendrier
			VALUES(
				'',
				". $cat .",
				". $date .",
				". $heure .",
				'',
				". $competition .",
				". $niveau .",
				'". $adversaire1 ."',
				'". $adversaire2 ."',
				'". $adversaire3 ."',
				". $lieu .",
				'". $gymnase ."',
				'". $adresse ."',
				'". $ville ."',
				". $code_postal .",
				'',
				". $journee .",
				'". $tour ."',
				". $dom1 .",
				". $ext1 .",
				". $dom2 .",
				". $ext2 .",
				". $dom3 .",
				". $ext3 .",
				". $joue .",
				'". $arbitre ."',
				'". $classement ."'
			)
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function ajout_equipe($cat, $niveau, $championnat, $entraineur1, $entraineur2, $entrainement1, $entrainement2, $active) {
		$maReq = "
			INSERT INTO 
				equipes
			VALUES(
				'',
				". $cat .",
				". $niveau .",
				". $championnat .",
				".date('Y').",
				". $entraineur1 .",
				". $entraineur2 .",
				". $entrainement1 .",
				". $entrainement2 .",
				'',
				0,
				". $active ."
			)
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function ajout_fonction($T) {
		
		$maReq = "
			INSERT INTO 
				fonctions
			VALUES(
				'',
				'". $T[0]['type'] ."',
				". $T[0]['categorie'] .",
				". $T[0]['id_utilisateur'] .",
				".date('Y').",
				0,
				". $T[0]['active'] .",
				0
			)
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function liste_poste() {
		$liste = array();
		
		$maReq = "
			SELECT 
				LP.poste
			FROM 
				liste_poste AS LP
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {	
				$liste[] = $d['poste'];
			}
			return $liste;
		}
		else
			return false;
	}
	
	function nbr_match_coupe($liste, $cat) {
		$i = 0;
		foreach($liste as $match) {
			if($match['cat']==$cat) {
				$i++;
			}
		}
		
		return $i;
	}
	
	/**********************************************************
	**
	** Remplace la forme de la date en chiffre par une String
	** 
	** Entrée : (Int)
	** Sortie : (String)
	**
	***********************************************************/
	
	function remplace_date($date) {
		global $mois_de_lannee;
		
		$annee = substr($date, 0, 4);
		$mois = substr($date, 4, 2);
		$jour = substr($date, 6, 2);
		
		$newDate = $jour.' '.$mois_de_lannee[$mois-1].' '.$annee;
		
		return $newDate;
	}
	
	/**********************************************************
	**
	** Remplace la forme de l'heure en chiffre par une String
	** 
	** Entrée : (Int)
	** Sortie : (String)
	**
	***********************************************************/
	
	function remplace_heure($heure) {
		$longueur = strlen($heure);
		switch($longueur) {
			
			case 1:
				$minute = substr($heure, 0, 1);
				$newHeure = '00h0'.$minute;
				break;
			case 2:
				$minute = substr($heure, 0, 2);
				$newHeure = '00h'.$minute;
				break;
			case 3:
				$heureH = substr($heure, 0, 1);
				$minute = substr($heure, -2);
				if($minute=='00')
					$minute = '';
				$newHeure = $heureH.'h'.$minute;
				break;
			case 4:
				$heureH = substr($heure, 0, 2);
				$minute = substr($heure, -2);
				if($minute=='00')
					$minute = '';
				$newHeure = $heureH.'h'.$minute;
				break;
			case 0:
			default:
				$minute = substr($heure, -2);
				$heureH = substr($heure, 0, 2);
				if($minute=='00')
					$minute = '';
				$newHeure = $heureH.'h'.$minute;
				break;
		}
		return $newHeure;
	}
	
	/**********************************************************
	**
	** Liste les images
	** 
	** Entrée : (Void)
	** Sortie : (Array)
	**
	***********************************************************/
	
	function liste_image() {
		$liste = array();
		
		$maReq = "
			SELECT 
				*
			FROM 
				images AS I
			ORDER BY
				id DESC
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['id'] = $d['id'];
				$tab['nom'] = $d['nom'];
				$tab['width'] = $d['width'];
				$tab['height'] = $d['height'];
				$tab['extension'] = $d['extension'];
				
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/********************************
	**
	** Retourne la dernière actualité
	** 
	** Entrée : (Void)
	** Sortie : (Array)
	**
	*********************************/
	
	function derniere_actualite() {
		$liste = array();
		
		$maReq = "
			SELECT 
				*
			FROM 
				actualites AS A
			WHERE
				publie = 1
			ORDER BY
				A.date_creation DESC, SUBSTR(A.heure_creation, 1, 2) DESC, SUBSTR(A.heure_creation, 3, 2) DESC
			LIMIT 0,1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {	
				$liste = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/**********************************************************
	**
	** Liste les actualités
	** 
	** Entrée : (Void)
	** Sortie : (Array)
	**
	***********************************************************/
	
	function liste_actualites() {
		$liste = array();
		
		$maReq = "
			SELECT 
				*
			FROM 
				actualites AS A
			ORDER BY
				A.date_creation DESC, SUBSTR(A.heure_creation, 1, 2) DESC, SUBSTR(A.heure_creation, 3, 2) DESC
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$tab['id'] = $d['id'];
				$tab['titre'] = $d['titre'];
				$tab['theme'] = $d['theme'];
				$auteur = retourneUtilisateurById($d['auteur']);
				$tab['auteur'] = $auteur['prenom'];
				
				$annee = substr($d['date_creation'], 0, 4);
				$mois = substr($d['date_creation'], 4, 2);
				$jour = substr($d['date_creation'], 6, 2);
				$tab['laDate'] = $jour.'/'.$mois.'/'.$annee;
				$tab['lHeure'] = ($d['heure_creation']==0 || empty($d['heure_creation']))?'-':remplace_heure($d['heure_creation']);
				$tab['laDate'] .= " à ". $tab['lHeure'];
				
				$liste[] = $tab;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/**********************************************************
	**
	** Retourne 3 dernières actualités sauf la toute dernière
	** 
	** Entrée : (Void)
	** Sortie : (Array)
	**
	***********************************************************/
	
	function trois_actualites() {
		$liste = array();
		
		$maReq = "
			SELECT 
				*
			FROM 
				actualites AS A
			WHERE
				publie = 1
			ORDER BY
				A.date_creation DESC, SUBSTR(A.heure_creation, 1, 2) DESC, SUBSTR(A.heure_creation, 3, 2) DESC
			LIMIT 1,3
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/**********************************************************
	**
	** Retourne les 10 dernières actualités
	** 
	** Entrée : (Void)
	** Sortie : (Array)
	**
	***********************************************************/
	
	function listeActualites($id, $theme) {
		$liste = array();
		global $mois_de_lannee;
		
		$maReq = "
			SELECT 
				A.id AS id_actu, A.titre, A.sous_titre, A.contenu, A.theme, A.date_creation, A.image, U.prenom, U.nom
			FROM 
				actualites AS A, utilisateurs AS U
			WHERE
				publie = 1
				AND A.auteur = U.id";
			if($id!=0)
				$maReq .= " AND A.id = ".$id;
			if($theme!='')
				$maReq .= " AND A.theme LIKE '".$theme."'";
			$maReq .= " ORDER BY
				A.date_creation DESC, SUBSTR(A.heure_creation, 1, 2) DESC, SUBSTR(A.heure_creation, 3, 2) DESC
			LIMIT 0,10
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$annee = substr($d['date_creation'], 0, 4);
				$mois = (substr($d['date_creation'], 4, 1) == 0)? substr($d['date_creation'], 5, 1):substr($d['date_creation'], 4, 2);
				$jour = substr($d['date_creation'], 6, 2);
				$laDate = $jour.' '.$mois_de_lannee[$mois-1]. ' '.$annee;
			
				$d['auteur_date'] = "R&eacute;dig&eacute; par ". $d['prenom'] ." ". $d['nom'] .", le ".$laDate;
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}
	
	/***************************************************************************************************************************************
	**
	** Ajoute une actualitée dans la BDD
	** 
	** Entrée : (String) $titre, (String) $sous_titre, (String) $contenu, (String) $theme, (String) $auteur, (String) $image, (Bool) $publie
	** Sortie : (Boolean)
	**
	****************************************************************************************************************************************/
	
	function ajout_actualite($titre, $sous_titre, $contenu, $theme, $auteur, $image, $publie) {
		$maReq = '
			INSERT INTO 
				actualites
			VALUES 
				("", "'. $titre .'", "'. $sous_titre .'", "'. $contenu .'", "'.$theme.'", 0, 0, "'.$auteur.'", '.date('Ymd').', '.date('Hi').', 0, 0, "'.$image.'", '. $publie .')
		';
		// id	titre	sous_titre	contenu	theme	photo	video	auteur	date_creation	heure_creation	date_modification	heure_modification	image	publie
	
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/****************************************************************************************************************************************************
	**
	** Ajoute une actualitée dans la BDD
	** 
	** Entrée : (Int) $id, (String) $titre, (String) $sous_titre, (String) $contenu, (String) $theme, (String) $auteur, (String) $image, (Bool) $publie
	** Sortie : (Boolean)
	**
	*****************************************************************************************************************************************************/
	
	function modif_actualite($id, $titre, $sous_titre, $contenu, $theme, $auteur, $image, $publie) {
		$maReq = '
			UPDATE 
				actualites
			SET 
				titre = "'. $titre .'", sous_titre = "'. $sous_titre .'", contenu = "'. $contenu .'", theme = "'.$theme.'", auteur = "'.$auteur.'", date_modification = '.date('Ymd').', heure_modification = '.date('Hi').', image = "'.$image.'", publie = '. $publie .'
			WHERE
				id = '. $id .'
		';
		// id	titre	sous_titre	contenu	theme	photo	video	auteur	date_creation	heure_creation	date_modification	heure_modification	image	publie
	
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/*************************************
	**
	** Supprime une actualité avec son ID
	** 
	** Entrée : (Int) $id
	** Sortie : (Booleen)
	**
	**************************************/
	
	function delete_actualite($id) {
		$maReq = "
			DELETE FROM
				actualites
			WHERE
				id = ". $id ." 
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	
	/**********************************
	**
	** Vérifie si une actualite existe
	** 
	** Entrée : (Int) $id
	** Sortie : (Boolean)
	**
	**********************************/
	
	function existe_actualite($id) {
		$maReq = "
			SELECT 
				COUNT(1)
			FROM 
				actualites AS A
			WHERE
				A.id = '". $id ."'
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		if($d[0]==1)
			return true;
		else
			return false;
	}
	
	
	/*******************************************
	**
	** Retourne une actualité grâce à son id
	** 
	** Entrée : (Int) $id
	** Sortie : (Array)
	**
	********************************************/
	
	function retourneActualiteById($id) {
		$maReq = "
			SELECT 
				*
			FROM 
				actualites AS A
			WHERE
				A.id = ". $id ."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			return $d;
		}
		else
			return false;
	}
	
	/*************************************************
	**
	** Retourne l'actualité précédente grâce à son id
	** 
	** Entrée : (Int) $id
	** Sortie : (Array)
	**
	*************************************************/
	
	function retourneActualitePrecedente($id) {
		$maReq = "
			SELECT 
				*
			FROM 
				actualites AS A
			WHERE
				A.id < ". $id ." 
				AND A.publie = 1
			ORDER BY
				id DESC 
			LIMIT 0,1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			$tab['id'] = $d['id'];
			$tab['titre'] = $d['titre'];
			return $tab;
		}
		else
			return false;
	}

	/**********************************************
	**
	** Retourne l'actualité suivante grâce à son id
	** 
	** Entrée : (Int) $id
	** Sortie : (Array)
	**
	**********************************************/
	
	function retourneActualiteSuivante($id) {
		$maReq = "
			SELECT 
				*
			FROM 
				actualites AS A
			WHERE
				A.id > ". $id ." 
				AND A.publie = 1 
			LIMIT 0,1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			$tab['id'] = $d['id'];
			$tab['titre'] = $d['titre'];
			return $tab;
		}
		else
			return false;
	}
	
	/**********************************************************
	**
	** Retourne les 10 derniers dossiers
	** 
	** Entrée : (Void)
	** Sortie : (Array)
	**
	***********************************************************/
	
	function listeDossiers ($theme = '', $id = 0) {
		$liste = array();
		global $mois_de_lannee;
		
		$maReq = "
			SELECT 
				D.id AS id_dossier, D.titre, D.sous_titre, D.contenu, D.theme, D.date_creation, D.heure_creation, D.date_modification, D.heure_modification, D.image, U.prenom, U.nom
			FROM 
				dossiers AS D, utilisateurs AS U
			WHERE
				D.publie = 1
				AND D.auteur = U.id";
			if($theme!='')
				$maReq .= " AND D.theme = '".$theme."'";
			if($id!=0)
				$maReq .= " AND D.id = ".$id;
			$maReq .= " ORDER BY
				D.date_creation DESC, SUBSTR(D.heure_creation, 1, 2) DESC, SUBSTR(D.heure_creation, 3, 2) DESC
			LIMIT 0,5
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$annee = substr($d['date_creation'], 0, 4);
				$mois = (substr($d['date_creation'], 4, 1) == 0)? substr($d['date_creation'], 5, 1):substr($d['date_creation'], 4, 2);
				$jour = substr($d['date_creation'], 6, 2);
				$heure = substr($d['heure_creation'], 0, 2);
				$minute = substr($d['heure_creation'], 2, 4);
				$laDate = $jour.' '.$mois_de_lannee[$mois-1]. ' '.$annee;
				$d['laDate'] = $jour.'/'.$mois. '/'.$annee.' '.$heure.'h'.$minute;
			
				$d['auteur_date'] = "R&eacute;dig&eacute; par ". $d['prenom'] ." ". $d['nom'] .", le ".$laDate;
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}

	/*******************************************
	**
	** Vérifie si un id de dossier existe
	** 
	** Entrée : (Int) $id
	** Sortie : (Boolean)
	**
	********************************************/
	
	function existe_idDossier($id) {
		$maReq = "
			SELECT 
				COUNT(1)
			FROM 
				dossiers AS D
			WHERE
				D.id = ". $id ."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		if($d[0]>0)
			return true;
		else
			return false;
	}

	/*******************************************
	**
	** Vérifie si un thème de dossier existe
	** 
	** Entrée : (String) $theme
	** Sortie : (Boolean)
	**
	********************************************/
	
	function existe_themeDossier($theme) {
		$maReq = "
			SELECT 
				COUNT(1)
			FROM 
				dossiers AS D
			WHERE
				D.theme = '". $theme ."'
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		if($d[0]>0)
			return true;
		else
			return false;
	}
	
	/************************************
	**
	** Retourne un dossier grâce à son id
	** 
	** Entrée : (Int) $id
	** Sortie : (Array)
	**
	*************************************/
	
	function retourneDossierById($id) {
		$maReq = "
			SELECT 
				*
			FROM 
				dossiers AS D
			WHERE
				D.id = ". $id ."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			return $d;
		}
		else
			return false;
	}

	/****************************************************************************************************************************************************
	**
	** Modifie une actualitée dans la BDD
	** 
	** Entrée : (Int) $id, (String) $titre, (String) $sous_titre, (String) $contenu, (String) $theme, (String) $auteur, (String) $image, (Bool) $publie
	** Sortie : (Boolean)
	**
	*****************************************************************************************************************************************************/
	
	function modif_dossier($id, $titre, $sous_titre, $contenu, $theme, $image, $publie) {
		$maReq = '
			UPDATE 
				actualites
			SET 
				titre = "'. $titre .'", sous_titre = "'. $sous_titre .'", contenu = "'. $contenu .'", theme = "'.$theme.'", auteur = "'.$auteur.'", date_modification = '.date('Ymd').', heure_modification = '.date('Hi').', image = "'.$image.'", publie = '. $publie .'
			WHERE
				id = '. $id .'
		';
		// id	titre	sous_titre	contenu	theme	photo	video	auteur	date_creation	heure_creation	date_modification	heure_modification	image	publie
	
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**********************************************************
	**
	** Retourne les 10 derniers Menus Manager
	** 
	** Entrée : (Void)
	** Sortie : (Array)
	**
	***********************************************************/
	
	function listeMenuManager ($options = array()) {
		$liste = array();
		extract($options);
		
		$maReq = "
			SELECT 
				MM.id AS id_menu_manager, MM.nom, MM.ordre, MM.estSupprimable, MM.actif
			FROM 
				menu_manager AS MM 
			WHERE ";
		if(!isset($parent))
			$maReq .= "parent = 0 ";
		else
			$maReq .= "parent = '".$parent."'";
		$maReq .= "
			ORDER BY
				MM.ordre
			LIMIT 0,10
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$liste[] = $d;
			}
			return $liste;
		}
		else
			return false;
	}

	/******************************************
	**
	** Ajoute un utilisateur dans la BDD
	** 
	** Entrée : (String) $nom, (String) $prenom
	** Sortie : (Boolean)
	**
	*******************************************/
	
	function ajout_utilisateur($nom, $prenom, $email) {
		$pseudo = $nom.'.'.$prenom;
		$mot_de_passe = md5($pseudo);
		$maReq = '
			INSERT INTO 
				utilisateurs
			VALUES 
				("", "'. $nom .'", "'. $prenom .'", "'. $email .'", "'.$pseudo.'", "'.$mot_de_passe.'", 0, 0, 0, 0)
		';
	
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**************************************************************************************
	**
	** Ajoute un joueur dans la BDD présent dans la table `utilisateurs`
	** 
	** Entrée : (String) $cat, (Int) $numero, (String) $nom, (String) $prenom, (Int) $poste
	** Sortie : (Boolean)
	**
	***************************************************************************************/
	
	function ajout_joueur($cat, $numero, $nom, $prenom, $poste) {

		$maReq = "
			SELECT 
				id
			FROM 
				utilisateurs AS U
			WHERE
				nom = '". $nom ."'
				AND prenom = '". $prenom ."'
			ORDER BY
				id DESC
			LIMIT 0,1
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		
		$idCat = retourneIdCatByRaccourci($cat);
		
		$maReq2 = '
		INSERT INTO 
			joueurs
		VALUES 
			("", '. $d['id'] .', '. $idCat .', '. $poste .', "", '. $numero .', "", "")
		';
	
		$q2 = mysql_query($maReq2) or die(mysql_error());
		if($q2) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/*******************************************
	**
	** Vérifie si un utilisateur existe déjà
	** 
	** Entrée : (String) $nom, (String) $prenom
	** Sortie : (Boolean)
	**
	********************************************/
	
	function existe_utilisateur($nom, $prenom) {
		$maReq = "
			SELECT 
				COUNT(1)
			FROM 
				utilisateurs AS U
			WHERE
				U.nom = '". $nom ."'
				AND U.prenom = '". $prenom ."'
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		if($d[0]>0)
			return true;
		else
			return false;
	}
	
	
	/*******************************************
	**
	** Retourne un utilisateur grâce à son id
	** 
	** Entrée : (Int) $id
	** Sortie : (Array)
	**
	********************************************/
	
	function retourneUtilisateurById($id) {
		$maReq = "
			SELECT 
				*
			FROM 
				utilisateurs AS U
			WHERE
				U.id = ". $id ."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			return $d;
		}
		else
			return false;
	}
	
	/*******************************************
	**
	** Retourne un joueur grâce à son id
	** 
	** Entrée : (Int) $id
	** Sortie : (Array)
	**
	********************************************/
	
	function retourneJoueurById($id) {
		$maReq = "
			SELECT 
				*
			FROM 
				joueurs
			WHERE
				id_utilisateur = ". $id ."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			return $d;
		}
		else
			return false;
	}
	
	/*******************************************
	**
	** Retourne un joueur grâce à son id
	** 
	** Entrée : (Int) $id
	** Sortie : (Array)
	**
	********************************************/
	
	function retourneEquipeById($id) {
		$maReq = "
			SELECT 
				*
			FROM 
				equipes
			WHERE
				id = ". $id ."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			return $d;
		}
		else
			return false;
	}
	
	/*********************************************************
	**
	** Vérifie si un joueur existe déjà dans la table `joueurs`
	** 
	** Entrée : (String) $nom, (String) $prenom
	** Sortie : (Boolean)
	**
	**********************************************************/
	
	function existe_joueur($nom, $prenom) {
		$maReq = "
			SELECT 
				COUNT(1)
			FROM 
				joueurs AS J, utilisateurs AS U
			WHERE
				J.id_utilisateur = U.id
				AND U.nom = '". $nom ."'
				AND U.prenom = '". $prenom ."'
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		if($d[0]>0)
			return true;
		else
			return false;
	}
	
	/*****************************************************
	**
	** Vérifie si un numéro existe déjà dans une catégorie
	** 
	** Entrée : (String) $cat, (Int) $numero
	** Sortie : (Boolean)
	**
	******************************************************/
	
	function existe_numero($cat, $numero) {
		$idCat = retourneIdCatByRaccourci($cat);
		$maReq = "
			SELECT 
				COUNT(1)
			FROM 
				joueurs AS J
			WHERE
				J.numero = ". $numero ."
				AND J.categorie = ". $idCat ."
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		if($d[0]>0)
			return true;
		else
			return false;
	}
	
	/*****************************************************
	**
	** Retourne l'id de la catégorie à partir du raccourci
	** 
	** Entrée : (String) $cat
	** Sortie : (Int)
	**
	******************************************************/
	
	function retourneIdCatByRaccourci($cat) {
		$maReq = "
			SELECT 
				id
			FROM 
				liste_categories AS LC
			WHERE
				LC.raccourci = '".$cat."' 
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		if($d['id']>0)
			return $d['id'];
		else
			return false;
	}
	
	/*****************************************************
	**
	** Supprime un match avec son ID
	** 
	** Entrée : (Int) $id
	** Sortie : (Booleen)
	**
	******************************************************/
	
	function delete_match($id) {
		$maReq = "
			DELETE FROM
				calendrier
			WHERE
				id = ". $id ." 
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/*****************************************************
	**
	** Ajoute une news
	** 
	** Entrée : (Int) $id
	** Sortie : (Booleen)
	**
	******************************************************/
	
	function ajoutNews($cat, $titre, $contenu, $id_auteur, $important, $publie) {
		$maReq = '
			INSERT INTO
				news
			VALUES
				("", 1, '.date('Ymd', time()).', '.date('Hi', time()+(6*3600)).', '.retourneIdCatByRaccourci($cat).', 1, 0, "'.$titre.'", "'.$contenu.'", "'.$id_auteur.'", '.$important.', '.$publie.') 
		';
		
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/*****************************************************
	**
	** Liste des équipes par année
	** 
	** Entrée : (Int) $annee
	** Sortie : (Array)
	**
	******************************************************/
	
	function liste_equipe($annee, $ordre = false) {
		$liste = array();
		$row = array();
		$entraineurs = array();
		$horaires = array();

		if($ordre) {
			$orderBy = ' LN.id,';
		}
		
		$maReq = "
			SELECT
				E.id, E.categorie, E.niveau, E.championnat, E.annee, E.actif
			FROM
				equipes AS E, liste_categories AS LC, liste_niveau AS LN
			WHERE
				E.categorie = LC.id
				AND E.annee >= ". $annee ."
				AND E.niveau = LN.id
				AND E.actif = 1
			ORDER BY
				E.annee,". $orderBy ." LC.ordre";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$row['id'] = $d['id'];
				$row['categorie'] = $d['categorie'];
				$row['niveau'] = $d['niveau'];
				$row['championnat'] = $d['championnat'];
				$row['annee'] = $d['annee'];
				$row['actif'] = $d['actif'];
				$liste[] = $row;
			}
			return $liste;
		}
		else
			return false;
	}
	
	
	/**********************************
	**
	** Vérifie si une equipe existe
	** 
	** Entrée : (Int) $id
	** Sortie : (Boolean)
	**
	**********************************/
	
	function existe_equipe($id) {
		$maReq = "
			SELECT 
				COUNT(1)
			FROM 
				equipes
			WHERE
				id = '". $id ."'
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		if($d[0]==1)
			return true;
		else
			return false;
	}
	
	/****************************************************************************************************************************************************
	**
	** Ajoute une equipe dans la BDD
	** 
	** Entrée : (Int) $id, (Int) $categorie, (Int) $niveau, (Int) $championnat, (Int) $entraineur1, (Int) $entraineur2, (Int) $entrainement1, (Int) $entrainement2,
	** (Bool) $active
	** Sortie : (Boolean)
	**
	*****************************************************************************************************************************************************/
	
	function modif_equipe($id, $categorie, $niveau, $championnat, $entraineur1, $entraineur2, $entrainement1, $entrainement2, $active) {
		$maReq = '
			UPDATE 
				equipes
			SET 
				categorie = "'. $categorie .'", niveau = "'. $niveau .'", championnat = "'. $championnat .'", entraineur1 = "'.$entraineur1.'", entraineur2 = "'.$entraineur2.'", entrainement1 = '. $entrainement1 .', entrainement2 = '. $entrainement2 .', actif = '. $active .'
			WHERE
				id = '. $id .'
		';
		
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/***************************************
	**
	** Récupère la liste des catégories par l'id_equipe
	** 
	** Entrée : (Int) id_match
	** Sortie : (Array) 
	**
	***************************************/
	
	function recupListeCatByIdMatch($id_equipe) {
		$maReq = "
			SELECT 
				LC.id, LC.categorie, LC.type, LC.numero
			FROM 
				liste_categories AS LC
			WHERE 
				id = '".$id_equipe."'
		";
		
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			$d = mysql_fetch_array($q);
			
			return $d;
		}
		else
			return false;
	}
	
	/*****************************************************
	**
	** Ajoute un utilisateur en ligne dans la table
	** 
	** Entrée : (Int) $id, (Int) $id, (String) $page
	** Sortie : (Void)
	**
	******************************************************/
	
	function ajoutUserOnline($id, $ip, $page) {
		// Ajout de l'utlisateur
		$maReq = '	INSERT INTO users_online VALUES('. $id .', '. time() .','. $ip .',"'. $page .'") 
					ON DUPLICATE KEY UPDATE time = '. time() .' , id = '. $id .', page = "'. $page.'"';
		mysql_query($maReq) or die(mysql_error());
		
		// Suppression des anciens
		$time_max = time() - (60 * 5);
		$maReq2 = 'DELETE FROM users_online WHERE time < '. $time_max;
		mysql_query($maReq2) or die(mysql_error());
	}
	
	/*****************************************************
	**
	** Compte le nombre d'utilisateur en ligne
	** 
	** Entrée : (Void)
	** Sortie : (Int)
	**
	******************************************************/
	
	function nbr_users_online() {
		//Visiteurs
		$maReq = 'SELECT COUNT(*) AS nbr_visiteurs FROM users_online WHERE id = 0';
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		$total_visiteurs = $d['nbr_visiteurs'];
		
		$maReq = 'SELECT COUNT(*) AS nbr_connectes FROM users_online WHERE id <> 0';
		$q = mysql_query($maReq) or die(mysql_error());
		$d = mysql_fetch_array($q);
		$total_connectes = $d['nbr_connectes'];
		
		$total_utilisateurs = $total_visiteurs + $total_connectes;
		
		$texte = '<p>Il y a actuellement '. $total_utilisateurs .' utilisateur';
		if($total_utilisateurs>1)
			$texte .= 's';
		$texte .= ' en ligne (dont '.$total_connectes.' connecté';
		if($total_connectes>1)
			$texte .= 's';
		
		$texte .= ' et '.$total_visiteurs.' visiteur';
			
		if($total_visiteurs>1)
			$texte .= 's';
			
		$texte .= ').</p>';
		
		return $texte;
	}
	
	/*****************************************************
	**
	** Retourne la liste des menus
	** 
	** Entrée : (Void)
	** Sortie : (Array)
	**
	******************************************************/
	
	function liste_menu() {
		$liste = array();
		$maReq = 'SELECT * FROM menu WHERE parent = 0 ORDER BY ordre, nom';
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				$liste[] = $d;
				$maReq2 = 'SELECT * FROM menu WHERE parent = '.$d['id'].' ORDER BY ordre, nom';
				$q2 = mysql_query($maReq2) or die(mysql_error());
				if(mysql_num_rows($q2)>0) {
					while($d2 = mysql_fetch_array($q2)) {
						$liste[] = $d2;
					}
				}
			}
			return $liste;
		}
		else
			return false;
	}
	
	/*******************************************************************
	**
	** Ajoute un menu
	** 
	** Entrée : (String) Nom, (String) Url, (String) Image, (Int) Parent 
	** Sortie : (Booleen)
	**
	********************************************************************/
	
	function ajout_menu($nom, $url, $image, $parent) {
			
		$maReq = '
			INSERT INTO
				menu
			VALUES
				("", "'.$nom.'", "'.$url.'", "'.$image.'", "'.$parent.'", 0)
		';
		
		$q = mysql_query($maReq) or die(mysql_error());
		if($q) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/*******************************************************************
	**
	** Ajoute un menu
	** 
	** Entrée : (String) Nom, (String) Url, (String) Image, (Int) Parent 
	** Sortie : (Booleen)
	**
	********************************************************************/
	
	function aParent($id) {
			
		$maReq = 'SELECT * FROM menu WHERE id='.$id;
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				if($d['parent'] != 0){
					echo '--';
					aParent($d['parent']);
				}
			}
		}
	}
	
	/******************************************
	**
	** Retourne la même chaîne sans les accents
	** 
	** Entrée : (String) $string
	** Sortie : (String)
	**
	*******************************************/
	
	function stripAccents($string) {
		return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}
	
	/***************************************
	**
	** Retourne une variable mise en page
	** 
	** Entrée : (Mixed) $tab, (String) $nom
	** Sortie : (Mixed)
	**
	***************************************/
	
	function debug($tab, $nom = '') {
		echo '<br>'.$nom.' :<br>';
		echo '<pre>';
		print_r($tab);
		echo '</pre>';
	}
	
	/******************************
	**
	** Retourne la date + 7 jours
	** 
	** Entrée : (String) $date
	** Sortie : (String)
	**
	*******************************/
	
	function date_plus_7J($date) {
		$annee = substr($date, 0, 4);
		$mois = (substr($date, 4, 1) == 0) ? substr($date, 5, 1) : substr($date, 4, 2);
		$jour = substr($date, 6, 2);
		$annee_plus_J7 = $annee;
		$mois_plus_J7 = $mois;
		$jour_plus_J7 = $jour;
		
		switch($mois):
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
				$jour_plus_J7 = ($jour+7)%31;
			break;
			case 4:
			case 6:
			case 9:
			case 11:
				$jour_plus_J7 = ($jour+7)%30;
			break;
			case 2:
				if($annee%4==0):
					$jour_plus_J7 = ($jour+7)%29;
				else:
					$jour_plus_J7 = ($jour+7)%28;
				endif;
			break;
			case 12:
				$jour_plus_J7 = ($jour+7)%31;
			break;
		endswitch;
		
		if($jour_plus_J7<8)
			$mois_plus_J7 = $mois+1;
		if($mois_plus_J7==1 && $jour_plus_J7<8)
			$annee_plus_J7 = $annee+1;
		if(strlen($mois_plus_J7) == 1)
			$mois_plus_J7 = "0".$mois_plus_J7;
		if(strlen($jour_plus_J7) == 1)
			$jour_plus_J7 = "0".$jour_plus_J7;
		
		$new_date = $annee_plus_J7.$mois_plus_J7.$jour_plus_J7;
		
		return $new_date;
	}
	
	/******************************
	**
	** Retourne la date - 7 jours
	** 
	** Entrée : (String) $date
	** Sortie : (String)
	**
	*******************************/
	
	function date_moins_7J($date) {
		$annee = substr($date, 0, 4);
		$mois = (substr($date, 4, 1) == 0) ? substr($date, 5, 1) : substr($date, 4, 2);
		$jour = substr($date, 6, 2);
		$annee_moins_J7 = $annee;
		$mois_moins_J7 = $mois;
		$jour_moins_J7 = $jour;
		
		switch($mois):
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
				$jour_moins_J7 = ($jour-7+31)%31;
			break;
			case 4:
			case 6:
			case 9:
			case 11:
				$jour_moins_J7 = ($jour-7+31)%30;
			break;
			case 2:
				if($annee%4==0):
					$jour_moins_J7 = ($jour-7+29)%29;
				else:
					$jour_moins_J7 = ($jour-7+28)%28;
				endif;
			break;
			case 12:
				$jour_moins_J7 = ($jour-7+31)%31;
			break;
		endswitch;
		
		if($jour_moins_J7>24)
			$mois_moins_J7 = $mois-1;
		if($mois_moins_J7==12 && $jour_moins_J7>24)
			$annee_moins_J7 = $annee-1;
		if(strlen($mois_moins_J7) == 1)
			$mois_moins_J7 = "0".$mois_moins_J7;
		if(strlen($jour_moins_J7) == 1)
			$jour_moins_J7 = "0".$jour_moins_J7;
		
		$new_date = $annee_moins_J7.$mois_moins_J7.$jour_moins_J7;
		
		return $new_date;
	}
	
	/******************************
	**
	** Retourne la dernière version
	** 
	** Entrée : (Void)
	** Sortie : (String)
	**
	*******************************/
	
	function derniereVersion() {
		$maReq = 'SELECT * FROM versioning ORDER BY id DESC LIMIT 1';
		$q = mysql_query($maReq) or die(mysql_error());
		if(mysql_num_rows($q)==1) {
			$d = mysql_fetch_array($q);
			$version = $d['version'].'.'.$d['fonction'].'.'.$d['revision'];
		}
		
		return $version;
	}

	/*********************************
	**
	** Retourne le picto vrai ou faux
	** 
	** Entrée : (Bool)
	** Sortie : (String)
	**
	*********************************/
	
	function retournePictoBool($val) {
		if($val)
			$image = '<img src="/images/true.png" alt="Oui" />';
		else
			$image = '<img src="/images/false.png" alt="Non" />';
		
		return $image;
	}

	/*********************************
	**
	** Retourne le texte oui ou non
	** 
	** Entrée : (Bool)
	** Sortie : (String)
	**
	*********************************/
	
	function retourneTextBool($val) {
		if($val)
			$texte = 'Oui';
		else
			$texte = 'Non';
		
		return $texte;
	}

	/*********************************
	**
	** Retourne le nombre maximum de joueur
	** 
	** Entrée : (Int)
	** Sortie : (String)
	**
	*********************************/
	
	function retourneNbrJoueursMax($compet) {
		$nbr_joueurs_max = 0;

		switch($compet) {
			case 5:
				$nbr_joueurs_max = 25;
			break;

			case 3:
				$nbr_joueurs_max = 14;
			break;

			case 3:
			case 2:
			case 1:
			default:
				$nbr_joueurs_max = 12;
			break;
		}
		
		return $nbr_joueurs_max;
	}

?>