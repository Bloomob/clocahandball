<?php
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../inc/connexion_bdd_pdo.php");

	$ClubManager = new ClubManager($connexion);
	
	$erreur = false;
	$club = array();

	/** Nom **/
	if(isset($_POST['nom'])) {
		if(!empty($_POST['nom'])) {
			$club['nom'] = htmlspecialchars_decode(htmlentities($_POST['nom'], ENT_QUOTES, "UTF-8"));
		}
		else {
			$erreur = true;
		}
	}	
	
	/** Raccouci **/
	if(isset($_POST['raccourci'])) {
		if(!empty($_POST['raccourci'])) {
			$club['raccourci'] = htmlspecialchars_decode(htmlentities($_POST['raccourci'], ENT_QUOTES, "UTF-8"));
		}
		else {
			$erreur = true;
		}
	}
	
	/** Numéro **/
	if(isset($_POST['numero'])) {
		if(!empty($_POST['numero']) && is_numeric($_POST['numero'])) {
			$club['numero'] = $_POST['numero'];
		}
		else {
			$erreur = true;
		}
	}
	
	/** Ville **/
	if(isset($_POST['ville'])) {
		if(!empty($_POST['ville'])) {
			$club['ville'] = htmlspecialchars_decode(htmlentities($_POST['ville'], ENT_QUOTES, "UTF-8"));
		}
		else {
			$erreur = true;
		}
	}
	
	/** Code Postal **/
	if(isset($_POST['code_postal'])) {
		if(!empty($_POST['code_postal']) && is_numeric($_POST['code_postal'])) {
			$club['code_postal'] = $_POST['code_postal'];
		}
		else {
			$erreur = true;
		}
	}	
	
	/** Actif ? **/
	if(isset($_POST['actif'])) {
		if(!empty($_POST['actif'])) {
			if($_POST['actif'] == 'true')
				$club['actif'] = 1;
			else
				$club['actif'] = 0;
		}
		else {
			$club['actif'] = 0;
		}
	}
	
	if($ClubManager->ajouter(new Club($club)) && !$erreur){
		echo "Le club a bien &eacute;t&eacute; ajout&eacute; !";
	}
	else {
		echo "Le club n'a pas &eacute;t&eacute; ajout&eacute; !";
	}
?>