<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	if(isset($_POST['utilisateur_nom']))
		$nom = htmlentities($_POST['utilisateur_nom'], ENT_NOQUOTES, "UTF-8");
	if(isset($_POST['utilisateur_prenom']))
		$prenom = htmlentities($_POST['utilisateur_prenom'], ENT_NOQUOTES, "UTF-8");
	if(isset($_POST['utilisateur_email']))
		$email = htmlentities($_POST['utilisateur_email'], ENT_NOQUOTES, "UTF-8");
		
	$erreur = true;

	if(!existe_utilisateur($nom, $prenom)) {
		if(modif_utilisateur($nom, $prenom, $email)) {
			$erreur = false;
		}
	}
?>