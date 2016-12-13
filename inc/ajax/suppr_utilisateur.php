<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	$id = 0;
	if(isset($_POST['id']))
		$id = $_POST['id'];
	
	if(delete_utilisateur($id)){
		echo "L'utilisateur a bien &eacute;t&eacute; supprim&eacute; !";
	}
	else {
		echo "L'utilisateur n'a pas &eacute;t&eacute; supprim&eacute; !";
	}
?>