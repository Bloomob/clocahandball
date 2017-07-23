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

	$MatchManager = new $MatchManager($connexion);

	if(isset($_GET['id'])) {
        $match = $MatchManager->retourne($_GET['id']);
        
        $retour = array(
            'id' => $match->getId(),
            'categorie' => $match->getCategorie(),
            'date' => $match->getDate(),
            'heure' => $match->getHeure(),
            'competition' => $match->getCompetition(),
            'niveau' => $match->getNiveau(),
            'lieu' => $match->getLieu(),
            'gymnase' => $match->getGymnase(),
            'adversaires' => $match->getAdversaires(),
            'scores_dom' => $match->getScores_dom(),
            'scores_ext' => $match->getScores_ext(),
            'journee' => $match->getJournee(),
            'tour' => $match->getTour(),
            'joue' => $match->getJoue(),
            'arbitre' => $match->getArbitre(),
            'classement' => $match->getClassement()
        );
        
        echo json_encode($retour);
        exit;
	}
    echo json_encode(false);
    exit;
?>