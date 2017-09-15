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

	$ActuManager = new ActualiteManager($connexion);

	if(isset($_POST['data'])) {
		$actu = $ActuManager->retourneById($_POST['data']['id']['value']);

		foreach ($_POST['data'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($actu, $method)) {
				$actu->$method(htmlspecialchars_decode(htmlentities($value['value'], ENT_QUOTES, "UTF-8")));
			}
		}
		$actu->setId_auteur_modif($_SESSION['id']);
		$actu->setDate_modification(intval(date('Ymd')));
		$actu->setHeure_modification(intval(date('Hi')));
		// var_dump($match);
        
		$actuId = $ActuManager->modifier($actu);
		// var_dump($matchId);
        
        if($actuId) {
			echo true;
			exit;
		}
        echo false;
        exit;
	}
?>