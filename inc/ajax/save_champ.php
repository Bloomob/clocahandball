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
	include_once("../../inc/date.php");

	$MatchManager = new MatchManager($connexion);
    $EquipeManager = new EquipeManager($connexion);

    $retour = array();

	if(isset($_POST['champ'])) {
		foreach($_POST['champ'] as $unMatch):
			$match = new Match( array() );
			foreach ($unMatch as $key => $value):
				$method = 'set'.ucfirst($key);

				if (method_exists($match, $method))
					$match->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
			endforeach;

			$option = array('where' => 'categorie='.$match->getCategorie());
			$uneEquipe = $EquipeManager->retourne($option);
			$niveau = $uneEquipe->getNiveau();
			$match->setNiveau($niveau);
			$match->setCompetition(1);

			if($MatchManager->verifier_date_match_equipe($match)):
				$retour[$match->getId()]["erreur"] = true;
				$retour[$match->getId()]["message"] = "L'équipe a déja un match à cette date";
				$retour[$match->getId()]["categorie"] = $match->getCategorie();
				$retour[$match->getId()]["date"] = $match->getDate();
			elseif($MatchManager->verifier_date_match_domicile($match)):
				$retour[$match->getId()]["erreur"] = true;
				$retour[$match->getId()]["message"] = "Un match est déja prévu à cette heure la";
				$retour[$match->getId()]["categorie"] = $match->getCategorie();
				$retour[$match->getId()]["date"] = $match->getDate();
			else:
				$idMatch = $MatchManager->ajouter($match);
				$unMatch = $MatchManager->retourne($idMatch);

				$retour[$idMatch]["erreur"] = false;
			endif;
		endforeach;
	} else {
		$retour["erreur"] = true;
	}

	echo json_encode($retour);
?>