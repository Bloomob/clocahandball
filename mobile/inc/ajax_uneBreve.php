<?php
	include_once("../../inc/connexion_bdd.php");
	include_once("../../inc/fonctions.php");
	include_once("../../inc/constantes.php");
	
	if(isset($_POST['id']) && !is_nan($_POST['id'])) {
		$id = $_POST['id'];
	}
	else{
		$id = 1;
	}

	$une_news = infos_news($id);
?>
<h3><?=$une_news['titre']?></h3>
<div class="auteur_date"><?=$une_news['auteur_date']?></div>
<div class="categorie"><?=$une_news['categorie']?></div>
<div class="contenu"><?=$une_news['contenu']?></div>