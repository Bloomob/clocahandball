<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	$erreur = false;
	$tab = array();
	
	
	if(isset($_POST)) {
		foreach($_POST as $key => $val)
		if(!empty($val)) {
			$tab[0][$key] = $val;
		}
		else {
			$erreur = true;
		}
	}
	
	// var_dump($categorie, $niveau, $championnat, $entraineur1, $entraineur2, $entrainement1, $entrainement2, $active); exit;
	if(!$erreur) {
		if(ajout_fonction($tab)){
			echo "La fonction a bien &eacute;t&eacute; ajout&eacute;e !";
		}
		else {
			echo "La fonction n'a pas &eacute;t&eacute; ajout&eacute;e !";
		}
	}
	else {
		echo "La fonction n'a pas &eacute;t&eacute; ajout&eacute;e !";
	}
?>