<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	$erreur = false;
	
	/** Id **/
	if(isset($_POST['id'])) {
		if(!empty($_POST['id'])) {
			$id = $_POST['id'];
		}
		else {
			$erreur = true;
		}
	}	

	/** Catégorie **/
	if(isset($_POST['team_categorie'])) {
		if(!empty($_POST['team_categorie'])) {
			$categorie = $_POST['team_categorie'];
		}
		else {
			$erreur = true;
		}
	}	
	
	/** Jour **/
	if(isset($_POST['team_jour'])) {
		if(!empty($_POST['team_jour'])) {
			$jour = $_POST['team_jour'];
			if(strlen($jour) == 1)
				$jour = '0'. $jour;
		}
		else {
			$erreur = true;
		}
	}
	
	/** Mois **/
	if(isset($_POST['team_mois'])) {
		if(!empty($_POST['team_mois'])) {
			$mois = $_POST['team_mois'];
			if(strlen($mois) == 1)
				$mois = '0'. $mois;
		}
		else {
			$erreur = true;
		}
	}
	
	/** Année **/
	if(isset($_POST['team_annee'])) {
		if(!empty($_POST['team_annee'])) {
			$annee = $_POST['team_annee'];
		}
		else {
			$erreur = true;
		}
	}
	
	/** Heure **/
	if(isset($_POST['team_heure'])) {
		if(!empty($_POST['team_heure'])) {
			$heure = $_POST['team_heure'];
			if(strlen($heure) == 1)
				$heure = '0'. $heure;
		}
		else {
			$erreur = true;
		}
	}
	
	/** Minute **/
	if(isset($_POST['team_minute'])) {
		if(!empty($_POST['team_minute'])) {
			$minute = $_POST['team_minute'];
			if(strlen($minute) == 1)
				$minute = '0'. $minute;
		}
		else {
			$minute = '00';
		}
	}
	
	/** Lieu **/
	if(isset($_POST['team_lieu'])) {
		if(!empty($_POST['team_lieu'])) {
			$lieu = $_POST['team_lieu'];
		}
		else {
			$lieu = 0;
		}
	}	
	
	/** Gymnase **/
	if(isset($_POST['team_gymnase'])) {
		if(!empty($_POST['team_gymnase'])) {
			$gymnase = $_POST['team_gymnase'];
		}
		else {
			$gymnase = '';
		}
	}
	
	/** Adresse **/
	if(isset($_POST['team_adresse'])) {
		if(!empty($_POST['team_adresse'])) {
			$adresse = $_POST['team_adresse'];
		}
		else {
			$adresse = '';
		}
	}
	
	/** Ville **/
	if(isset($_POST['team_ville'])) {
		if(!empty($_POST['team_ville'])) {
			$ville = $_POST['team_ville'];
		}
		else {
			$ville = '';
		}
	}

	/** Code Postal **/
	if(isset($_POST['team_code_postal'])) {
		if(!empty($_POST['team_code_postal'])) {
			$code_postal = $_POST['team_code_postal'];
		}
		else {
			$code_postal = 0;
		}
	}

	/** Compétition **/
	if(isset($_POST['team_competition'])) {
		if(!empty($_POST['team_competition'])) {
			$competition = $_POST['team_competition'];
		}
		else {
			$competition = 0;
		}
	}

	/** Niveau **/
	if(isset($_POST['team_niveau'])) {
		if(!empty($_POST['team_niveau'])) {
			$niveau = $_POST['team_niveau'];
		}
		else {
			$niveau = 0;
		}
	}
	
	/** Journée **/
	if(isset($_POST['team_journee'])) {
		if(!empty($_POST['team_journee'])) {
			$journee = $_POST['team_journee'];
		}
		else {
			$journee = 0;
		}
	}
	
	/** Tour **/
	if(isset($_POST['team_tour'])) {
		if(!empty($_POST['team_tour'])) {
			$tour = $_POST['team_tour'];
		}
		else {
			$tour = '';
		}
	}

	/** Adversaires **/
	for($i=1; $i<4; $i++) {
		if(isset($_POST['team_adversaire'.$i])) {
			$adversaire = 'adversaire'.$i;
			if(!empty($_POST['team_adversaire'.$i])) {
				$$adversaire = $_POST['team_adversaire'.$i];
			}
			else {
				$$adversaire = '';
			}
		}
	}
	
	/** Scores Dom **/
	for($i=1; $i<4; $i++) {
		if(isset($_POST['team_dom'.$i])) {
			$dom = 'dom'.$i;
			if(!empty($_POST['team_dom'.$i])) {
				$$dom = $_POST['team_dom'.$i];
			}
			else {
				$$dom = 0;
			}
		}
	}
	
	/** Scores Ext **/
	for($i=1; $i<4; $i++) {
		if(isset($_POST['team_ext'.$i])) {
			$ext = 'ext'.$i;
			if(!empty($_POST['team_ext'.$i])) {
				$$ext = $_POST['team_ext'.$i];
			}
			else {
				$$ext = 0;
			}
		}
	}
	
	/** Joué ? **/
	if(isset($_POST['team_joue'])) {
		if(!empty($_POST['team_joue'])) {
			$joue = $_POST['team_joue'];
		}
		else {
			$joue = 0;
		}
	}
	
	/** Arbitre **/
	if(isset($_POST['team_arbitre'])) {
		if(!empty($_POST['team_arbitre'])) {
			$arbitre = $_POST['team_arbitre'];
		}
		else {
			$arbitre = '';
		}
	}
	
	/** Classement **/
	if(isset($_POST['team_classement'])) {
		if(!empty($_POST['team_classement'])) {
			$classement = $_POST['team_classement'];
		}
		else {
			$classement = '';
		}
	}
	
	$newDate = $annee . $mois . $jour;
	$newHeure = $heure . $minute;
		
	// echo '<pre>'; var_dump($categorie, $newDate, $newHeure, $lieu, $gymnase, $adresse, $ville, $code_postal, $competition, $niveau, $journee, $tour, $adversaire1, $adversaire2, $adversaire3, $dom1, $ext1, $dom2, $ext2, $dom3, $ext3, $joue, $arbitre, $classement); echo '</pre>';
	// exit;
	
	if(update_match($id, $categorie, $newDate, $newHeure, $lieu, $gymnase, $adresse, $ville, $code_postal, $competition, $niveau, $journee, $tour, $adversaire1, $adversaire2, $adversaire3, $dom1, $ext1, $dom2, $ext2, $dom3, $ext3, $joue, $arbitre, $classement) && !$erreur){
		echo "Le match a bien &eacute;t&eacute; mis &agrave; jour !";
	}
	else {
		echo "Le match n'a pas &eacute;t&eacute; mis &agrave; jour !";
	}
?>