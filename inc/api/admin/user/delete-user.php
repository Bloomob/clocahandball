<?php
    session_start();
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../../connexion_bdd_pdo.php");
	include_once("../../../date.php");

	$UtilisateurManager = new UtilisateurManager($connexion);

	if(isset($_POST['id'])) {
		$utilisateur = new Utilisateur(array());
		$utilisateur->setId(intval($_POST['id']));
		$isDelete = $UtilisateurManager->supprimer($utilisateur);

		echo $isDelete;
        exit;
	}
?>