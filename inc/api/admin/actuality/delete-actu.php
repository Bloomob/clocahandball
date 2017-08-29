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

	$ActualiteManager = new ActualiteManager($connexion);

	if(isset($_POST['id'])) {
		$actu = new Actualite(array());
		$actu->setId(intval($_POST['id']));
		$isDelete = $ActualiteManager->supprimer($actu);
        // var_dump($isDelete);

		echo $isDelete;
        exit;
	}
?>