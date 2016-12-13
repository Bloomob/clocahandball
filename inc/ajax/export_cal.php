<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	include_once('../date.php');

	$listeMatchs = liste_matchs_a_venir_exp($now);
?>

<div id="textarea">
	<?php
		$result = array();
		$jour_actuel = "";
		$phrase1 = "Les matchs &agrave; domicile de ce week-end :";
		$phrase2 = "Les matchs &agrave; l'ext&eacute;rieur de ce week-end :";
		foreach($listeMatchs as $unMatch) {
			if($unMatch['lieu'] == 0) {
				if($jour_actuel != $jour_de_la_semaine[str_replace('0', '7', date('w', mktime(0, 0, 0, $unMatch['mois'], $unMatch['jour'], $unMatch['annee'])))-1]) {
					$jour_actuel = $jour_de_la_semaine[str_replace('0', '7', date('w', mktime(0, 0, 0, $unMatch['mois'], $unMatch['jour'], $unMatch['annee'])))-1];
					$result[0] .= "<br/>". $jour_actuel ." ". $unMatch['newDate'].'<br/><br/>';
				}
				$result[0] .= "> ".(($unMatch['newHeure']!=0) ? $unMatch['newHeure'] : '') .' / '.  $unMatch['compet'] .' / '. $unMatch['categorie'] .'<br/>';
				if($unMatch['adversaire2'] != '') {
					$result[0] .= "Ach&egrave;res VS ". $unMatch['adversaire1'];
					if($unMatch['adversaire3'] != '') {
						$result[0] .= ", ". $unMatch['adversaire2'] ." & ". $unMatch['adversaire3']."<br/>";
					}
					else {
						$result[0] .= " & ". $unMatch['adversaire2']."<br/>";
					}
				}
				else {
					$result[0] .= "Ach&egrave;res - ". $unMatch['adversaire1'] ."<br/>";
				}
				
			}
			else {
				if($jour_actuel != $jour_de_la_semaine[str_replace('0', '7', date('w', mktime(0, 0, 0, $unMatch['mois'], $unMatch['jour'], $unMatch['annee'])))-1]) {
					$jour_actuel = $jour_de_la_semaine[str_replace('0', '7', date('w', mktime(0, 0, 0, $unMatch['mois'], $unMatch['jour'], $unMatch['annee'])))-1];
					$result[1] .= "<br/>". $jour_actuel ." ". $unMatch['newDate'].'<br/><br/>';
				}
				$result[1] .= "> ".(($unMatch['newHeure']!=1) ? $unMatch['newHeure'] : '') ." / ". $unMatch['compet'] ." / ". $unMatch['categorie'] ."<br/>";
				if($unMatch['adversaire2'] != '') {
					$result[1] .= $unMatch['adversaire1'] .' VS ';
					if($unMatch['adversaire3'] != '') {
						$result[1] .= $unMatch['adversaire2'] .", ". $unMatch['adversaire3']." & Ach&egrave;res<br/>";
					}
					else {
						$result[1] .= $unMatch['adversaire2']." & Ach&egrave;res<br/>";
					}
				}
				else {
					$result[1] .= $unMatch['adversaire1'] ." - Ach&egrave;res<br/>";
				}
			}
		}
		$result[2] .= "<br/><br/><br/>Venez nombreux supportez nos &eacute;quipes !<br/><br/>";
		$result[2] .= "Acc&eacute;dez au calendrier des matchs directement sur le site Internet :<br/>";
		$result[2] .= "http://clocahandball.fr/resultats_classements.php?onglet=matchs_a_venir";
		
		echo $phrase1 .'<br/>'. $result[0]. '<br/><br/>'. $phrase2. '<br/>'. $result[1].$result[2];
	?>
</div>