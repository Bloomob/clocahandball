<?php
require_once("inc/connexion_bdd_pdo.php");


$sTenue					=	'
		SELECT *
		FROM tenue_match
	';

// ---
// Préparation et execution de la requête
$oTenue				=	$connexion->query($sTenue);
$aTenue				=	$oTenue->fetchAll(PDO::FETCH_ASSOC);


if( empty($_POST['ajout'])){
  $numero_tenue=$taille_tenue=$sexe_tenue=$poste_tenue=$status_tenue=$type_tenue=$joueur_tenue= '';
} else {
	$numero_tenue					     =	( !empty( $_POST['numero_tenue'] ) )	?	htmlentities( $_POST['numero_tenue'])		  : '';
	$taille_tenue					     =	( !empty( $_POST['taille_tenue'] ) )	?	htmlentities( $_POST['taille_tenue'])		  : '';
	$sexe_tenue					       =	( !empty( $_POST['sexe_tenue'] ) )	  ? htmlentities( $_POST['sexe_tenue'] )  		: '';
	$poste_tenue					     =	( !empty( $_POST['poste_tenue'] ) )	  ? htmlentities( $_POST['poste_tenue'] )  		: '';
	$status_tenue	             =	( !empty( $_POST['status_tenue'] ) )  ?	htmlentities( $_POST['status_tenue'] )		: '';
	$type_tenue				         =	( !empty( $_POST['type_tenue'] ) )		?	htmlentities($_POST['type_tenue'] )				: '';
	$joueur_tenue				       =	( !empty( $_POST['joueur_tenue'] ) )		?	htmlentities($_POST['joueur_tenue'] )				: '';
  $aError					=	array();


if (empty($numero_tenue) ) {
		$aError[]			=		'Veuillez saisir un numéro de tenue de match';
	} elseif ($numero_tenue >= '100') {
		$aError[]			=		' Le numéro n\'a pas été bien saisie';
	}

  if ( empty($taille_tenue) ) {
    $aError[]			=		'Veuillez saisir une taille de tenue';
  }elseif( $taille_tenue != 'XXS' && $taille_tenue != 'XS' && $taille_tenue != 'S' && $taille_tenue != 'M' && $taille_tenue != 'L' && $taille_tenue != 'XL' && $taille_tenue != 'XXL' && $taille_tenue != 'XXXL'){

    $aError[]			=		'Veuillez saisir la bonne taille de tenue';
  }
  if ( empty($sexe_tenue) ) {
    $aError[]			=		'Veuillez saisir le sexe de la tenue';
  } elseif ( $sexe_tenue != 'M' && $sexe_tenue != 'F' ) {
    $aError[]			=		'Veuilez saisir le bon sexe de la tenue';
  }
  if ( empty($poste_tenue) ) {
    $aError[]			=		'Veuillez saisir le poste de la tenue';
  } elseif ( $poste_tenue != 'joueur' && $poste_tenue != 'gardien' ) {
    $aError[]			=		'Veuilez saisir le bon poste de la tenue';
  }
  if ( empty($status_tenue) ) {
    $aError[]			=		'Veuillez saisir le status de la tenue';
  } elseif ($status_tenue != 'stock' && $status_tenue != 'affecte' && $status_tenue != 'commande') {
    $aError[]			=		'Veuillez saisir le bon status de la tenue de match';
  }
  if ( empty($type_tenue) ) {
    $aError[]			=		'Veuillez saisir le type de la tenue';
  } elseif ($type_tenue != 'acheres' && $type_tenue != 'cap78' && $type_tenue != 'elite78' && $type_tenue != 'team2rives') {
    $aError[]			=		'Veuillez saisir le bon type de tenue de match';
  }
  if(empty($joueur_tenue)){
    $joueur_tenue = null;
  }

  for ( $i = 0; $i < count($aTenue); $i++ ) {
      if( $aTenue[$i]['HR_TENUE_NUMERO'] == $numero_tenue ) {
        $aError[]			=		'Le numéro de la tenue existe déjà';
      }
  }


	if ( empty ( $aError )){

		$sQuery				=	'
			INSERT INTO
      `tenue_match`
					(
						`HR_TENUE_NUMERO`,`HR_TENUE_TAILLE`,`HR_TENUE_SEXE`,`HR_TENUE_POSTE`,`HR_TENUE_STATUS`,`HR_TENUE_TYPE`,`HR_TENUE_ID_ADHERENT`
					)
			VALUES
				(
					:numero_tenue,:taille_tenue,:sexe_tenue,:poste_tenue,:status_tenue,:type_tenue,:id_adherent
				)
			;
		';
		$aParamUser			=	[
		':numero_tenue'			=>	$numero_tenue,
		':taille_tenue'			=>	$taille_tenue,
		':sexe_tenue'				=>	$sexe_tenue,
		':poste_tenue'			=>	$poste_tenue,
		':status_tenue'			=>	$status_tenue,
		':type_tenue'				=>	$type_tenue,
		':id_adherent'			=>	$joueur_tenue,

		];
//var_dump($aParamUser);exit();
		$oQuery	=	$connexion->prepare ( $sQuery );

		$bReturn = $oQuery->execute( $aParamUser );
		if ($bReturn == 0 ) {
		$aError[]			=		'Une erreur est survenue veuillez contacter un adminitrateur';
		} else {
            echo '<p class="alert alert-success">Tenue ajouté</p>';
            echo '<script language="Javascript">
               <!--
                     document.location.replace("admin.php?page=afficher_tenue");
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
