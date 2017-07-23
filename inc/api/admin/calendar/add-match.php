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

	$MatchManager = new MatchManager($connexion);

	if(isset($_POST['data'])) {

		$match = new Match(array());

		foreach ($_POST['data'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($match, $method)) {
				$match->$method(htmlspecialchars_decode(htmlentities($value['value'], ENT_QUOTES, "UTF-8")));
			}
		}

		// var_dump($match);
		$matchId = $MatchManager->ajouter($match);
        
        if($matchId) {
			echo true;
			exit;
		}
        echo false;
        exit;
	}
?>