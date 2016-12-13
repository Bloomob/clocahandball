<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	if(isset($_POST['raccourci']))
		$cat = htmlentities($_POST['raccourci'], ENT_NOQUOTES, "UTF-8");
	if(isset($_POST['numero']))
		$numero = htmlentities($_POST['numero'], ENT_NOQUOTES, "UTF-8");
	if(isset($_POST['id']))
		$id_prenom_nom = htmlentities($_POST['id'], ENT_NOQUOTES, "UTF-8");
	if(isset($_POST['nom']))
		$nom = htmlentities($_POST['nom'], ENT_NOQUOTES, "UTF-8");
	if(isset($_POST['prenom']))
		$prenom = htmlentities($_POST['prenom'], ENT_NOQUOTES, "UTF-8");
	if(isset($_POST['poste']))
		$poste = htmlentities($_POST['poste'], ENT_NOQUOTES, "UTF-8");
	$email = '';
		
	$erreur = true;
	$message = "Le joueur n'a pas été ajouté.";

	if($id_prenom_nom == 0) {
		if(existe_utilisateur($nom, $prenom)) {
			if(existe_joueur($nom, $prenom)) {
				$message = "Le joueur a déja une équipe.";
			}
			elseif(existe_numero($cat, $numero)) {
				$message = "Le numéro est déjà pris.";
			}
			else{
				if(ajout_joueur($cat, $numero, $nom, $prenom, $poste)) {
					$erreur = false;
				}
			}
		}
		else {
			if(ajout_utilisateur($nom, $prenom, $email)) {
				if(existe_numero($cat, $numero)) {
					$message = "Le numéro est déjà pris.";
				}
				else {
					if(ajout_joueur($cat, $numero, $nom, $prenom, $poste)) {
						$erreur = false;
					}
				}
			}
		}
	}
	else {
		if(existe_utilisateur($nom, $prenom)) {
			if(existe_joueur($nom, $prenom)) {
				$message = "Le joueur a déja une équipe.";
			}
			elseif(existe_numero($cat, $numero)) {
				$message = "Le numéro est déjà pris.";
			}
			else{
				if(ajout_joueur($cat, $numero, $nom, $prenom, $poste)) {
					$erreur = false;
				}
			}
		}
		else {
			if(ajout_utilisateur($nom, $prenom, $email)) {
				if(existe_numero($cat, $numero)) {
					$message = "Le numéro est déjà pris.";
				}
				else {
					if(ajout_joueur($cat, $numero, $nom, $prenom, $poste)) {
						$erreur = false;
					}
				}
			}
		}
	}
?>