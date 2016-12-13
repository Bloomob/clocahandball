<?php
	function chargerClasse($classname)
    {
        require_once('../../classes/'.$classname.'.class.php');
    }
    spl_autoload_register('chargerClasse');

    require_once("../connexion_bdd_pdo.php");

    $ClubManager = new ClubManager($connexion);

	$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends
	$row = array(); $row_set = array();

	$options = array('where' => 'nom LIKE "%'.htmlspecialchars_decode(htmlentities($term, ENT_QUOTES, "UTF-8")).'%" OR raccourci LIKE "%'.htmlspecialchars_decode(htmlentities($term, ENT_QUOTES, "UTF-8")).'%"');
	$listeClubAuto = $ClubManager->retourneListe($options);

	foreach($listeClubAuto as $unClub) {
		$row['id'] = $unClub->getId();
		$row['value'] = utf8_encode(html_entity_decode($unClub->getRaccourci())).' '.$unClub->getNumero();
		$row_set[] = $row;
	}
	
	echo json_encode($row_set);//format the array into json data
?>