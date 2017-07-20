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

	$TarifManager = new TarifManager($connexion);

	if(isset($_POST['data'])) {

		$tarif = new Tarif(array());

		foreach ($_POST['data'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($tarif, $method)) {
				if ($key == 'categorie'):
					if (count($value['value'])  > 1):
						$tarif->setGenre(0);
					else:
						$tarif->setGenre(1);
					endif;
					$categorie = implode($value['value'], ',');
					$tarif->$method(htmlspecialchars_decode(htmlentities($categorie, ENT_QUOTES, "UTF-8")));
				else:
					$tarif->$method(htmlspecialchars_decode(htmlentities($value['value'], ENT_QUOTES, "UTF-8")));
				endif;
			}
		}
		// var_dump($tarif);
		
		$tarifId = $TarifManager->ajouter($tarif);
        
        if($tarifId) {
			echo true;
			exit;
		}
        echo false;
        exit;
	}
?>