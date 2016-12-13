<?php
	//connect to your database
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	include_once('../constantes.php');

	$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

	$liste_joueurs_auto = liste_utilisateurs_auto($term);
	foreach($liste_joueurs_auto as $unJoueur) {
		$row['id'] = $unJoueur['id'];
		$row['value'] = utf8_encode(html_entity_decode($unJoueur['prenom'].' '.$unJoueur['nom']));
		$row_set[] = $row;
	}
	
	echo json_encode($row_set);//format the array into json data
?>