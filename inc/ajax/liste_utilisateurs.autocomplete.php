<?php
	function chargerClasse($classname)
    {
        require_once('../../classes/'.$classname.'.class.php');
    }
    spl_autoload_register('chargerClasse');

    require_once("../connexion_bdd_pdo.php");
    require_once("../constantes.php");
    require_once("../fonctions.php");

    $UtilisateurManager = new UtilisateurManager($connexion);

	$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

	$options = array('where' => 'nom LIKE "%'. $term .'%" OR prenom LIKE "%'. $term .'%"');
	$listeUtilisateurs = $UtilisateurManager->retourneListe($options);
	foreach($listeUtilisateurs as $unUtilisateur) {
		$row['id'] = $unUtilisateur->getId();
		$row['value'] = utf8_encode(html_entity_decode($unUtilisateur->getPrenom().' '.$unUtilisateur->getNom()));
		$row_set[] = $row;
	}
	
	echo json_encode($row_set);//format the array into json data
?>