<?php
	/***************************************
	**
	** Retourne une variable mise en page
	** 
	** Entrée : (Mixed) $tab, (String) $nom
	** Sortie : (Mixed)
	**
	***************************************/
	
	function debug($tab, $nom = '') {
		echo '<br>'.$nom.' :<br>';
		echo '<pre>';
		print_r($tab);
		echo '</pre>';
	}

    /*****************************************************
	**
	** Test si l'accès est autorisé
	** 
	** Entrée : (Int) Rang
	** Sortie : (Bool)
	**
	*****************************************************/
	
	function accesAutorise($rang){
		$rangAutorise = array(1, 2);

		if(in_array($rang, $rangAutorise))
			return true;
		else
			return false;
	}
	
	/******************************
	**
	** Retourne la date + 7 jours
	** 
	** Entrée : (String) $date
	** Sortie : (String)
	**
	*******************************/
	
	function date_plus_7J($date) {
		$annee = substr($date, 0, 4);
		$mois = (substr($date, 4, 1) == 0) ? substr($date, 5, 1) : substr($date, 4, 2);
		$jour = substr($date, 6, 2);
		$annee_plus_J7 = $annee;
		$mois_plus_J7 = $mois;
		$jour_plus_J7 = $jour;
		
		switch($mois):
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
				$jour_plus_J7 = ($jour+7)%31;
			break;
			case 4:
			case 6:
			case 9:
			case 11:
				$jour_plus_J7 = ($jour+7)%30;
			break;
			case 2:
				if($annee%4==0):
					$jour_plus_J7 = ($jour+7)%29;
				else:
					$jour_plus_J7 = ($jour+7)%28;
				endif;
			break;
			case 12:
				$jour_plus_J7 = ($jour+7)%31;
			break;
		endswitch;
		
		if($jour_plus_J7<8)
			$mois_plus_J7 = $mois+1;
		if($mois_plus_J7==1 && $jour_plus_J7<8)
			$annee_plus_J7 = $annee+1;
		if(strlen($mois_plus_J7) == 1)
			$mois_plus_J7 = "0".$mois_plus_J7;
		if(strlen($jour_plus_J7) == 1)
			$jour_plus_J7 = "0".$jour_plus_J7;
		
		$new_date = $annee_plus_J7.$mois_plus_J7.$jour_plus_J7;
		
		return $new_date;
	}
	
	/******************************
	**
	** Retourne la date - 7 jours
	** 
	** Entrée : (String) $date
	** Sortie : (String)
	**
	*******************************/
	
	function date_moins_7J($date) {
		$annee = substr($date, 0, 4);
		$mois = (substr($date, 4, 1) == 0) ? substr($date, 5, 1) : substr($date, 4, 2);
		$jour = substr($date, 6, 2);
		$annee_moins_J7 = $annee;
		$mois_moins_J7 = $mois;
		$jour_moins_J7 = $jour;
		
		switch($mois):
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
				$jour_moins_J7 = ($jour-7+31)%31;
			break;
			case 4:
			case 6:
			case 9:
			case 11:
				$jour_moins_J7 = ($jour-7+31)%30;
			break;
			case 2:
				if($annee%4==0):
					$jour_moins_J7 = ($jour-7+29)%29;
				else:
					$jour_moins_J7 = ($jour-7+28)%28;
				endif;
			break;
			case 12:
				$jour_moins_J7 = ($jour-7+31)%31;
			break;
		endswitch;
		
		if($jour_moins_J7>24)
			$mois_moins_J7 = $mois-1;
		if($mois_moins_J7==12 && $jour_moins_J7>24)
			$annee_moins_J7 = $annee-1;
		if(strlen($mois_moins_J7) == 1)
			$mois_moins_J7 = "0".$mois_moins_J7;
		if(strlen($jour_moins_J7) == 1)
			$jour_moins_J7 = "0".$jour_moins_J7;
		
		$new_date = $annee_moins_J7.$mois_moins_J7.$jour_moins_J7;
		
		return $new_date;
	}

	/*********************************
	**
	** Remplace les heures
	** 
	** Entrée : (String) $date
	** Sortie : (String) Date formatée
	**
	**********************************/

	function remplace_heure($heure) {
		$longueur = strlen($heure);
		switch($longueur) {
			
			case 1:
				$minute = substr($heure, 0, 1);
				$newHeure = '00h0'.$minute;
				break;
			case 2:
				$minute = substr($heure, 0, 2);
				$newHeure = '00h'.$minute;
				break;
			case 3:
				$heureH = substr($heure, 0, 1);
				$minute = substr($heure, -2);
				if($minute=='00')
					$minute = '';
				$newHeure = $heureH.'h'.$minute;
				break;
			case 4:
				$heureH = substr($heure, 0, 2);
				$minute = substr($heure, -2);
				if($minute=='00')
					$minute = '';
				$newHeure = $heureH.'h'.$minute;
				break;
			case 0:
			default:
				$minute = substr($heure, -2);
				$heureH = substr($heure, 0, 2);
				if($minute=='00')
					$minute = '';
				$newHeure = $heureH.'h'.$minute;
				break;
		}
		return $newHeure;
	}
?>