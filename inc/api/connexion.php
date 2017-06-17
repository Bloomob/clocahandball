<?php
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../connexion_bdd_pdo.php");
	include_once("../date.php");

	$UtilisateurManager = new UtilisateurManager($connexion);

	if(isset($_POST['login']) && isset($_POST['password'])) {
		$utilisateur = new Utilisateur(array());
        
		foreach ($_POST as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($utilisateur, $method)) {
				$utilisateur->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
			}
		}
		
		$userExiste = $UtilisateurManager->testConnexion($utilisateur);

		if($userExiste) {
			// $userExiste = $UtilisateurManager->retourne($utilisateur);
			$_SESSION['id'] =  $tab_connexion['id'];
			$_SESSION['nom'] = $tab_connexion['nom'];
			$_SESSION['prenom'] = $tab_connexion['prenom'];
			$_SESSION['rang'] = $tab_connexion['rang'];
			
			if($_SESSION['rang']==1) {
				header("Location: admin.php");
				exit;
			}
			
			header("Location: mon_profil.php");
			exit;
		}
	}
?>