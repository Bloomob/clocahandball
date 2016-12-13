<?php
	include_once("connexion_bdd.php");
	include_once('fonctions.php');
	
	$erreur = false;
	$categorie = 0;
	$niveau = 0;
	$championnat = 0;
	$entraineur1 = 0;
	$entraineur2 = 0;
	$active = 0;
	
	/** Catégorie **/
	if(isset($_POST['team_categorie'])) {
		if(!empty($_POST['team_categorie'])) {
			$categorie = $_POST['team_categorie'];
		}
		else {
			$erreur = true;
		}
	}

	/** Niveau **/
	if(isset($_POST['team_niveau'])) {
		if(!empty($_POST['team_niveau']) || $_POST['team_niveau']==0) {
			$niveau = $_POST['team_niveau'];
		}
		else {
			$erreur = true;
		}
	}
	
	/** Championnat **/
	if(isset($_POST['team_championnat'])) {
		if(!empty($_POST['team_championnat']) || $_POST['team_championnat']==0) {
			$championnat = $_POST['team_championnat'];
		}
		else {
			$erreur = true;
		}
	}
	
	/** Entraineur 1 **/
	if(isset($_POST['team_entraineur1'])) {
		if(!empty($_POST['team_entraineur1'])) {
			$entraineur1 = $_POST['team_entraineur1'];
		}
		else {
			$erreur = true;
		}
	}
	
	/** Entraineur 2 **/
	if(isset($_POST['team_entraineur2'])) {
		if(!empty($_POST['team_entraineur2']) || $_POST['team_entraineur2']==0) {
			$entraineur2 = $_POST['team_entraineur2'];
		}
		else {
			$erreur = true;
		}
	}
	
	/** Joué ? **/
	if(isset($_POST['team_active'])) {
		if(!empty($_POST['team_active'])) {
			$active = $_POST['team_active'];
		}
	}
	
	// var_dump($categorie, $niveau, $championnat, $entraineur1, $entraineur2, $active); exit;
	if(!$erreur) {
		if(ajout_equipe($categorie, $niveau, $championnat, $entraineur1, $entraineur2, $active)){
			echo "L'équipe a bien &eacute;t&eacute; ajout&eacute; !";
		}
		else {
			echo "L'équipe n'a pas &eacute;t&eacute; ajout&eacute; !";
		}
	}
	else {
		echo "L'équipe n'a pas &eacute;t&eacute; ajout&eacute; !";
	}
?>