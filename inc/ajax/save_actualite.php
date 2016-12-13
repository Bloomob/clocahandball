<?php
	session_start();

	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../inc/connexion_bdd_pdo.php");
	include_once("../../inc/date.php");

	$ActuManager = new ActualiteManager($connexion);
	$creation = false;

	if(isset($_POST['actualite'])):
		if(isset($_POST['actualite']['id']) && $_POST['actualite']['id'] > 0)
			$actualite = $ActuManager->retourneById($_POST['actualite']['id']);
		else
			$actualite = new Actualite( array() );

		foreach ($_POST['actualite'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($actualite, $method)) {
				$actualite->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
			}
		}
		if($actualite->getDate_creation() == 0) {
			$actualite->setDate_creation(date('Ymd'));
			$actualite->setHeure_creation(date('Hi'));
			$actualite->setId_auteur_crea($_SESSION['id']);
			$creation = true;
		}
		else {
			$actualite->setDate_modification(date('Ymd'));
			$actualite->setheure_modification(date('Hi'));
			$actualite->setId_auteur_modif($_SESSION['id']);
		}
		if($actualite->getDate_publication() != 0) {
			$actualite->setId_auteur_publi($_SESSION['id']);
		}
		
		if(!$creation):
			$ActuManager->modifier($actualite);
			$uneActu = $ActuManager->retourneById($actualite->getId());
		else:
			$actu = $ActuManager->ajouter($actualite);
			$uneActu = $ActuManager->retourneById(intval($actu));
		endif;
		$retour["actu"] = $uneActu;
		$retour["erreur"] = false;
		// fin cas ajout ou de modif
	else:
		$retour["erreur"] = true;
	endif;
	// fin si l'actualité existe

	echo json_encode($retour);
?>