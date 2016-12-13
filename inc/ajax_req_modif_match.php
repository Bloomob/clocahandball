<?php
	include_once("connexion_bdd.php");
	include_once('fonctions.php');
	
	if(isset($_POST['id']))
		$id_match = $_POST['id'];
	if(isset($_POST['team_categorie']))
		$categorie = $_POST['team_categorie'];
	if(isset($_POST['team_jour'])) {
		$jour = $_POST['team_jour'];
		if(strlen($jour) == 1)
			$jour = '0'. $jour;
	}
	else {
		$jour = date('d', time());
	}
	if(isset($_POST['team_mois'])) {
		$mois = $_POST['team_mois'];
		if(strlen($mois) == 1)
			$mois = '0'. $mois;
	}
	else {
		$mois = date('m', time());
	}
	if(isset($_POST['team_annee'])) {
		$annee = $_POST['team_annee'];
	}
	else {
		$annee = date('Y', time());
	}
	if(isset($_POST['team_heure'])) {
		$heure = $_POST['team_heure'];
		if(strlen($heure) == 1)
			$heure = '0'. $heure;
	}
	else {
		$heure = date('H', time());
	}
	if(isset($_POST['team_minute'])) {
		$minute = $_POST['team_minute'];
		if(strlen($minute) == 1)
			$minute = '0'. $minute;
	}
	else {
		$minute = date('i', time());
	}
	if(isset($_POST['team_lieu']))
		$lieu = $_POST['team_lieu'];
	if(isset($_POST['team_gymnase']))
		$gymnase = $_POST['team_gymnase'];
	if(isset($_POST['team_adresse']))
		$adresse = $_POST['team_adresse'];
	if(isset($_POST['team_ville']))
		$ville = $_POST['team_ville'];
	if(isset($_POST['team_code_postal']))
		$code_postal = $_POST['team_code_postal'];
	if(isset($_POST['team_competition']))
		$competition = $_POST['team_competition'];
	if(isset($_POST['team_niveau']))
		$niveau = $_POST['team_niveau'];
	if(isset($_POST['team_journee']))
		$journee = $_POST['team_journee'];
	if(isset($_POST['team_tour']))
		$tour = $_POST['team_tour'];
	if(isset($_POST['team_adversaire1']))
		$adversaire1 = $_POST['team_adversaire1'];
	if(isset($_POST['team_adversaire2']))
		$adversaire2 = $_POST['team_adversaire2'];
	if(isset($_POST['team_adversaire3']))
		$adversaire3 = $_POST['team_adversaire3'];
	if(isset($_POST['team_dom1']))
		$dom1 = $_POST['team_dom1'];
	if(isset($_POST['team_dom2']))
		$dom2 = $_POST['team_dom2'];
	if(isset($_POST['team_dom3']))
		$dom3 = $_POST['team_dom3'];
	if(isset($_POST['team_ext1']))
		$ext1 = $_POST['team_ext1'];
	if(isset($_POST['team_ext2']))
		$ext2 = $_POST['team_ext2'];
	if(isset($_POST['team_ext3']))
		$ext3 = $_POST['team_ext3'];
	if(isset($_POST['team_joue']))
		$joue = $_POST['team_joue'];
	if(isset($_POST['team_arbitre']))
		$arbitre = $_POST['team_arbitre'];
	if(isset($_POST['team_classement']))
		$classement = $_POST['team_classement'];
	
	$newDate = $annee . $mois . $jour;
	$newHeure = $heure . $minute;
		
	// var_dump($joue);
	
	if(update_match($id_match, $categorie, $newDate, $newHeure, $lieu, $gymnase, $adresse, $ville, $code_postal, $competition, $niveau, $journee, $tour, $adversaire1, $adversaire2, $adversaire3, $dom1, $ext1, $dom2, $ext2, $dom3, $ext3, $joue, $arbitre, $classement)){
		echo "Le match a bien &eacute;t&eacute; mis &agrave; jour !";
	}
	else {
		echo "Le match n'a pas &eacute;t&eacute; mis &agrave; jour !";
	}
?>