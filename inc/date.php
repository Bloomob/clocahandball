<?php
	include_once("connexion_bdd.php");
	
	$jour_de_la_semaine = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
	$mois_de_lannee = array(6 => "Juillet", 7 => "Août", 8 => "Septembre", 9 => "Octobre", 10 => "Novembre", 11 => "Décembre", 0 => "Janvier", 1 => "Fevrier", 2 => "Mars", 3 => "Avril", 4 => "Mai", 5 => "Juin");
	
	$MatchManager = new MatchManager($connexion);
	$CategorieManager = new CategorieManager($connexion);

	function getEvents($year) {
		$nextYear = $year + 1;
		$liste = array();
		global $MatchManager, $CategorieManager;

		$options = array('where' => 'date > '.$year .'0701 AND date < '.$nextYear .'0701', 'orderby' => 'date, heure');
		$listeEvent = $MatchManager->retourneListe($options);

		if(!empty($listeEvent)):
			foreach ($listeEvent as $unEvent):
				$options2 = array('where' => 'id = '.$unEvent->getCategorie());
				$uneCategorie = $CategorieManager->retourne($options2);
				$liste[$unEvent->getDate()][$unEvent->getId()] = $uneCategorie->getCategorieAll();
			endforeach;

			return $liste;
		else:
			return false;
		endif;

		if(mysql_num_rows($q)>0) {
			while($d = mysql_fetch_array($q)) {
				if(!empty($d['numero'])) $d['type'] .= ' '.$d['numero'];
				if(!empty($d['type'])) $d['cat'] = $d['categorie'].' '.$d['type'];
				$liste[$d['date']][$d['id']] = $d['cat']; 
			}
			return $liste;
		}
		else
			return false;
	}
	
	function getAll($year) {
		$r = array();
		
		$date = new DateTime($year.'-07-01');
		while($year == $date->format('Y') || ($year+1 == $date->format('Y') && $date->format('n') < 7 )) {
			$m = $date->format('n');
			$d = $date->format('j');
			$w = str_replace('0', '7', $date->format('w'));
			$r[$m][$d] = $w;
			
			$date->add(new DateInterval('P1D'));
		}
		return $r;
	}
	
	function date_toutes_lettres($num_jour, $jour, $mois) {
		global $jour_de_la_semaine, $mois_de_lannee;
		return $jour_de_la_semaine[$jour-1].' '.$num_jour.' '.$mois_de_lannee[$mois-1];
	}
	
	function date_du_jour() {
		global $jour_de_la_semaine, $mois_de_lannee;
		$day = date('j',time());
		$month = date('n',time());
		$w = str_replace('0', '7', date('w',time()));
		return $jour_de_la_semaine[$w-1].' '.$day.' '.$mois_de_lannee[$month-1];
	}	
	
	function liste_class($d, $m, $w) {
		$liste = array();
		$jour_now = date('j');
		$mois_now = date('n');
		
		if($jour_now == $d && $mois_now == $m)
			$liste[] = "today";
		
		if(6 == $w || 7 == $w)
			$liste[] = "week_end";
		
		// $vacances = array ("27/10/12/11", "22/12/7/1", "2/3/18/3", "27/4/13/5");
		// $vacances = array ("19/10/4/11", "21/12/6/1", "15/2/3/3", "12/4/28/4");
		$vacances = array ("18/10/3/11", "20/12/5/1", "14/2/2/3", "18/4/4/5");
		foreach($vacances as $k=>$periode) {
			$vacs = explode("/", $periode);
			if($vacs[1]==$vacs[3]) {
				if(($vacs[0] <= $d && $vacs[1] == $m) && ($d < $vacs[2] && $vacs[3] == $m))
					$liste[] = "vacances";
			}
			else {
				if(($vacs[0] <= $d && $vacs[1] == $m) || ($d < $vacs[2] && $vacs[3] == $m))
					$liste[] = "vacances";
			}
		}
		
		if(!empty($liste)) {
			$L = implode(" ", $liste);
			return "class = '" .$L."'";
		}
		return "";
	}
	
	function retourne_annee() {
		$month = date('n',time());
		$year = date('Y',time());
		
		if($month < 7)
			return $year-1;
		return $year;
	}

	$annee_actuelle = retourne_annee();
	$annee_suiv = $annee_actuelle + 1;
	$annee_prec = $annee_actuelle - 1;
?>