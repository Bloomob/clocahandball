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

	/** Id **/
	if(isset($_POST['id'])) {
		if(!empty($_POST['id'])) {
			$club['id'] = (int) $_POST['id'];
		}
		else {
			$erreur = true;
		}
	}

	$retour = array();
	
	if($ClubManager->supprimer(new Club($club)) !== false && !$erreur){
		$retour['message'] = "Le club a bien été supprimé !";
		$retour['erreur'] = $erreur;
	}
	else {
		$retour['message'] = "Le club n'a pas été supprimé !";
		$retour['erreur'] = $erreur;
	}
	echo json_encode($retour);
?>