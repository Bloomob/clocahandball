<?php
    echo 'connexion.php';
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../inc/connexion_bdd_pdo.php");
	include_once("../../inc/date.php");

	$UtilisateurManager = new UtilisateurManager($connexion);

	if(isset($_POST['login']) && isset($_POST['password']) {
		$utilisateur = new Utilisateur(array());
        
		foreach ($_POST as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($utilisateur, $method)) {
				$utilisateur->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
			}
		}
		
		$UtilisateurManager->testConnexion($utilisateur);

		echo 'OK';
	}
?>