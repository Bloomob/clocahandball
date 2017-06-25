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

	$EquipeManager = new EquipeManager($connexion);

	if(isset($_POST['id'])) {
		$equipe = new Equipe(array());
		$equipe->setId(intval($_POST['id']));
		$isDelete = $EquipeManager->supprimer($equipe);

		echo $isDelete;
        exit;
	}
?>