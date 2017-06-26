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
	$HoraireManager = new HoraireManager($connexion);

	if(isset($_POST['data'])) {
		$horaire = new Horaire(array());

		$listeEntrainements = $_POST['data']['entrainements'];
		$_POST['data']['entrainements'] = array();
		foreach ($listeEntrainements as $entrainements) {
			foreach ($entrainements as $key => $value) {
				$method = 'set'.ucfirst(substr($key, 0, -2));

				if (method_exists($horaire, $method)) {
					$horaire->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
				}
			}
            $horaire->setCategorie($_POST['data']['categorie']);
            $horaire->setAnnee($_POST['data']['annee']);
            // var_dump($horaire);
            if($horaire->getId() == 0 && $horaire->getJour() != 0) {
                $horaireId = $HoraireManager->ajouter($horaire);
            } else if($horaire->getId() != 0 && $horaire->getJour() == 0) {
                $HoraireManager->supprimer($horaire);
            } else {
                $HoraireManager->modifier($horaire);
                $horaireId = $horaire->getId();
            }
			if($horaire->getJour() != 0) {
				$_POST['data']['entrainements'][] = $horaireId;
			}
		}
        
		$equipe = new Equipe(array());

		$_POST['data']['entraineurs'] = implode(',', $_POST['data']['entraineurs']);
		$_POST['data']['entrainements'] = implode(',', $_POST['data']['entrainements']);
		$_POST['data']['actif'] = 1;

		foreach ($_POST['data'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($equipe, $method)) {
				$equipe->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
			}
		}
		var_dump($equipe);
        
		$equipeId = $EquipeManager->modifier($equipe);
		var_dump($equipeId);
        
        if($equipeId) {
			echo true;
			exit;
		}
        echo false;
        exit;
	}
?>