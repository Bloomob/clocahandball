<?php
	include_once("connexion_bdd.php");
	include_once('fonctions.php');
	
	$id_match = 0;
	if(isset($_POST['id']))
		$id_match = $_POST['id'];
	
	if(delete_match($id_match)){
		echo "Le match a bien &eacute;t&eacute; supprim&eacute; !";
	}
	else {
		echo "Le match n'a pas &eacute;t&eacute; supprim&eacute; !";
	}
?>