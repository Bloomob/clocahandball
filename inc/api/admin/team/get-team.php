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

	$EquipeManager = new EquipeManager($connexion);
	$HoraireManager = new HoraireManager($connexion);

	if(isset($_GET['id'])) {
        $options = array('where' => 'id = '. $_GET['id']);
        $equipe = $EquipeManager->retourne($options);
        
        $retour = array(
            'id' => $equipe->getId(),
            'categorie' => $equipe->getCategorie(),
            'niveau' => $equipe->getNiveau(),
            'championnat' => $equipe->getChampionnat(),
            'annee' => $equipe->getAnnee(),
            'entraineurs' => explode(',', $equipe->getEntraineurs()),
            'entrainements' => array()
        );
        
        $options = array('where' => 'id IN ('. $equipe->getEntrainements() .')');
        $listeHoraires = $HoraireManager->retourneListe($options);
        // var_dump($listeHoraires);
        
        $i = 1;
        foreach($listeHoraires as $horaire):
            $retour['entrainements'][$i - 1]['id_'. $i] = $horaire->getId();
            $retour['entrainements'][$i - 1]['jour_'. $i] = $horaire->getJour();
            $retour['entrainements'][$i - 1]['heure_debut_'. $i] = $horaire->getHeure_debut();
            $retour['entrainements'][$i - 1]['heure_fin_'. $i] = $horaire->getHeure_fin();
            $retour['entrainements'][$i - 1]['gymnase_'. $i] = $horaire->getGymnase();
            $i++;
        endforeach;
        
        echo json_encode($retour);
        exit;
	}
    echo json_encode(false);
    exit;
?>