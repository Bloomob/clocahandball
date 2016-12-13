<?php
	session_start();
	include_once("connexion_bdd.php");
	include_once('fonctions.php');
	
	if(isset($_POST['titre']))
		$titre = $_POST['titre'];
	if(isset($_POST['contenu']))
		$contenu = $_POST['contenu'];
	if(isset($_POST['important']))
		$publie = $_POST['important'];
	if(isset($_POST['publie']))
		$publie = $_POST['publie'];
	if(isset($_POST['id_equipe']))
		$id_equipe = $_POST['id_equipe'];
	
	if(ajoutNews($id_equipe, $titre, $contenu, $_SESSION['id'], $important, $publie)) {
		echo "La news a bien &eacute;t&eacute; publi&eacute;e !";
	}
	else {
		echo "La news n'a pas &eacute;t&eacute; publi&eacute;e !";
	}
	
	

?>