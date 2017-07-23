<?php
	$now = date('Ymd', time());
	// $now = '20151001';
	
	$annee_en_cours = date('Y', time());
	
	$mois_de_lannee = array(6 => "Juillet", 7 => "Août", 8 => "Septembre", 9 => "Octobre", 10 => "Novembre", 11 => "Décembre", 0 => "Janvier", 1 => "Février", 2 => "Mars", 3 => "Avril", 4 => "Mai", 5 => "Juin");

	$mois_de_lannee_min = array(6 => "Juil.", 7 => "Août", 8 => "Sept.", 9 => "Oct.", 10 => "Nov.", 11 => "Déc.", 0 => "Jan.", 1 => "Fév.", 2 => "Mars", 3 => "Avril", 4 => "Mai", 5 => "Juin");
	
	$jours = array(0 => "-", 1 => "Lundi", 2 => "Mardi", 3 => "Mercredi", 4 => "Jeudi", 5 => "Vendredi", 6 => "Samedi", 7 => "Dimanche");

	$gymnases = array(0 => "-", "PdC" => "Pierre de Coubertin", "PA" => "Petite Arche", "C" => "COSEC", "A" => "Autre");

	$rang = array('Membre', 'Admin', 'R&eacute;dacteur', 'Entraineur');

	$postes = array('','Gardien', 'Demi-centre', 'Arrière gauche', 'Arrière droit', 'Ailier gauche', 'Ailier droit', 'Pivot');
	
	define ('INFOS_ACHERES', 1);
	define ('INFOS_FFH', 2);

	$tabTheme = array('' => '-', 'administratif' => 'Administratif', 'debriefs' => 'Debriefs', 'divers' => 'Divers', 'evenement' => 'Ev&egrave;nement', 'interviews' => 'Interviews', 'sportif' => 'Sportif');

	$lieu = array('domicile', 'exterieur', 'neutre');

	$tabImportance = array('3' => 'Basse', '2' => 'Moyenne', '1' => 'Haute');

	$listeCompetition = array(1 => 'Championnat', 2 => 'Coupe des Yvelines', 3 => 'Coupe de France', 4 => 'D&eacute;layages', 5 => 'Amical');
	$listeChampionnat = array(1 => 'Prénat', 2 => 'Pré-région', 3 => 'Excellence', 4 => 'Honneur', 5 => '1ère division', 6 => '2ème division', 7 => '3ème division', 8 => '4ème division');
	$listeNiveau = array(1 => 'National', 2 => 'R&eacute;gionnal', 3 => 'D&eacute;partemental');
?>