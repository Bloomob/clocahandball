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

	$ActuManager = new ActualiteManager($connexion);

	if(isset($_POST['id'])):
		$uneActu = new Actualite(array('id' => $_POST['id']));

		if($ActuManager->supprimer($uneActu) !== false)
			echo "Cette actualité a bien été supprimée !";
		else 
			echo "Cette actualité n'a pas été supprimée !";
	else:
		echo "Cette actualité n'existe pas !";
	endif;
?>