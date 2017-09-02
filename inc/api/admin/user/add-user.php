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

	$UtilisateurManager = new UtilisateurManager($connexion);

	if(isset($_POST['data'])) {

		// Ajout de l'utilisateur
		$utilisateur = new Utilisateur(array());

		foreach ($_POST['data'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($utilisateur, $method)) {
				$utilisateur->$method(htmlspecialchars_decode(htmlentities($value['value'], ENT_QUOTES, "UTF-8")));
			}
		}
        if($utilisateur->getMail() != '' && $utilisateur->getMot_de_passe() != '')
            $utilisateur->setActif(1);
        else
            $utilisateur->setActif(0);
        
        $utilisateur->setListe_equipes_favorites(0);
        
        
        // var_dump($utilisateur);
		$userId = $UtilisateurManager->ajouter($utilisateur);
        
		if($userId) {			
			echo true;
			exit;
		}
        echo false;
        exit;
	}
?>