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

	$FonctionManager = new FonctionManager($connexion);

	if(isset($_GET['id'])) {
        $options = array('where' => 'id = ' .$_GET['id']);
        $fonction = $FonctionManager->retourne($options);
        
        $retour = array(
            'id' => $fonction->getId(),
            'type' => $fonction->getType(),
            'role' => $fonction->getRole(),
            'id_utilisateur' => $fonction->getId_utilisateur(),
            'annee_debut' => $fonction->getAnnee_debut(),
            'annee_fin' => $fonction->getAnnee_fin()
        );
        
        echo json_encode($retour);
        exit;
	}
    echo json_encode(false);
    exit;
?>