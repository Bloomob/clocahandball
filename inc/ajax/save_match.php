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

	$MatchManager = new MatchManager($connexion);
    $EquipeManager = new EquipeManager($connexion);

    $retour = array();

	if(isset($_POST['match'])) {
		$match = new Match( array() );

		foreach ($_POST['match'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($match, $method)) {
				$match->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
			}
		}

		
		if($match->getCompetition() != 2){
			$options = array('where' => 'categorie='.$match->getCategorie());
			$uneEquipe = $EquipeManager->retourne($options);
			$niveau = $uneEquipe->getNiveau();
			$match->setNiveau($niveau);
		} else {
			$match->setNiveau(3);
		}



		if($MatchManager->verifier_date_match_equipe($match)) {
			$retour["erreur"] = true;
			$retour["message"] = "L'équipe a déja un match à cette date";
			$retour["match"]["id"] = $match->getId();
			$retour["match"]["categorie"] = $match->getCategorie();
			$retour["match"]["date"] = $match->getDate();
		}
		elseif($MatchManager->verifier_date_match_domicile($match)) { 
			$retour["erreur"] = true;
			$retour["message"] = "Un match est déja prévu à cette heure la";
			$retour["match"]["id"] = $match->getId();
			$retour["match"]["categorie"] = $match->getCategorie();
			$retour["match"]["date"] = $match->getDate();
		}
		elseif($match->getId()>0) {
			$MatchManager->modifier($match);
			$unMatch = $MatchManager->retourne($match->getId());

			$retour["erreur"] = false;
			$retour["match"]["id"] = $unMatch->getId();
			$retour["match"]["categorie"] = $unMatch->getCategorie();
		}
		else {
			$idMatch = $MatchManager->ajouter($match);
			$unMatch = $MatchManager->retourne($idMatch);

			$retour["erreur"] = false;
			$retour["match"]["id"] = $idMatch;
			$retour["match"]["categorie"] = $unMatch->getCategorie();
		}
	} else {
		$retour["erreur"] = true;
	}
	echo json_encode($retour);
?>