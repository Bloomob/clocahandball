<?php
	include_once("connexion_bdd.php");
	include_once('fonctions.php');
	
	if(isset($_POST['donnees']))
		$donnees = $_POST['donnees'];
	if(isset($_POST['id_equipe']))
		$id_equipe = $_POST['id_equipe'];
	
	$tableau = '';
	$i = 0;
	$j = 1;
	$TabDonnees = explode(',', $donnees);
	
	foreach ($TabDonnees as $uneDonnee) {
		if($i==0) {
			$tableau .= '<tr class=\'cell'. $j .'\'>';
			$j++;
			if($j==3) $j=1;
		}
		
		if(preg_match('#ACHERES#', $uneDonnee)) {
			$uneDonnee = '<strong>'. $uneDonnee .'</strong>';
		}
		$tableau .= '<td>'. $uneDonnee .'</td>';
		
		$i++;
		if($i==10)
			{ $i = 0; $tableau .= '</tr>'; }
	}
	
	if(ajoutClassement($id_equipe, $tableau)) {
		echo "Le classement a bien &eacute;t&eacute; mis &agrave; jour !";
	}
	else {
		echo "Le classement n'a pas &eacute;t&eacute; mis &agrave; jour !";
	}
	
	

?>

