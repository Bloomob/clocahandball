<?php include_once('dev/modifier_adherent.traitement.php'); ?>
<div class="wrapper adherents">
    <div class="row text-center">
        <div class="col-md-12">
            <h3 id="title_tenue_ajout">Modifier Adherent</h3>
        </div>
        </div>
        <div class="row">
          <div class="col-md-5 col-md-offset-4">
            <form class="form_ajout_adherent" action="admin.php?page=modifier_adherent&amp;id=<?php echo $_GET['id']; ?>" method="post">

              <div id="input_numero_licence" class="form-group">
                <label for="numero_licence">Numéro de la licence ( 5 derniers chiffres ):</label>
                <input type="text" id="numero_licence" name="numero_licence" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_NUM_LICENCE']; ?>">
              </div>

              <div id="input_adherent_nom" class="form-group">
                <label for="adherent_nom">Nom de l'adhérent :</label>
                <input type="text" id="adherent_nom" name="adherent_nom" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_NOM']; ?>">
              </div>

              <div id="input_adherent_prenom" class="form-group">
                <label for="adherent_prenom">Prenom de l'adhérent :</label>
                <input type="text" id="adherent_prenom" name="adherent_prenom" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_PRENOM']; ?>">
              </div>

              <div id="input_adherent_numero_rue" class="form-group">
                <label for="numero_rue">Numero de la rue de l'adhérent :</label>
                <input type="text" id="numero_rue" name="numero_rue" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_NUM_RUE']; ?>">
              </div>

              <div id="input_adherent_nom_rue" class="form-group">
                <label for="nom_rue">Nom de la rue de l'adhérent :</label>
                <input type="text" id="nom_rue" name="nom_rue" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_NOM_RUE']; ?>">
              </div>

              <div id="input_adherent_code_postal" class="form-group">
                <label for="code_postal">Code Postal de l'adhérent :</label>
                <input type="text" id="code_postal" name="code_postal" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_CODE_POSTAL']; ?>">
              </div>

              <div id="input_adherent_ville" class="form-group">
                <label for="ville">Ville de l'adhérent :</label>
                <input type="text" id="ville" name="ville" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_VILLE']; ?>">
              </div>

              <div id="input_adherent_telephone_domicile" class="form-group">
                <label for="telephone_domicile">Numero de téléphone du domicile de l'adhérent :</label>
                <input type="text" id="telephone_domicile" name="telephone_domicile" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_TEL_DOM']; ?>">
              </div>

              <div id="input_adherent_telephone_mobile1" class="form-group">
                <label for="telephone_mobile1">Numero de téléphone du mobile 1 de l'adhérent :</label>
                <input type="text" id="telephone_mobile1" name="telephone_mobile1" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_TEL_MOB1']; ?>">
              </div>

              <div id="input_adherent_telephone_mobile2" class="form-group">
                <label for="telephone_mobile2">Numero de téléphone du mobile 2 de l'adhérent :</label>
                <input type="text" id="telephone_mobile2" name="telephone_mobile2" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_TEL_MOB2']; ?>">
              </div>

              <div id="input_adherent_adresse_mail" class="form-group">
                <label for="adresse_mail">Adresse email de l'adhérent :</label>
                <input type="text" id="adresse_mail" name="adresse_mail" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_ADRESSE_MAIL']; ?>">
              </div>

              <div id="input_date_naissance" class="form-group">
                <label for="date_naissance">Date de naissance de l'adhérent :</label>
                <input type="text" id="date_naissance" name="date_naissance" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_DATE_NAISSANCE']; ?>">
              </div>

              <div id="input_sexe" class="form-group">
                <label for="sexe">Sexe de l'adhérent :</label>
                <select name="sexe" id="sexe">
                     <option <?php if($aAdherents[0]['HR_ADHERENT_SEXE'] == 'M'){ ?>selected="selected" <?php } ?> value="M">M</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_SEXE'] == 'F'){ ?>selected="selected" <?php } ?> value="F">F</option>
                </select>
              </div>

              <div id="input_categorie" class="form-group">
                <label for="categorie">Categorie de l'adhérent :</label>
                <select name="categorie" id="categorie">
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '+16G'){ ?>selected="selected" <?php } ?> value="+16G">+16G</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '+16F'){ ?>selected="selected" <?php } ?> value="+16F">+16F</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '-20G'){ ?>selected="selected" <?php } ?> value="-20G">-20G</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '-18G'){ ?>selected="selected" <?php } ?> value="-18G">-18G</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '-18F'){ ?>selected="selected" <?php } ?> value="-18F">-18F</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '-17G'){ ?>selected="selected" <?php } ?> value="-17G">-17G</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '-15G'){ ?>selected="selected" <?php } ?> value="-15G">-15G</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '-15F'){ ?>selected="selected" <?php } ?> value="-15F">-15F</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '-13G'){ ?>selected="selected" <?php } ?> value="-13G">-13G</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '-13F'){ ?>selected="selected" <?php } ?> value="-13F">-13F</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '-11G'){ ?>selected="selected" <?php } ?> value="-11G">-11G</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '-11F'){ ?>selected="selected" <?php } ?> value="-11F">-11F</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == '-9'){ ?>selected="selected" <?php } ?> value="-9">-9</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == 'ecole'){ ?>selected="selected" <?php } ?> value="ecole">Ecole</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == 'loisir'){ ?>selected="selected" <?php } ?> value="loisir">Loisir</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CATEGORIE'] == 'dirigeant'){ ?>selected="selected" <?php } ?> value="dirigeant">Dirigeant</option>
                </select>
              </div>

              <div id="input_fonction" class="form-group">
                <label for="fonction">Fonction de l'adhérent :</label>
                <select name="fonction" id="fonction">
                     <option <?php if($aAdherents[0]['HR_ADHERENT_FONCTION'] == 'dirigeant'){ ?>selected="selected" <?php } ?> value="dirigeant">Dirigeant</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_FONCTION'] == 'bureau'){ ?>selected="selected" <?php } ?> value="bureau">Bureau</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_FONCTION'] == 'arbitre'){ ?>selected="selected" <?php } ?> value="arbitre">Arbitre</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_FONCTION'] == 'entraineur'){ ?>selected="selected" <?php } ?> value="entraineur">Entraineur</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_FONCTION'] == 'joueur'){ ?>selected="selected" <?php } ?> value="joueur" >Joueur</option>
                </select>
              </div>

              <div id="input_mutation" class="form-group">
                <label for="mutation">Mutation (Oui/Non) :</label>
                <select name="mutation" id="mutation">
                     <option <?php if($aAdherents[0]['HR_ADHERENT_MUTATION'] == '1'){ ?>selected="selected" <?php } ?> value="1">Oui</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_MUTATION'] == '0'){ ?>selected="selected" <?php } ?> value="0">Non</option>
                </select>
              </div>

              <div id="input_moyen_paiement1" class="form-group">
                <label for="moyen_paiement1">Moyen de paiement 1 :</label>
                <select name="moyen_paiement1" id="moyen_paiement1">
                     <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT1'] == 'aucun'){ ?>selected="selected" <?php } ?> value="aucun">Aucun</option>
                     <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT1'] == 'liquide'){ ?>selected="selected" <?php } ?> value="liquide">Liquide</option>
                     <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT1'] == 'cheque'){ ?>selected="selected" <?php } ?> value="cheque">Chèque</option>
                     <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT1'] == 'bon_caf'){ ?>selected="selected" <?php } ?> value="bon_caf">Bon CAF</option>
                     <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT1'] == 'cheque_vacance'){ ?>selected="selected" <?php } ?> value="cheque_vacance">Chèque vacance</option>
                     <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT1'] == 'coupon_sport'){ ?>selected="selected" <?php } ?> value="coupon_sport">Coupon Sport</option>
                </select>
              </div>

              <div id="input_montant_paiement1" class="form-group">
                <label for="montant_paiement1">Montant du paiement 1 de l'adhérent :</label>
                <input type="number" id="montant_paiement1" name="montant_paiement1" class="champ" value="<?php echo $aAdherents[0]['HR_MONTANT_PAIEMENT1']; ?>">
              </div>

              <div id="input_moyen_paiement2" class="form-group">
                <label for="moyen_paiement2">Moyen de paiement 2 :</label>
                <select name="moyen_paiement2" id="moyen_paiement2">
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT2'] == 'aucun'){ ?>selected="selected" <?php } ?> value="aucun">Aucun</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT2'] == 'liquide'){ ?>selected="selected" <?php } ?> value="liquide">Liquide</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT2'] == 'cheque'){ ?>selected="selected" <?php } ?> value="cheque">Chèque</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT2'] == 'bon_caf'){ ?>selected="selected" <?php } ?> value="bon_caf">Bon CAF</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT2'] == 'cheque_vacance'){ ?>selected="selected" <?php } ?> value="cheque_vacance">Chèque vacance</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT2'] == 'coupon_sport'){ ?>selected="selected" <?php } ?> value="coupon_sport">Coupon Sport</option>
                </select>
              </div>

              <div id="input_montant_paiement2" class="form-group">
                <label for="montant_paiement2">Montant du paiement 2 de l'adhérent :</label>
                <input type="number" id="montant_paiement2" name="montant_paiement2" class="champ" value="<?php echo $aAdherents[0]['HR_MONTANT_PAIEMENT2']; ?>">
              </div>

              <div id="input_moyen_paiement3" class="form-group">
                <label for="moyen_paiement3">Moyen de paiement 3 :</label>
                <select name="moyen_paiement3" id="moyen_paiement3">
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT3'] == 'aucun'){ ?>selected="selected" <?php } ?> value="aucun">Aucun</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT3'] == 'liquide'){ ?>selected="selected" <?php } ?> value="liquide">Liquide</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT3'] == 'cheque'){ ?>selected="selected" <?php } ?> value="cheque">Chèque</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT3'] == 'bon_caf'){ ?>selected="selected" <?php } ?> value="bon_caf">Bon CAF</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT3'] == 'cheque_vacance'){ ?>selected="selected" <?php } ?> value="cheque_vacance">Chèque vacance</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT3'] == 'coupon_sport'){ ?>selected="selected" <?php } ?> value="coupon_sport">Coupon Sport</option>
                </select>
              </div>

              <div id="input_montant_paiement3" class="form-group">
                <label for="montant_paiement3">Montant du paiement 3 de l'adhérent :</label>
                <input type="number" id="montant_paiement3" name="montant_paiement3" class="champ" value="<?php echo $aAdherents[0]['HR_MONTANT_PAIEMENT3']; ?>">
              </div>

              <div id="input_moyen_paiement4" class="form-group">
                <label for="moyen_paiement4">Moyen de paiement 4 :</label>
                <select name="moyen_paiement4" id="moyen_paiement4">
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT4'] == 'aucun'){ ?>selected="selected" <?php } ?> value="aucun">Aucun</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT4'] == 'liquide'){ ?>selected="selected" <?php } ?> value="liquide">Liquide</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT4'] == 'cheque'){ ?>selected="selected" <?php } ?> value="cheque">Chèque</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT4'] == 'bon_caf'){ ?>selected="selected" <?php } ?> value="bon_caf">Bon CAF</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT4'] == 'cheque_vacance'){ ?>selected="selected" <?php } ?> value="cheque_vacance">Chèque vacance</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT4'] == 'coupon_sport'){ ?>selected="selected" <?php } ?> value="coupon_sport">Coupon Sport</option>
                </select>
              </div>

              <div id="input_montant_paiement4" class="form-group">
                <label for="montant_paiement4">Montant du paiement 4 de l'adhérent :</label>
                <input type="number" id="montant_paiement4" name="montant_paiement4" class="champ" value="<?php echo $aAdherents[0]['HR_MONTANT_PAIEMENT4']; ?>">
              </div>

              <div id="input_moyen_paiement5" class="form-group">
                <label for="moyen_paiement5">Moyen de paiement 5 :</label>
                <select name="moyen_paiement5" id="moyen_paiement5">
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT5'] == 'aucun'){ ?>selected="selected" <?php } ?> value="aucun">Aucun</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT5'] == 'liquide'){ ?>selected="selected" <?php } ?> value="liquide">Liquide</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT5'] == 'cheque'){ ?>selected="selected" <?php } ?> value="cheque">Chèque</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT5'] == 'bon_caf'){ ?>selected="selected" <?php } ?> value="bon_caf">Bon CAF</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT5'] == 'cheque_vacance'){ ?>selected="selected" <?php } ?> value="cheque_vacance">Chèque vacance</option>
                  <option <?php if($aAdherents[0]['HR_MOYEN_PAIMENT5'] == 'coupon_sport'){ ?>selected="selected" <?php } ?> value="coupon_sport">Coupon Sport</option>
                </select>
              </div>

              <div id="input_montant_paiement5" class="form-group">
                <label for="montant_paiement5">Montant du paiement 5 de l'adhérent :</label>
                <input type="number" id="montant_paiement5" name="montant_paiement5" class="champ" value="<?php echo $aAdherents[0]['HR_MONTANT_PAIEMENT5']; ?>">
              </div>

              <div id="input_cheque_caution_numero" class="form-group">
                <label for="cheque_caution_numero">Numéro du chèque de caution de l'adhérent :</label>
                <input type="text" id="cheque_caution_numero" name="cheque_caution_numero" class="champ" value="<?php echo $aAdherents[0]['HR_CHEQUE_CAUTION_NUM']; ?>">
              </div>

              <div id="input_doc_manquant" class="form-group">
                <label>Document Maquant :</label><br>
                <div class="">
                  <input type="checkbox" id="tous" name="tous" class="champ" value="tous" <?php if(!empty($tous)){ ?> checked <?php } ?> >
                  <label for="tous">Tous</label>
                </div>
                <div class="">
                  <input type="checkbox" id="photo" name="photo" class="champ" value="photo" <?php if(!empty($photo)){ ?> checked <?php } ?>>
                  <label for="photo">Photo</label>
                </div>
                <div class="">
                  <input type="checkbox" id="autorisation_parentale" name="autorisation_parentale" class="champ" value="autorisation_parentale" <?php if(!empty($autorisation_parentale)){ ?> checked <?php } ?>>
                  <label for="autorisation_parentale">Autorisation Parentale</label>
                </div>
                <div class="">
                  <input type="checkbox" id="certificat_medicale" name="certificat_medicale" class="champ" value="certificat_medicale" <?php if(!empty($certificat_medicale)){ ?> checked <?php } ?>>
                  <label for="certificat_medicale">Certificat Médicale</label>
                </div>
                <div class="">
                  <input type="checkbox" id="questionnaire_sante" name="questionnaire_sante" class="champ" value="questionnaire_sante" <?php if(!empty($questionnaire_sante)){ ?> checked <?php } ?>>
                  <label for="questionnaire_sante">Questionnaire de santé</label>
                </div>
                <div class="">
                  <input type="checkbox" id="piece_identite" name="piece_identite" class="champ" value="piece_identite" <?php if(!empty($piece_identite)){ ?> checked <?php } ?>>
                  <label for="piece_identite">Pièce d'identitée</label>
                </div>

              </div>

              <div id="input_date_qualification" class="form-group">
                <label for="date_qualification">Date de qualification de l'adhérent :</label>
                <input type="text" id="date_qualification" name="date_qualification" class="champ" value="<?php echo $aAdherents[0]['HR_ADHERENT_DATE_QUALIF']; ?>">
              </div>

              <div id="input_fiche_inscription" class="form-group">
                <label for="fiche_inscription">Fiche d'inscription (Oui/Non) :</label>
                <select name="fiche_inscription" id="fiche_inscription">
                     <option <?php if($aAdherents[0]['HR_ADHERENT_FI'] == '1'){ ?>selected="selected" <?php } ?> value="1">Oui</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_FI'] == '0'){ ?>selected="selected" <?php } ?> value="0">Non</option>
                </select>
              </div>

              <div id="input_charte_bonne_conduite" class="form-group">
                <label for="charte_bonne_conduite">Charte de Bonne conduite (Oui/Non) :</label>
                <select name="charte_bonne_conduite" id="charte_bonne_conduite">
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CBC'] == '1'){ ?>selected="selected" <?php } ?> value="1">Oui</option>
                     <option <?php if($aAdherents[0]['HR_ADHERENT_CBC'] == '0'){ ?>selected="selected" <?php } ?> value="0">Non</option>
                </select>
              </div>

              <div id="input_commentaire" class="form-group">
                <label for="commentaire">Commentaire :</label>
                <textarea name="commentaire" rows="8" cols="60"><?php echo $aAdherents[0]['HR_ADHERENT_COMMENT']; ?></textarea>
              </div>

              <div id="input_numero_teeshirt" class="form-group" style="margin-top:110px;">
                <label for="numero_teeshirt">Numéro du tee-shirt :</label>
                <input type="text" id="numero_teeshirt" name="numero_teeshirt" class="champ" value="<?php echo $aAdherents[0]['HR_TEESHIRT_NUM']; ?>" placeholder="00">
              </div>

              <div id="input_taille_teeshirt" class="form-group">
                <label for="taille_teeshirt">Taille du tee-shirt :</label>
                <select name="taille_teeshirt" id="taille_teeshirt">
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_TAILLE'] == ''){ ?>selected="selected" <?php } ?> value="">Aucun</option>
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_TAILLE'] == '116/128'){ ?>selected="selected" <?php } ?> value="116/128">116/128</option>
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_TAILLE'] == '140/152'){ ?>selected="selected" <?php } ?> value="140/152">140/152</option>
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_TAILLE'] == '164/176'){ ?>selected="selected" <?php } ?> value="164/176">164/176</option>
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_TAILLE'] == 'S'){ ?>selected="selected" <?php } ?> value="S">S</option>
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_TAILLE'] == 'M'){ ?>selected="selected" <?php } ?> value="M">M</option>
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_TAILLE'] == 'L'){ ?>selected="selected" <?php } ?> value="L">L</option>
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_TAILLE'] == 'XL'){ ?>selected="selected" <?php } ?> value="XL">XL</option>
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_TAILLE'] == 'XXL'){ ?>selected="selected" <?php } ?> value="XXL">XXL</option>
                </select>
              </div>

              <div id="input_status_teeshirt" class="form-group">
                <label for="status_teeshirt">Status du tee-shirt :</label>
                <select name="status_teeshirt" id="status_teeshirt">
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_STATUS'] == 'vide'){ ?>selected="selected" <?php } ?> value="vide">Vide</option>
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_STATUS'] == 'commande'){ ?>selected="selected" <?php } ?> value="commande">En commande</option>
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_STATUS'] == 'stock'){ ?>selected="selected" <?php } ?> value="stock">En Stock</option>
                     <option <?php if($aAdherents[0]['HR_TEESHIRT_STATUS'] == 'affecte'){ ?>selected="selected" <?php } ?> value="affecte">Affecté</option>
                </select>
              </div>



              <div id="input_taille_chaussette" class="form-group">
                <label for="taille_chaussette">Taille des chaussette :</label>
                <select name="taille_chaussette" id="taille_chaussette">
                     <option <?php if($aAdherents[0]['HR_CHAUSSETTE_TAILLE'] == ''){ ?>selected="selected" <?php } ?> value="">Aucune</option>
                     <option <?php if($aAdherents[0]['HR_CHAUSSETTE_TAILLE'] == '33/35'){ ?>selected="selected" <?php } ?> value="33/35">33/35</option>
                     <option <?php if($aAdherents[0]['HR_CHAUSSETTE_TAILLE'] == '36/38'){ ?>selected="selected" <?php } ?> value="36/38">36/38</option>
                     <option <?php if($aAdherents[0]['HR_CHAUSSETTE_TAILLE'] == '39/42'){ ?>selected="selected" <?php } ?> value="39/42">39/42</option>
                     <option <?php if($aAdherents[0]['HR_CHAUSSETTE_TAILLE'] == '43/45'){ ?>selected="selected" <?php } ?> value="43/45">43/45</option>
                     <option <?php if($aAdherents[0]['HR_CHAUSSETTE_TAILLE'] == '46/48'){ ?>selected="selected" <?php } ?> value="46/48">46/48</option>
                </select>
              </div>

              <div id="input_status_chaussette" class="form-group">
                <label for="status_chaussette">Status des chaussette :</label>
                <select name="status_chaussette" id="status_chaussette">
                  <option <?php if($aAdherents[0]['HR_CHAUSSETTE_STATUS'] == 'vide'){ ?>selected="selected" <?php } ?> value="vide">Vide</option>
                  <option <?php if($aAdherents[0]['HR_CHAUSSETTE_STATUS'] == 'commande'){ ?>selected="selected" <?php } ?> value="commande">En commande</option>
                  <option <?php if($aAdherents[0]['HR_CHAUSSETTE_STATUS'] == 'stock'){ ?>selected="selected" <?php } ?> value="stock">En Stock</option>
                  <option <?php if($aAdherents[0]['HR_CHAUSSETTE_STATUS'] == 'affecte'){ ?>selected="selected" <?php } ?> value="affecte">Affecté</option>
                </select>
              </div>


              <div id="input_taille_ballon" class="form-group">
                <label for="taille_ballon">Taille du ballon :</label>
                <select name="taille_ballon" id="taille_ballon">
                     <option  <?php if($aAdherents[0]['HR_BALLON_TAILLE'] == ''){ ?>selected="selected" <?php } ?> value="" selected="selected" >Aucun</option>
                     <option  <?php if($aAdherents[0]['HR_BALLON_TAILLE'] == 'T0'){ ?>selected="selected" <?php } ?> value="T0">T0</option>
                     <option  <?php if($aAdherents[0]['HR_BALLON_TAILLE'] == 'T1'){ ?>selected="selected" <?php } ?> value="T1">T1</option>
                     <option  <?php if($aAdherents[0]['HR_BALLON_TAILLE'] == 'T2'){ ?>selected="selected" <?php } ?> value="T2">T2</option>
                     <option  <?php if($aAdherents[0]['HR_BALLON_TAILLE'] == 'T3'){ ?>selected="selected" <?php } ?> value="T3">T3</option>
                </select>
              </div>

              <div id="input_status_ballon" class="form-group">
                <label for="status_ballon">Status du ballon :</label>
                <select name="status_ballon" id="status_ballon">
                  <option <?php if($aAdherents[0]['HR_BALLON_STATUS'] == 'vide'){ ?>selected="selected" <?php } ?> value="vide">Vide</option>
                  <option <?php if($aAdherents[0]['HR_BALLON_STATUS'] == 'commande'){ ?>selected="selected" <?php } ?> value="commande">En commande</option>
                  <option <?php if($aAdherents[0]['HR_BALLON_STATUS'] == 'stock'){ ?>selected="selected" <?php } ?> value="stock">En Stock</option>
                  <option <?php if($aAdherents[0]['HR_BALLON_STATUS'] == 'affecte'){ ?>selected="selected" <?php } ?> value="affecte">Affecté</option>
                </select>
              </div>
              <div id="input_taille_chasuble" class="form-group">
                <label for="taille_chasuble">Taille du chasuble :</label>
                <select name="taille_chasuble" id="taille_chasuble">
                     <option <?php if($aAdherents[0]['HR_CHASUBLE_TAILLE'] == ''){ ?>selected="selected" <?php } ?> value="" selected="selected" >Aucun</option>
                     <option <?php if($aAdherents[0]['HR_CHASUBLE_TAILLE'] == '116/128'){ ?>selected="selected" <?php } ?> value="116/128">116/128</option>
                     <option <?php if($aAdherents[0]['HR_CHASUBLE_TAILLE'] == '140/152'){ ?>selected="selected" <?php } ?> value="140/152">140/152</option>
                     <option <?php if($aAdherents[0]['HR_CHASUBLE_TAILLE'] == '164/176'){ ?>selected="selected" <?php } ?> value="164/176">164/176</option>
                     <option <?php if($aAdherents[0]['HR_CHASUBLE_TAILLE'] == 'S'){ ?>selected="selected" <?php } ?> value="S">S</option>
                     <option <?php if($aAdherents[0]['HR_CHASUBLE_TAILLE'] == 'M'){ ?>selected="selected" <?php } ?> value="M">M</option>
                     <option <?php if($aAdherents[0]['HR_CHASUBLE_TAILLE'] == 'L'){ ?>selected="selected" <?php } ?> value="L">L</option>
                     <option <?php if($aAdherents[0]['HR_CHASUBLE_TAILLE'] == 'XL'){ ?>selected="selected" <?php } ?> value="XL">XL</option>
                     <option <?php if($aAdherents[0]['HR_CHASUBLE_TAILLE'] == 'XXL'){ ?>selected="selected" <?php } ?> value="XXL">XXL</option>
                </select>
              </div>
              <div id="input_status_chasuble" class="form-group">
                <label for="status_chasuble">Status du chasuble :</label>
                <select name="status_chasuble" id="status_chasuble">
                  <option <?php if($aAdherents[0]['HR_CHASUBLE_STATUS'] == 'vide'){ ?>selected="selected" <?php } ?> value="vide">Vide</option>
                  <option <?php if($aAdherents[0]['HR_CHASUBLE_STATUS'] == 'commande'){ ?>selected="selected" <?php } ?> value="commande">En commande</option>
                  <option <?php if($aAdherents[0]['HR_CHASUBLE_STATUS'] == 'stock'){ ?>selected="selected" <?php } ?> value="stock">En Stock</option>
                  <option <?php if($aAdherents[0]['HR_CHASUBLE_STATUS'] == 'affecte'){ ?>selected="selected" <?php } ?> value="affecte">Affecté</option>
                </select>
              </div>

              <div class=" col-lg-4 col-lg-offset-4 bouton">
                <input type="submit" name="modifier" value="Modifier" class="btn btn-warning">
              </div>
            </form>
        </div>
    </div>
</div>
