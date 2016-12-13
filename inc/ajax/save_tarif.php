<?php
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../inc/connexion_bdd_pdo.php");
	include_once("../../inc/date.php");

	$TarifManager = new TarifManager($connexion);
	$CategorieManager = new CategorieManager($connexion);

	if(isset($_POST['tarif'])) {
		$tarif = new Tarif( array() );

		foreach ($_POST['tarif'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($tarif, $method)) {
				$tarif->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
			}
		}
		
		$TarifManager->ajouter($tarif);

		$options = array('where' => 'annee = '.retourne_annee(), 'orderby' => 'prix_old DESC');
		$listeTarifs = $TarifManager->retourneListe($options);
		echo 'OK';
	}
?>