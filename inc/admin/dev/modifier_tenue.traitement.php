<?php
require_once("inc/connexion_bdd_pdo.php");

if(isset($_GET['id'])):
    $ssTenue					=	'
            SELECT *
            FROM tenue_match
        ';

    // ---
    // Préparation et execution de la requête
    $ooTenue				=	$connexion->query($ssTenue);
    $aaTenue 			=	$ooTenue->fetchAll(PDO::FETCH_ASSOC);

    $sTenue =
    '
    select *
    from tenue_match
    where HR_TENUE_ID = "'.$_GET['id'].'"
    ';
    $oTenue				=	$connexion->query($sTenue);
    $aTenue				=	$oTenue->fetchAll(PDO::FETCH_ASSOC);



    if(!empty($_POST['modifier'])){
      $sModifier = '
    UPDATE tenue_match
    SET HR_TENUE_NUMERO = :numero_tenue,
      HR_TENUE_TAILLE = :taille_tenue,
      HR_TENUE_SEXE = :sexe_tenue,
      HR_TENUE_POSTE = :poste_tenue,
      HR_TENUE_STATUS = :status_tenue,
      HR_TENUE_TYPE = :type_tenue
    WHERE HR_TENUE_ID = :id
      ';
      $aParamUser			=	[
        ':numero_tenue'			=>	$_POST['numero_tenue'],
        ':taille_tenue'			=>	$_POST['taille_tenue'],
        ':sexe_tenue'				=>	$_POST['sexe_tenue'],
        ':poste_tenue'			=>	$_POST['poste_tenue'],
        ':status_tenue'			=>	$_POST['status_tenue'],
        ':type_tenue'				=>	$_POST['type_tenue'],
        ':id'               => $_GET['id'],
      ];
      $oModifier	=	$connexion->prepare ( $sModifier );
      $bReturn = $oModifier->execute( $aParamUser );

      if ($bReturn == 0 ) {
        echo 'erreur veuillez contacter un adminitrateur';
      } else {
         echo '<p class="alert alert-success">Tenue modifié</p>';
          echo '<script language="Javascript">
               <!--
                     document.location.replace("admin.php?page=afficher_tenue");
               // -->
         </script>';
        // echo 'Sauvegarde effectuée';
      }
    }
endif;
