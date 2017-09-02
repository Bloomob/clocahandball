<?php
require_once("inc/connexion_bdd_pdo.php");

if( empty($_POST['ajout'])){
  $numero_licence=
  $adherent_nom=
  $adherent_prenom=
  $numero_rue=
  $nom_rue=
  $code_postal=
  $ville=
  $telephone_domicile=
  $telephone_mobile1=
  $telephone_mobile2=
  $adresse_mail=
  $date_naissance=
  $sexe=
  $categorie=
  $fonction=
  $mutation=
  $moyen_paiement1=
  $montant_paiement1=
  $moyen_paiement2=
  $montant_paiement2=
  $moyen_paiement3=
  $montant_paiement3=
  $moyen_paiement4=
  $montant_paiement4=
  $moyen_paiement5=
  $montant_paiement5=
  $cheque_caution_numero=
  $tous=
  $photo=
  $autorisation_parentale=
  $certificat_medicale=
  $questionnaire_sante=
  $piece_identite=
  $date_qualification=
  $fiche_inscription=
  $charte_bonne_conduite=
  $commentaire=
  $numero_teeshirt=
  $taille_teeshirt=
  $status_teeshirt=
  $date_teeshirt=
  $taille_chaussette=
  $status_chaussette=
  $date_chaussette=
  $taille_ballon=
  $status_ballon=
  $date_ballon=
  $taille_chasuble=
  $status_chasuble=
  $date_chasuble=
  $date_creation_adherent= '';
} else {
	$numero_licence					                 =	( !empty( $_POST['numero_licence'] ) )	?	htmlentities( $_POST['numero_licence'])		  : '';
	$adherent_nom					                   =	( !empty( $_POST['adherent_nom'] ) )	?	htmlentities( strtoupper($_POST['adherent_nom']))		  : '';
	$adherent_prenom					               =	( !empty( $_POST['adherent_prenom'] ) )	  ? htmlentities( strtoupper($_POST['adherent_prenom'] ) ) 		: '';
	$numero_rue					                     = 	( !empty( $_POST['numero_rue'] ) )	  ? htmlentities( $_POST['numero_rue'] )  		: '';
	$nom_rue	                               =	( !empty( $_POST['nom_rue'] ) )  ?	htmlentities( $_POST['nom_rue'] )		: '';
	$code_postal	                           =	( !empty( $_POST['code_postal'] ) )  ?	htmlentities( $_POST['code_postal'] )		: '';
	$ville	                                 =	( !empty( $_POST['ville'] ) )  ?	htmlentities( $_POST['ville'] )		: '';
	$telephone_domicile	                     =	( !empty( $_POST['telephone_domicile'] ) )  ?	htmlentities( $_POST['telephone_domicile'] )		: '';
  $telephone_mobile1	                     =	( !empty( $_POST['telephone_mobile1'] ) )  ?	htmlentities( $_POST['telephone_mobile1'] )		: '';
	$telephone_mobile2	                     =	( !empty( $_POST['telephone_mobile2'] ) )  ?	htmlentities( $_POST['telephone_mobile2'] )		: '';
	$adresse_mail	                           =	( !empty( $_POST['adresse_mail'] ) )  ?	htmlentities( $_POST['adresse_mail'] )		: '';
	$date_naissance                          =	( !empty( $_POST['date_naissance'] ) )  ?	htmlentities( $_POST['date_naissance'] )		: '';
	$sexe                                    =	( !empty( $_POST['sexe'] ) )  ?	htmlentities( $_POST['sexe'] )		: '';
	$categorie	                             =	( !empty( $_POST['categorie'] ) )  ?	htmlentities( $_POST['categorie'] )		: '';
	$fonction	                               =	( !empty( $_POST['fonction'] ) )  ?	htmlentities( $_POST['fonction'] )		: '';
	$mutation	                               =	( !empty( $_POST['mutation'] ) )  ?	htmlentities( $_POST['mutation'] )		: '';
  $moyen_paiement1	                       =	( !empty( $_POST['moyen_paiement1'] ) )  ?	htmlentities( $_POST['moyen_paiement1'] )		: '';
	$montant_paiement1	                     =	( !empty( $_POST['montant_paiement1'] ) )  ?	htmlentities( $_POST['montant_paiement1'] )		: '';
	$moyen_paiement2	                       =	( !empty( $_POST['moyen_paiement2'] ) )  ?	htmlentities( $_POST['moyen_paiement2'] )		: '';
	$montant_paiement2	                     =	( !empty( $_POST['montant_paiement2'] ) )  ?	htmlentities( $_POST['montant_paiement2'] )		: '';
	$moyen_paiement3	                       =	( !empty( $_POST['moyen_paiement3'] ) )  ?	htmlentities( $_POST['moyen_paiement3'] )		: '';
	$montant_paiement3	                     =	( !empty( $_POST['montant_paiement3'] ) )  ?	htmlentities( $_POST['montant_paiement3'] )		: '';
	$moyen_paiement4	                       =	( !empty( $_POST['moyen_paiement4'] ) )  ?	htmlentities( $_POST['moyen_paiement4'] )		: '';
	$montant_paiement4	                     =	( !empty( $_POST['montant_paiement4'] ) )  ?	htmlentities( $_POST['montant_paiement4'] )		: '';
	$moyen_paiement5	                       =	( !empty( $_POST['moyen_paiement5'] ) )  ?	htmlentities( $_POST['moyen_paiement5'] )		: '';
	$montant_paiement5	                     =	( !empty( $_POST['montant_paiement5'] ) )  ?	htmlentities( $_POST['montant_paiement5'] )		: '';
	$cheque_caution_numero	                 =	( !empty( $_POST['cheque_caution_numero'] ) )  ?	htmlentities( $_POST['cheque_caution_numero'] )		: '';
	$tous	                                   =	( !empty( $_POST['tous'] ) )  ?	htmlentities( $_POST['tous'] )		: '';
	$photo	                                 =	( !empty( $_POST['photo'] ) )  ?	htmlentities( $_POST['photo'] )		: '';
	$autorisation_parentale	                 =	( !empty( $_POST['autorisation_parentale'] ) )  ?	htmlentities( $_POST['autorisation_parentale'] )		: '';
	$certificat_medicale	                   =	( !empty( $_POST['certificat_medicale'] ) )  ?	htmlentities( $_POST['certificat_medicale'] )		: '';
	$questionnaire_sante                     =	( !empty( $_POST['questionnaire_sante'] ) )  ?	htmlentities( $_POST['questionnaire_sante'] )		: '';
  $piece_identite	                         =	( !empty( $_POST['piece_identite'] ) )  ?	htmlentities( $_POST['piece_identite'] )		: '';
	$date_qualification	                     =	( !empty( $_POST['date_qualification'] ) )  ?	htmlentities( $_POST['date_qualification'] )		: '';
	$fiche_inscription	                     =	( !empty( $_POST['fiche_inscription'] ) )  ?	htmlentities( $_POST['fiche_inscription'] )		: '';
	$charte_bonne_conduite	                 =	( !empty( $_POST['charte_bonne_conduite'] ) )  ?	htmlentities( $_POST['charte_bonne_conduite'] )		: '';
	$commentaire	                           =	( !empty( $_POST['commentaire'] ) )  ?	htmlentities( $_POST['commentaire'] )		: '';
	$numero_teeshirt	                       =	( !empty( $_POST['numero_teeshirt'] ) )  ?	htmlentities( $_POST['numero_teeshirt'] )		: '';
	$taille_teeshirt	                       =	( !empty( $_POST['taille_teeshirt'] ) )  ?	htmlentities( $_POST['taille_teeshirt'] )		: '';
	$status_teeshirt	                       =	( !empty( $_POST['status_teeshirt'] ) )  ?	htmlentities( $_POST['status_teeshirt'] )		: '';
	$date_teeshirt	                         =	( !empty( $_POST['date_teeshirt'] ) )  ?	htmlentities( $_POST['date_teeshirt'] )		: '';
	$taille_chaussette	                     =	( !empty( $_POST['taille_chaussette'] ) )  ?	htmlentities( $_POST['taille_chaussette'] )		: '';
	$status_chaussette	                     =	( !empty( $_POST['status_chaussette'] ) )  ?	htmlentities( $_POST['status_chaussette'] )		: '';
	$date_chaussette	                       =	( !empty( $_POST['date_chaussette'] ) )  ?	htmlentities( $_POST['date_chaussette'] )		: '';
	$taille_ballon	                         =	( !empty( $_POST['taille_ballon'] ) )  ?	htmlentities( $_POST['taille_ballon'] )		: '';
	$status_ballon	                         =	( !empty( $_POST['status_ballon'] ) )  ?	htmlentities( $_POST['status_ballon'] )		: '';
	$date_ballon				                     =	( !empty( $_POST['date_ballon'] ) )		?	htmlentities($_POST['date_ballon'] )				: '';
	$taille_chasuble				                 =	( !empty( $_POST['taille_chasuble'] ) )		?	htmlentities($_POST['taille_chasuble'] )				: '';
	$status_chasuble				                 =	( !empty( $_POST['status_chasuble'] ) )		?	htmlentities($_POST['status_chasuble'] )				: '';
	$date_chasuble				                   =	( !empty( $_POST['date_chasuble'] ) )		?	htmlentities($_POST['date_chasuble'] )				: '';
  $aError					=	array();





if (empty($numero_licence) ) {
		$aError[]			=		'Veuillez saisir un numéro de licence';
	} elseif (strlen($numero_licence) > '5' && strlen($numero_licence) < '5') {
		$aError[]			=		' Le numéro de licence n\'a pas été bien saisie';
	}

  if ( empty($adherent_nom) ) {
    $aError[]			=		'Veuillez saisir un nom';
  }elseif (preg_match('/[0-9 ;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $adherent_nom) || strlen($adherent_nom) > 50) {
		$aError[]			=		' Votre nom n\'a pas bien été saisie';
	}

  if ( empty($adherent_prenom) ) {
    $aError[]			=		'Veuillez saisir un prenom';
  }elseif (preg_match('/[0-9 ;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $adherent_prenom) || strlen($adherent_prenom) > 50) {
		$aError[]			=		' Votre prenom n\'a pas bien été saisie';
	}

  if ( empty($numero_rue) ) {
    $aError[]			=		'Veuillez saisir le numéro de rue ';
  } elseif ( strlen($numero_rue) > 10) {
    $aError[]			=		'Veuillez saisir le bon numéro de rue';
  }
  if ( empty($nom_rue) ) {
    $aError[]			=		'Veuillez saisir le nom de la rue';
  }elseif (preg_match('/[;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $nom_rue) || strlen($nom_rue) > 100) {
		$aError[]			=		' Le nom de la rue n\'a pas été bien saisie';
	}
  if ( empty($code_postal) ) {
    $aError[]			=		'Veuillez saisir le code postal ';
  } elseif ( strlen($code_postal) > 5) {
    $aError[]			=		'Veuillez saisir le bon code postal';
  }
  if ( empty($ville) ) {
    $aError[]			=		'Veuillez saisir la ville';
  } elseif ( strlen($ville) > 50) {
    $aError[]			=		'Veuillez saisir la bonne ville ';
  }
  if ( empty($telephone_domicile) ) {
    $aError[]			=		'Veuillez saisir le numéro de téléphone du domicile';
  } elseif (preg_match('/[a-zA-Z ;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $telephone_domicile) || strlen($telephone_domicile) > 10) {
    $aError[]			=		'Veuillez saisir le bon numéro de téléphone du domicile ';
  }
  if ( empty($telephone_mobile1) ) {
    $aError[]			=		'Veuillez saisir le numéro de téléphone portable';
  } elseif (preg_match('/[a-zA-Z ;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $telephone_mobile1) || strlen($telephone_mobile1) > 10) {
    $aError[]			=		'Veuillez saisir le bon numéro de téléphone portable';
  }
  if (preg_match('/[a-zA-Z ;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $telephone_mobile2) || strlen($telephone_mobile2) > 10) {
    $aError[]			=		'Veuillez saisir la bonne ville ';
  }
  if ( empty($adresse_mail) ) {
    $aError[]		=		'Veuillez saisir l\'adresse email de l\'adhérent';
  } elseif (!(filter_var($adresse_mail, FILTER_VALIDATE_EMAIL))) {
    $aError[]		=		 'Veuillez vérifier la synthaxe de l\'adresse email';
  }
  if ( empty($date_naissance) ) {
    $aError[]			=		'Veuillez saisir la date de naissance';
  } else {
    $date_naissance = explode('/', $date_naissance);
  }
  if ( empty($sexe) ) {
    $aError[]			=		'Veuillez saisir le sexe de l\'adherent';
  } elseif ( $sexe != 'M' && $sexe != 'F' ) {
    $aError[]			=		'Veuillez saisir le bon sexe de l\'adherent';
  }
  if ( empty($categorie) ) {
    $aError[]			=		'Veuillez saisir la catégorie de l\'adherent';
  } elseif ( $categorie != '+16G' && $categorie != '+16F' && $categorie != '-20G' && $categorie != '-18G' && $categorie != '-18F' && $categorie != '-17G' && $categorie != '-15G' && $categorie != '-15F'
&& $categorie != '-13G' && $categorie != '-13F' && $categorie != '-11G' && $categorie != '-11F' && $categorie != '-9' && $categorie != 'ecole' && $categorie != 'loisir' && $categorie != 'dirigeant' ) {
    $aError[]			=		'Veuillez saisir la bonne catégorie de l\'adherent';
  }
  if ( empty($fonction) ) {
    $aError[]			=		'Veuillez saisir la fonction de l\'adherent';
  } elseif ( $fonction != 'dirigeant' && $fonction != 'bureau' && $fonction != 'arbitre' && $fonction != 'entraineur' && $fonction != 'joueur') {
    $aError[]			=		'Veuillez saisir la bonne fonction de l\'adherent';
  }
  if ( $mutation != '1' && !empty($mutation) ) {
    $aError[]			=		'Veuillez saisir la bonne mutation de l\'adherent';
  }

  if ( $moyen_paiement1 != 'liquide' && $moyen_paiement1 != 'cheque' && $moyen_paiement1 != 'bon_caf' && $moyen_paiement1 != 'cheque_vacance' && $moyen_paiement1 != 'coupon_sport' && $moyen_paiement1 != 'aucun') {
    $aError[]			=		'Veuillez saisir le bon moyen de payement 1 de l\'adherent';
  }
  if( $moyen_paiement1 == 'aucun'){
    $moyen_paiement1 = "";
    $montant_paiement1 = "";
  } elseif (preg_match('/[a-zA-Z ;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $montant_paiement1)) {
    $aError[]			=		'Veuillez saisir le bon montant de payement 1 de l\'adherent ';
  }

  if ( $moyen_paiement2 != 'liquide' && $moyen_paiement2 != 'cheque' && $moyen_paiement2 != 'bon_caf' && $moyen_paiement2 != 'cheque_vacance' && $moyen_paiement2 != 'coupon_sport' && $moyen_paiement2 != 'aucun') {
    $aError[]			=		'Veuillez saisir le bon moyen de payement 2 de l\'adherent';
  }
  if( $moyen_paiement2 == 'aucun'){
    $moyen_paiement2 = "";
    $montant_paiement2 = "";
  } elseif (preg_match('/[a-zA-Z ;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $montant_paiement2)) {
    $aError[]			=		'Veuillez saisir le bon montant de payement 2 de l\'adherent';
  }

  if ( $moyen_paiement3 != 'liquide' && $moyen_paiement3 != 'cheque' && $moyen_paiement3 != 'bon_caf' && $moyen_paiement3 != 'cheque_vacance' && $moyen_paiement3 != 'coupon_sport' && $moyen_paiement3 != 'aucun') {
    $aError[]			=		'Veuillez saisir le bon moyen de payement 3 de l\'adherent';
  }
  if( $moyen_paiement3 == 'aucun'){
    $moyen_paiement3 = "";
    $montant_paiement3 = "";
  } elseif (preg_match('/[a-zA-Z ;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $montant_paiement3)) {
    $aError[]			=		'Veuillez saisir le bon montant de payement 3 de l\'adherent';
  }
  if ( $moyen_paiement4 != 'liquide' && $moyen_paiement4 != 'cheque' && $moyen_paiement4 != 'bon_caf' && $moyen_paiement4 != 'cheque_vacance' && $moyen_paiement4 != 'coupon_sport' && $moyen_paiement4 != 'aucun') {
    $aError[]			=		'Veuillez saisir le bon moyen de payement 4 de l\'adherent';
  }
  if( $moyen_paiement4 == 'aucun'){
    $moyen_paiement4 = "";
    $montant_paiement4 = "";
  } elseif (preg_match('/[a-zA-Z ;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $montant_paiement4)) {
    $aError[]			=		'Veuillez saisir le bon montant de payement 4 de l\'adherent';
  }

  if ( $moyen_paiement5 != 'liquide' && $moyen_paiement5 != 'cheque' && $moyen_paiement5 != 'bon_caf' && $moyen_paiement5 != 'cheque_vacance' && $moyen_paiement5 != 'coupon_sport' && $moyen_paiement5 != 'aucun') {
    $aError[]			=		'Veuillez saisir le bon moyen de payement 5 de l\'adherent';
  }
  if( $moyen_paiement5 == 'aucun'){
    $moyen_paiement5 = "";
    $montant_paiement5 = "";
  } elseif (preg_match('/[a-zA-Z ;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $montant_paiement5)) {
    $aError[]			=		'Veuillez saisir le bon montant de payement 5 de l\'adherent';
  }
  if ( empty($cheque_caution_numero) ) {
    $aError[]			=		'Veuillez saisir le numéro du chèque de caution de l\'adhérent';
  } elseif (preg_match('/[a-zA-Z ;\.,?:!_\?+=§%<>$@\\\[\]\{\}`\#\(\)\*µ£\|\/]/', $cheque_caution_numero) || strlen($cheque_caution_numero) > 15) {
    $aError[]			=		'Veuillez saisir le bon numéro du chèque de caution de l\'adherent';
  }

  $document_manquant = '';
    
  if( !empty($tous) ){
    $document_manquant .= $tous;
  }
  if (!empty($photo)){
    if(empty($document_manquant)){
      $document_manquant .= $photo;
    }else{
      $document_manquant .= ', ' . $photo;
    }

  }
  if (!empty($autorisation_parentale)){
    if(empty($document_manquant)){
      $document_manquant .= $autorisation_parentale;
    }else{
      $document_manquant .= ', ' . $autorisation_parentale;
    }

  }
  if (!empty($certificat_medicale)){
    if(empty($document_manquant)){
      $document_manquant .= $certificat_medicale;
    }else{
      $document_manquant .= ', ' . $certificat_medicale;
    }

  }
  if (!empty($questionnaire_sante)){
    if(empty($document_manquant)){
      $document_manquant .= $questionnaire_sante;
    }else{
      $document_manquant .= ', ' . $questionnaire_sante;
    }

  }
  if (!empty($piece_identite)){
    if(empty($document_manquant)){
      $document_manquant .= $piece_identite;
    }else{
      $document_manquant .=  ', ' . $piece_identite;
    }

  }

  if ( empty($date_qualification) ) {
    $aError[]			=		'Veuillez saisir la date de qualification';
  } else {
    $date_qualification = explode('/', $date_qualification);
  }
  if ( $fiche_inscription != '1' && !empty($fiche_inscription) ) {
    $aError[]			=		'Veuillez saisir la bonne fiche d\'inscription';
  }

  if ( $charte_bonne_conduite != '1' && !empty($charte_bonne_conduite) ) {
    $aError[]			=		'Veuillez saisir correctement la charte de bonne conduite';
  }
  if ( strlen($numero_teeshirt) > 2 ) {
    $aError[]			=		'Veuillez saisir correctement le numéro du tee shirt';
  }
  if ( $taille_teeshirt != '116/128' && $taille_teeshirt != '140/152' && $taille_teeshirt != '164/176' && $taille_teeshirt != 'S' && $taille_teeshirt != 'M' && $taille_teeshirt != 'L'
&& $taille_teeshirt != 'XL' && $taille_teeshirt != 'XXL' && $taille_teeshirt != '' ) {
    $aError[]			=		'Veuillez saisir correctement la taille du tee shirt';
  }

  if ( $status_teeshirt != 'vide' && $status_teeshirt != 'commande' && $status_teeshirt != 'stock' && $status_teeshirt != 'affecte' ) {
    $aError[]			=		'Veuillez saisir correctement la taille du tee shirt';
  }
  if($status_teeshirt == 'vide'){
    $date_teeshirt = null;
  } elseif($status_teeshirt == 'commande' || $status_teeshirt == 'stock' || $status_teeshirt == 'affecte'){
    $date_teeshirt = date("Y-m-d H:i:s");
  }

  if ( $taille_chaussette != '33/35' && $taille_chaussette != '36/38' && $taille_chaussette != '39/42' && $taille_chaussette != '43/45' && $taille_chaussette != '46/48' && $taille_chaussette != '') {
    $aError[]			=		'Veuillez saisir correctement la taille des chaussettes';
  }
  if ( $status_chaussette != 'vide' && $status_chaussette != 'commande' && $status_chaussette != 'stock' && $status_chaussette != 'affecte' ) {
    $aError[]			=		'Veuillez saisir correctement la taille des chaussettes';
  }
  if($status_chaussette == 'vide'){
    $date_chaussette = null;
  } elseif($status_chaussette == 'commande' || $status_chaussette == 'stock' || $status_chaussette == 'affecte'){
    $date_chaussette = date("Y-m-d H:i:s");
  }

  if ( $taille_ballon != 'T0' && $taille_ballon != 'T1' && $taille_ballon != 'T2' && $taille_ballon != 'T3' && $taille_ballon != '') {
    $aError[]			=		'Veuillez saisir correctement la taille du ballon';
  }
  if ( $status_ballon != 'vide' && $status_ballon != 'commande' && $status_ballon != 'stock' && $status_ballon != 'affecte' ) {
    $aError[]			=		'Veuillez saisir correctement la taille du ballon';
  }
  if($status_ballon == 'vide'){
    $date_ballon = null;
  } elseif($status_ballon == 'commande' || $status_ballon == 'stock' || $status_ballon == 'affecte'){
    $date_ballon = date("Y-m-d H:i:s");
  }

  if ( $taille_chasuble != '116/128' && $taille_chasuble != '140/152' && $taille_chasuble != '164/176' && $taille_chasuble != 'S' && $taille_chasuble != 'M' && $taille_chasuble != 'L'
&& $taille_chasuble != 'XL' && $taille_chasuble != 'XXL' && $taille_chasuble != '' ) {
    $aError[]			=		'Veuillez saisir correctement la taille du chasuble';
  }
  if ( $status_chasuble != 'vide' && $status_chasuble != 'commande' && $status_chasuble != 'stock' && $status_chasuble != 'affecte' ) {
    $aError[]			=		'Veuillez saisir correctement la taille du chasuble';
  }
  if($status_chasuble == 'vide'){
    $date_chasuble = null;
  } elseif($status_chasuble == 'commande' || $status_chasuble == 'stock' || $status_chasuble == 'affecte'){
    $date_chasuble = date("Y-m-d H:i:s");
  }

$date_creation_adherent = date("Y-m-d H:i:s");

//var_dump($date_creation_adherent, $date_naissance);exit();

	if ( empty ( $aError )){

		$sQuery				=	'
			INSERT INTO
      `adherents`
					(
						`HR_ADHERENT_NUM_LICENCE`,`HR_ADHERENT_NOM`,`HR_ADHERENT_PRENOM`,`HR_ADHERENT_NUM_RUE`,`HR_ADHERENT_NOM_RUE`,`HR_ADHERENT_CODE_POSTAL`,`HR_ADHERENT_VILLE`,`HR_ADHERENT_TEL_DOM`,`HR_ADHERENT_TEL_MOB1`,`HR_ADHERENT_TEL_MOB2`,`HR_ADHERENT_ADRESSE_MAIL`,`HR_ADHERENT_DATE_NAISSANCE`,`HR_ADHERENT_SEXE`,`HR_ADHERENT_CATEGORIE`,`HR_ADHERENT_FONCTION`,`HR_ADHERENT_MUTATION`,`HR_MOYEN_PAIMENT1`,`HR_MOYEN_PAIMENT2`,`HR_MOYEN_PAIMENT3`,`HR_MOYEN_PAIMENT4`,`HR_MOYEN_PAIMENT5`
            ,`HR_MONTANT_PAIEMENT1`,`HR_MONTANT_PAIEMENT2`,`HR_MONTANT_PAIEMENT3`,`HR_MONTANT_PAIEMENT4`,`HR_MONTANT_PAIEMENT5`,`HR_CHEQUE_CAUTION_NUM`,`HR_DOC_MANQUANT`,`HR_ADHERENT_DATE_QUALIF`,`HR_ADHERENT_FI`,`HR_ADHERENT_CBC`
            ,`HR_ADHERENT_COMMENT`,`HR_TEESHIRT_NUM`,`HR_TEESHIRT_TAILLE`,`HR_TEESHIRT_STATUS`,`HR_TEESHIRT_STATUS_DATE`,`HR_CHAUSSETTE_TAILLE`,`HR_CHAUSSETTE_STATUS`,`HR_CHAUSSETTE_STATUS_DATE`,`HR_BALLON_TAILLE`,`HR_BALLON_STATUS`,`HR_BALLON_STATUS_DATE`
            ,`HR_CHASUBLE_TAILLE`,`HR_CHASUBLE_STATUS`,`HR_CHASUBLE_STATUS_DATE`
					)
			VALUES
				(
					:numero_licence,:adherent_nom,:adherent_prenom,:numero_rue,:nom_rue,:code_postal,:ville,:telephone_domicile,:telephone_mobile1,:telephone_mobile2,:adresse_mail,:date_naissance,:sexe,:categorie,:fonction,:mutation,:moyen_paiement1,:moyen_paiement2,:moyen_paiement3,:moyen_paiement4,:moyen_paiement5,
          :montant_paiement1,:montant_paiement2,:montant_paiement3,:montant_paiement4,:montant_paiement5,:cheque_caution_numero,:document_manquant,:date_qualification,:fiche_inscription,:charte_bonne_conduite,:commentaire,:numero_teeshirt,:taille_teeshirt,:status_teeshirt,:date_teeshirt,:taille_chaussette,:status_chaussette,:date_chaussette,:taille_ballon,:status_ballon,:date_ballon,:taille_chasuble,:status_chasuble,:date_chasuble
				)
			;
		';
		$aParamUser			=	[
		':numero_licence'			      =>	$numero_licence,
		':adherent_nom'			        =>	$adherent_nom,
		':adherent_prenom'				  =>	$adherent_prenom,
		':numero_rue'			          =>	$numero_rue,
		':nom_rue'			            =>	$nom_rue,
		':code_postal'				      =>	$code_postal,
		':ville'				            =>	$ville,
		':telephone_domicile'				=>	$telephone_domicile,
		':telephone_mobile1'				=>	$telephone_mobile1,
		':telephone_mobile2'				=>	$telephone_mobile2,
		':adresse_mail'				      =>	$adresse_mail,
		':date_naissance'				    =>	$date_naissance,
		':sexe'				              =>	$sexe,
		':categorie'				        =>	$categorie,
		':fonction'				          =>	$fonction,
		':mutation'				          =>	$mutation,
		':moyen_paiement1'				  =>	$moyen_paiement1,
		':moyen_paiement2'				  =>	$moyen_paiement2,
		':moyen_paiement3'				  =>	$moyen_paiement3,
		':moyen_paiement4'				  =>	$moyen_paiement4,
		':moyen_paiement5'				  =>	$moyen_paiement5,
		':montant_paiement1'				=>	$montant_paiement1,
		':montant_paiement2'				=>	$montant_paiement2,
		':montant_paiement3'				=>	$montant_paiement3,
		':montant_paiement4'				=>	$montant_paiement4,
		':montant_paiement5'				=>	$montant_paiement5,
		':cheque_caution_numero'		=>	$cheque_caution_numero,
		':document_manquant'        =>  $document_manquant,
		':date_qualification'				=>	$date_qualification,
		':fiche_inscription'				=>	$fiche_inscription,
		':charte_bonne_conduite'	  =>	$charte_bonne_conduite,
		':commentaire'				      =>	$commentaire,
		':numero_teeshirt'				  =>	$numero_teeshirt,
		':taille_teeshirt'				  =>	$taille_teeshirt,
		':status_teeshirt'				  =>	$status_teeshirt,
		':date_teeshirt'				    =>	$date_teeshirt,
		':taille_chaussette'				=>	$taille_chaussette,
		':status_chaussette'				=>	$status_chaussette,
		':date_chaussette'				  =>	$date_chaussette,
		':taille_ballon'				    =>	$taille_ballon,
		':status_ballon'				    =>	$status_ballon,
		':date_ballon'				      =>	$date_ballon,
		':taille_chasuble'				  =>	$taille_chasuble,
		':status_chasuble'				  =>	$status_chasuble,
		':date_chasuble'				    =>	$date_chasuble,

		];
  //var_dump($aParamUser);exit();
//var_dump($aParamUser);exit();
		$oQuery	=	$connexion->prepare ( $sQuery );

		$bReturn = $oQuery->execute( $aParamUser );
		if ($bReturn == 0 ) {
		$aError[]			=		'Une erreur est survenue veuillez contacter un adminitrateur';
		} else {
            echo '<p class="alert alert-success">Adherent ajouté</p>';
            echo '<script language="Javascript">
               <!--
                     document.location.replace("admin.php?page=ajout_adherent");
               // -->
            </script>';
    }
  }
}


$sAdherents					=	'
		SELECT *
		FROM adherents
	';

// ---
// Préparation et execution de la requête
$oAdherents				=	$connexion->query($sAdherents);
$aAdherents				=	$oAdherents->fetchAll(PDO::FETCH_ASSOC);
