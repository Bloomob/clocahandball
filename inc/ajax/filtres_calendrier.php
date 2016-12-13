<?php
	session_start();

	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../connexion_bdd_pdo.php");
	include_once("../fonctions.php");
	include_once("../date.php");

	$MatchManager = new MatchManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$ClubManager = new ClubManager($connexion);
	
	// var_dump($_POST['filtres']);

	if(isset($_POST['filtres'])):
		$where = '';
		$categories = $_POST['filtres']['categories'];
		$competitions = $_POST['filtres']['competitions'];
		$dates = $_POST['filtres']['dates'];
		$joue = $_POST['filtres']['joue'];

		if(!empty($categories)):
			if(($key = array_search('all', $categories)) !== false) {
			    unset($categories[$key]);
			}
			$where .= 'categorie IN ('. implode(",", $categories) .')';
		endif;
		
		if(!empty($competitions)):
			if(($key = array_search('all', $competitions)) !== false) {
			    unset($competitions[$key]);
			}
			$where .= ($where != '') ? ' AND ' : '';
			$where .= 'competition IN ('. implode(",", $competitions) .')';
		endif;

		if(!empty($dates)):
			if(($key = array_search('all', $dates)) !== false) {
			    unset($dates[$key]);
			}
			$where .= ($where != '') ? ' AND ' : '';
			$where .= 'SUBSTR(date,1,6) IN ('. implode(",", $dates) .')';
		endif;

		if($joue == 'true'):
			$where .= ($where != '') ? ' AND ' : '';
			$where .= 'joue = 1';
		else:
			$where .= ($where != '') ? ' AND ' : '';
			$where .= 'joue = 0';
		endif;
	else:
		$where = 'joue = 0';
	endif;

	// echo '<pre>'; var_dump($_POST['filtres']); echo '</pre>';
	// echo $where;

	$options = array('where' => $where, 'orderby' => 'date, heure', 'limit' => '0, 20');
	$listeMatchs = $MatchManager->retourneListe($options);
	// echo '<pre>'; var_dump($listeMatchs); echo '</pre>';
	include('../admin/liste_calendrier.php');
?>