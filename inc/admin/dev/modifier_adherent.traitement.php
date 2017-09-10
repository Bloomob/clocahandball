<?php
require_once("inc/connexion_bdd_pdo.php");


if(isset($_GET['id'])):
    $sAdherents =
    '
    select *
    from adherents
    where HR_ADHERENT_ID = "'.$_GET['id'].'"
    ';
    $oAdherents				=	$connexion->query($sAdherents);
    $aAdherents				=	$oAdherents->fetchAll(PDO::FETCH_ASSOC);

    $date_qualification = explode(', ', $aAdherents[0]['HR_DOC_MANQUANT']);
    foreach ($date_qualification as $key => $value) {
      if($value == 'tous'){
        $tous = $value;
      }elseif($value == 'photo'){
        $photo = $value;
      }elseif($value == 'autorisation_parentale'){
        $autorisation_parentale = $value;
      }elseif($value == 'certificat_medicale'){
        $certificat_medicale = $value;
      }elseif($value == 'questionnaire_sante'){
        $questionnaire_sante = $value;
      }elseif($value == 'piece_identite'){
        $piece_identite = $value;
      }
    }
    
    $document_manquant = '';
    if( !empty($_POST['tous']) ){
      $document_manquant .= $_POST['tous'];
    }
    if (!empty($_POST['photo'])){
      if(empty($document_manquant)){
        $document_manquant .= $_POST['photo'];
      }else{
        $document_manquant .= ', ' . $_POST['photo'];
      }

    }
    if (!empty($_POST['autorisation_parentale'])){
      if(empty($document_manquant)){
        $document_manquant .= $_POST['autorisation_parentale'];
      }else{
        $document_manquant .= ', ' . $_POST['autorisation_parentale'];
      }

    }
    if (!empty($_POST['certificat_medicale'])){
      if(empty($document_manquant)){
        $document_manquant .= $_POST['certificat_medicale'];
      }else{
        $document_manquant .= ', ' . $_POST['certificat_medicale'];
      }

    }
    if (!empty($_POST['questionnaire_sante'])){
      if(empty($document_manquant)){
        $document_manquant .= $_POST['questionnaire_sante'];
      }else{
        $document_manquant .= ', ' . $_POST['questionnaire_sante'];
      }

    }
    if (!empty($_POST['piece_identite'])){
      if(empty($document_manquant)){
        $document_manquant .= $_POST['piece_identite'];
      }else{
        $document_manquant .=  ', ' . $_POST['piece_identite'];
      }

    }
    if(isset($_POST['status_teeshirt'])):
        if($aAdherents[0]['HR_TEESHIRT_STATUS'] != $_POST['status_teeshirt'])
          $date_teeshirt = date("Y-m-d");
        else
          $date_teeshirt = $aAdherents[0]['HR_TEESHIRT_STATUS_DATE'];
    endif;
    if(isset($_POST['status_chaussette'])):
        if($aAdherents[0]['HR_CHAUSSETTE_STATUS'] != $_POST['status_chaussette'])
          $date_chaussette = date("Y-m-d");
        else
          $date_chaussette = $aAdherents[0]['HR_CHAUSSETTE_STATUS_DATE'];
    endif;
    if(isset($_POST['status_ballon'])):
        if($aAdherents[0]['HR_BALLON_STATUS'] != $_POST['status_ballon'])
          $date_ballon = date("Y-m-d");
        else
          $date_ballon = $aAdherents[0]['HR_BALLON_STATUS_DATE'];
    endif;
    if(isset($_POST['status_chasuble'])):
        if($aAdherents[0]['HR_CHASUBLE_STATUS'] != $_POST['status_chasuble'])
          $date_chasuble = date("Y-m-d");
        else
          $date_chasuble = $aAdherents[0]['HR_CHASUBLE_STATUS_DATE'];
    endif;
    //var_dump($aAdherents[0]['HR_TEESHIRT_DATE']);exit();


    if(!empty($_POST['modifier'])){
      $sModifier = '
    UPDATE adherents
    SET HR_ADHERENT_NUM_LICENCE = :numero_licence,
      HR_ADHERENT_NOM = :adherent_nom,
      HR_ADHERENT_PRENOM = :adherent_prenom,
      HR_ADHERENT_NUM_RUE = :numero_rue,
      HR_ADHERENT_NOM_RUE = :nom_rue,
      HR_ADHERENT_CODE_POSTAL = :code_postal,
      HR_ADHERENT_VILLE = :ville,
      HR_ADHERENT_TEL_DOM = :telephone_domicile,
      HR_ADHERENT_TEL_MOB1 = :telephone_mobile1,
      HR_ADHERENT_TEL_MOB2 = :telephone_mobile2,
      HR_ADHERENT_ADRESSE_MAIL = :adresse_mail,
      HR_ADHERENT_DATE_NAISSANCE = :date_naissance,
      HR_ADHERENT_SEXE = :sexe,
      HR_ADHERENT_CATEGORIE = :categorie,
      HR_ADHERENT_FONCTION = :fonction,
      HR_ADHERENT_MUTATION = :mutation,
      HR_MOYEN_PAIMENT1 = :moyen_paiement1,
      HR_MOYEN_PAIMENT2 = :moyen_paiement2,
      HR_MOYEN_PAIMENT3 = :moyen_paiement3,
      HR_MOYEN_PAIMENT4 = :moyen_paiement4,
      HR_MOYEN_PAIMENT5 = :moyen_paiement5,
      HR_MONTANT_PAIEMENT1 = :montant_paiement1,
      HR_MONTANT_PAIEMENT2 = :montant_paiement2,
      HR_MONTANT_PAIEMENT3 = :montant_paiement3,
      HR_MONTANT_PAIEMENT4 = :montant_paiement4,
      HR_MONTANT_PAIEMENT5 = :montant_paiement5,
      HR_CHEQUE_CAUTION_NUM = :cheque_caution_numero,
      HR_DOC_MANQUANT = :document_manquant,
      HR_ADHERENT_DATE_QUALIF = :date_qualification,
      HR_ADHERENT_FI = :fiche_inscription,
      HR_ADHERENT_CBC = :charte_bonne_conduite,
      HR_ADHERENT_COMMENT = :commentaire,
      HR_TEESHIRT_NUM = :numero_teeshirt,
      HR_TEESHIRT_TAILLE = :taille_teeshirt,
      HR_TEESHIRT_STATUS = :status_teeshirt,
      HR_TEESHIRT_STATUS_DATE = :date_teeshirt,
      HR_CHAUSSETTE_TAILLE = :taille_chaussette,
      HR_CHAUSSETTE_STATUS = :status_chaussette,
      HR_CHAUSSETTE_STATUS_DATE = :date_chaussette,
      HR_BALLON_TAILLE = :taille_ballon,
      HR_BALLON_STATUS = :status_ballon,
      HR_BALLON_STATUS_DATE = :date_ballon,
      HR_CHASUBLE_TAILLE = :taille_chasuble,
      HR_CHASUBLE_STATUS = :status_chasuble,
      HR_CHASUBLE_STATUS_DATE = :date_chasuble
    WHERE HR_ADHERENT_ID = :id
      ';
      $aParamUser			=	[
        ':numero_licence'			      =>	$_POST['numero_licence'],
        ':adherent_nom'			        =>	strtoupper($_POST['adherent_nom']),
        ':adherent_prenom'				  =>	strtoupper($_POST['adherent_prenom']),
        ':numero_rue'			          =>	$_POST['numero_rue'],
        ':nom_rue'			            =>	$_POST['nom_rue'],
        ':code_postal'				      =>	$_POST['code_postal'],
        ':ville'				            =>	$_POST['ville'],
        ':telephone_domicile'				=>	$_POST['telephone_domicile'],
        ':telephone_mobile1'				=>	$_POST['telephone_mobile1'],
        ':telephone_mobile2'				=>	$_POST['telephone_mobile2'],
        ':adresse_mail'				      =>	$_POST['adresse_mail'],
        ':date_naissance'				    =>	$_POST['date_naissance'],
        ':sexe'				              =>	$_POST['sexe'],
        ':categorie'				        =>	$_POST['categorie'],
        ':fonction'				          =>	$_POST['fonction'],
        ':mutation'				          =>	$_POST['mutation'],
        ':moyen_paiement1'				  =>	$_POST['moyen_paiement1'],
        ':moyen_paiement2'				  =>	$_POST['moyen_paiement2'],
        ':moyen_paiement3'				  =>	$_POST['moyen_paiement3'],
        ':moyen_paiement4'				  =>	$_POST['moyen_paiement4'],
        ':moyen_paiement5'				  =>	$_POST['moyen_paiement5'],
        ':montant_paiement1'				=>	$_POST['montant_paiement1'],
        ':montant_paiement2'				=>	$_POST['montant_paiement2'],
        ':montant_paiement3'				=>	$_POST['montant_paiement3'],
        ':montant_paiement4'				=>	$_POST['montant_paiement4'],
        ':montant_paiement5'				=>	$_POST['montant_paiement5'],
        ':cheque_caution_numero'		=>	$_POST['cheque_caution_numero'],
        ':document_manquant'        =>  $document_manquant,
        ':date_qualification'				=>	$_POST['date_qualification'],
        ':fiche_inscription'				=>	$_POST['fiche_inscription'],
        ':charte_bonne_conduite'	  =>	$_POST['charte_bonne_conduite'],
        ':commentaire'				      =>	$_POST['commentaire'],
        ':numero_teeshirt'				  =>	$_POST['numero_teeshirt'],
        ':taille_teeshirt'				  =>	$_POST['taille_teeshirt'],
        ':status_teeshirt'				  =>	$_POST['status_teeshirt'],
        ':date_teeshirt'				    =>	$date_teeshirt,
        ':taille_chaussette'				=>	$_POST['taille_chaussette'],
        ':status_chaussette'				=>	$_POST['status_chaussette'],
        ':date_chaussette'				  =>	$date_chaussette,
        ':taille_ballon'				    =>	$_POST['taille_ballon'],
        ':status_ballon'				    =>	$_POST['status_ballon'],
        ':date_ballon'				      =>	$date_ballon,
        ':taille_chasuble'				  =>	$_POST['taille_chasuble'],
        ':status_chasuble'				  =>	$_POST['status_chasuble'],
        ':date_chasuble'				    =>	$date_chasuble,
        ':id'                       => $_GET['id'],
      ];
      $oModifier	=	$connexion->prepare ( $sModifier );
      $bReturn = $oModifier->execute( $aParamUser );
    //  var_dump($aParamUser);exit();


      if ($bReturn == 0 ) {
        echo 'erreur veuillez contacter un adminitrateur';
      } else {
            echo '<p class="alert alert-success">Adherent modifié</p>';
            echo '<script language="Javascript">
               <!--
                     document.location.replace("admin.php?page=afficher_adherents");
               // -->
            </script>';
      }
    }
endif;