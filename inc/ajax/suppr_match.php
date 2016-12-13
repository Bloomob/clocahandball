<?php
	session_start();

	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../inc/connexion_bdd_pdo.php");
	include_once("../../inc/date.php");

	$MatchManager = new MatchManager($connexion);

	if(isset($_POST['id'])):
		$unMatch = new Match(array('id' => $_POST['id']));

		if($MatchManager->supprimer($unMatch) !== false)
			echo "Ce match a bien été supprimé !";
		else 
			echo "Ce match n'a pas été supprimé !";
	else:
		echo "Ce match n'existe pas !";
	endif;
?>