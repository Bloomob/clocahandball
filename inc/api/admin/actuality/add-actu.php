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

		$actu = new Actualite(array());
		$d = $_POST['data'];

		foreach ($d as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($actu, $method)) {
				$actu->$method(htmlspecialchars_decode(htmlentities($value['value'], ENT_QUOTES, "UTF-8")));
			} elseif ($key == 'publication') {
				// Gestion de la date et de l'heure
				if(!$value['value']) {
					$actu->setDate_creation(intval(date('Ymd')));
					$actu->setHeure_creation(intval(date('Hi')));

					if($d['publie']['value']) {
						$actu->setDate_publication(intval(date('Ymd')));
						$actu->setHeure_publication(intval(date('Hi')));
					}
				} else {
					$actu->setDate_creation(intval(htmlspecialchars_decode(htmlentities($d['date']['value'], ENT_QUOTES, "UTF-8"))));
					$actu->setHeure_creation(intval(htmlspecialchars_decode(htmlentities($d['heure']['value'], ENT_QUOTES, "UTF-8"))));

					if($d['publie']['value']) {
						$actu->setDate_publication(intval(htmlspecialchars_decode(htmlentities($d['date']['value'], ENT_QUOTES, "UTF-8"))));
						$actu->setHeure_publication(intval(htmlspecialchars_decode(htmlentities($d['heure']['value'], ENT_QUOTES, "UTF-8"))));
					}
				}
			}
		}
		$actu->setId_auteur_crea($_SESSION['id']);
		if($actu->getPublie()) {
			$actu->setId_auteur_publi($_SESSION['id']);
		}

		// var_dump($actu);
		$actuId = $ActuManager->ajouter($actu);
        
        if($actuId) {
			echo true;
			exit;
		}
        echo false;
        exit;
	}
?>