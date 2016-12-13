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
	include_once("../../inc/fonctions.php");
	include_once("../../inc/constantes.php");
	include_once("../../inc/date.php");

	$EquipeManager = new EquipeManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$RoleManager = new RoleManager($connexion);
	$HoraireManager = new HoraireManager($connexion);

	if(isset($_POST['equipe'])):
		$equipe = new Equipe( array() );

		foreach ($_POST['equipe'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($equipe, $method)) {
				$equipe->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
			}
		}
		
		if($equipe->getAnnee() == 0) {
			$equipe->setAnnee($annee_actuelle);
		}
		$equipe->setActif(1);

		// var_dump($equipe);

		if($equipe->getId() > 0):
			/*
			$EquipeManager->modifier($equipe);
			$uneEquipe = $EquipeManager->retourne($equipe->getId());
			
			*/
		else:
			$EquipeManager->ajouter($equipe);

			$options = array('orderby' => 'annee DESC, categorie');
			$listeEquipes = $EquipeManager->retourneListe($options);
		endif;
		// fin cas ajout
	endif;
	// fin si l'equipe existe
?>