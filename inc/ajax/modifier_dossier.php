<?php
	session_start();
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	$erreur = false;
	
	if(isset($_POST['dossiers_id']))
		$id = htmlspecialchars_decode(htmlentities($_POST['dossiers_id'], ENT_QUOTES, "UTF-8"));
	if(isset($_POST['dossiers_titre']))
		$titre = htmlspecialchars_decode(htmlentities($_POST['dossiers_titre'], ENT_QUOTES, "UTF-8"));
	if(isset($_POST['dossiers_sous_titre']))
		$sous_titre = htmlspecialchars_decode(htmlentities($_POST['dossiers_sous_titre'], ENT_QUOTES, "UTF-8"));
	if(isset($_POST['dossiers_contenu']))
		$contenu = htmlspecialchars_decode(htmlentities($_POST['dossiers_contenu'], ENT_QUOTES, "UTF-8"));
	if(isset($_POST['dossiers_theme']))
		$theme = htmlspecialchars_decode(htmlentities($_POST['dossiers_theme'], ENT_QUOTES, "UTF-8"));
	if(isset($_POST['dossiers_image']))
		$image = htmlspecialchars_decode(htmlentities($_POST['dossiers_image'], ENT_QUOTES, "UTF-8"));
	if(isset($_POST['dossiers_publie']))
		$publie = htmlspecialchars_decode(htmlentities($_POST['dossiers_publie'], ENT_QUOTES, "UTF-8"));
	
	if(existe_idDossier($id)) {
		if(modif_dossier($id, $titre, $sous_titre, $contenu, $theme, $image, $publie))
			echo "Le dossier a bien &eacute;t&eacute; modifi&eacute;e !";
		else
			echo "Le dossier n'a pas &eacute;t&eacute; modifi&eacute;e !";
	}
	else
		echo "Le dossier n'a pas &eacute;t&eacute; modifi&eacute;e !";
?>