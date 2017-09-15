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

	$ActuManager = new ActualiteManager($connexion);

	if(isset($_GET['id'])) {
        $actu = $ActuManager->retourneById($_GET['id']);

        $retour = array(
            'id' => $actu->getId(),
            'titre' => html_entity_decode($actu->getTitre(), ENT_QUOTES),
            'sous_titre' => html_entity_decode($actu->getSous_titre(), ENT_QUOTES),
            'contenu' => html_entity_decode($actu->getContenu(), ENT_QUOTES),
            'theme' => $actu->getTheme(),
            'tags' => $actu->getTags(),
            'id_auteur_crea' => $actu->getId_auteur_crea(),
            'id_auteur_modif' => $actu->getId_auteur_modif(),
            'id_auteur_publi' => $actu->getId_auteur_publi(),
            'date_creation' => $actu->getDate_creation(),
            'heure_creation' => $actu->getHeure_creation(),
            'date_modification' => $actu->getDate_modification(),
            'heure_modification' => $actu->getHeure_modification(),
            'date_publication' => $actu->getDate_publication(),
            'heure_publication' => $actu->getHeure_publication(),
            'image' => $actu->getImage(),
            'slider' => $actu->getSlider(),
            'importance' => $actu->getImportance(),
            'publie' => $actu->getPublie()
        );
        
        echo json_encode($retour);
        exit;
	}
    echo json_encode(false);
    exit;
?>