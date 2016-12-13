<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	$erreur = false;
	$id = 0;
	$categorie = 0;
	$niveau = 0;
	$championnat = 0;
	$entraineur1 = 0;
	$entraineur2 = 0;
	$entrainement1 = 0;
	$entrainement2 = 0;
	$active = 0;
	
	/** Id **/
	if(isset($_POST['team_id'])) {
		if(!empty($_POST['team_id'])) {
			$id = $_POST['team_id'];
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
	
	if(existe_equipe($id) || $erreur) {
		if(modif_equipe($id, $categorie, $niveau, $championnat, $entraineur1, $entraineur2, $entrainement1, $entrainement2, $active)) {
			echo "L'&eacute;quipe a bien &eacute;t&eacute; modifi&eacute;e !";
		}
		else {
			echo "L'&eacute;quipe n'a pas &eacute;t&eacute; modifi&eacute;e !";
		}
	}
	else {
		echo "L'&eacute;quipe n'existe pas ou une erreur de saisie a &eacute;t&eacute; detect&eacute;e !";
	}
?>