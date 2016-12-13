<?php
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../inc/connexion_bdd_pdo.php");

	$MenuManager = new MenuManager($connexion);

	if(isset($_POST['menu'])) {
		$MenuManager->truncate();

		foreach ($_POST['menu'] as $key => $menu) {
			$MenuManager->ajouter(new Menu($menu));
		}
	}
?>