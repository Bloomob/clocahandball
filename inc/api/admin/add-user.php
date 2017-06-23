<?php
    session_start();
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../connexion_bdd_pdo.php");
	include_once("../../date.php");

	$UtilisateurManager = new UtilisateurManager($connexion);

	if(isset($_POST['data'])) {

		// Ajout de l'utilisateur
		$utilisateur = new Utilisateur(array());

		foreach ($_POST['data'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($utilisateur, $method)) {
				$utilisateur->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
			}
		}
		var_dump($utilisateur);
		$userId = $UtilisateurManager->ajouter($utilisateur);
		var_dump($userId);
	}
	/*
		$userId = $UtilisateurManager->testConnexion($utilisateur);
        
		if(is_array($userId)) {
            $utilisateur = $UtilisateurManager->retourneById($userId['id']);
			$_SESSION['id'] =  $utilisateur->getId();
			$_SESSION['nom'] = $utilisateur->getNom();
			$_SESSION['prenom'] = $utilisateur->getPrenom();
			$_SESSION['rang'] = $utilisateur->getRang();
			
			echo true;
			exit;
		}
        echo false;
        exit;
	*/
?>