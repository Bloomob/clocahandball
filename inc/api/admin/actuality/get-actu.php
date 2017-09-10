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

	$ActuManager = new $ActuManager($connexion);

	if(isset($_GET['id'])) {
        $actu = $ActuManager->retourne($_GET['id']);
        
        $retour = array(
            'id' => $actu->getId(),
            'titre' => $actu->getTitre(),
            'sous_titre' => $actu->getSous_titre(),
            'contenu' => $actu->getContenu(),
            'theme' => $actu->getTheme(),
            'tags' => $actu->getTags(),
            'id_auteur_crea' => $actu->getId_auteur_crea(),
            'id_auteur_modif' => $actu->getId_auteur_modif(),
            'id_auteur_publi' => $actu->getId_auteur_publi(),
            'date_creation' => $actu->getDate_creation(),
            'heure_creation' => $actu->getHeure_creation(),
            'date_modification' => $actu->getDate_modification(),
            
        $req->bindValue(':heure_modification', $actu->getHeure_modification(), PDO::PARAM_INT);
        $req->bindValue(':date_publication', $actu->getDate_publication(), PDO::PARAM_INT);
        $req->bindValue(':heure_publication', $actu->getHeure_publication(), PDO::PARAM_INT);
        $req->bindValue(':image', $actu->getImage());
        $req->bindValue(':slider', $actu->getSlider(), PDO::PARAM_INT);
        $req->bindValue(':importance', $actu->getImportance(), PDO::PARAM_INT);
        $req->bindValue(':publie', $actu->getPublie(), PDO::PARAM_INT);
        );
        
        echo json_encode($retour);
        exit;
	}
    echo json_encode(false);
    exit;
?>