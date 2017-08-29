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

	$FonctionManager = new FonctionManager($connexion);

	if(isset($_POST['data'])) {

		$fonction = new Fonction(array());

		foreach ($_POST['data'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($fonction, $method)) {
				$fonction->$method(htmlspecialchars_decode(htmlentities($value['value'], ENT_QUOTES, "UTF-8")));
			}
		}

		// var_dump($match);
		$fonctionId = $FonctionManager->ajouter($fonction);
        
        if($fonctionId) {
			echo true;
			exit;
		}
        echo false;
        exit;
	}
?>