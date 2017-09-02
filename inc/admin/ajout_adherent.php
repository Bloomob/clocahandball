<?php include_once('dev/ajout_adherent.traitement.php'); ?>
<div class="wrapper adherents">
    <div class="row text-center">
        <div class="col-md-12">
            <h3 id="title_tenue_ajout">Ajout Adhérent</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-4">
            <form class="form_ajout_adherent" action="admin.php?page=ajout_adherent" method="post">
              <?php
              if ( !empty($aError) ) {

                ?>
              <div class="erreurs">
                <?php
                  foreach( $aError as $iError ) {
                    ?> <div class="alert alert-danger logerreur"><?php echo $iError; ?> </div> <?php
                  }
                ?>
              </div>
              <?php } ?>

              <div id="input_numero_licence" class="form-group">
                <label for="numero_licence">Numéro de la licence ( 5 derniers chiffres ):</label>
          			<input type="text" id="numero_licence" name="numero_licence" class="champ" value="">
          		</div>

              <div id="input_adherent_nom" class="form-group">
                <label for="adherent_nom">Nom de l'adhérent :</label>
                <input type="text" id="adherent_nom" name="adherent_nom" class="champ" value="">
          		</div>

              <div id="input_adherent_prenom" class="form-group">
                <label for="adherent_prenom">Prenom de l'adhérent :</label>
                <input type="text" id="adherent_prenom" name="adherent_prenom" class="champ" value="">
          		</div>

              <div id="input_adherent_numero_rue" class="form-group">
                <label for="numero_rue">Numero de la rue de l'adhérent :</label>
                <input type="text" id="numero_rue" name="numero_rue" class="champ" value="">
          		</div>

              <div id="input_adherent_nom_rue" class="form-group">
                <label for="nom_rue">Nom de la rue de l'adhérent :</label>
                <input type="text" id="nom_rue" name="nom_rue" class="champ" value="">
          		</div>

              <div id="input_adherent_code_postal" class="form-group">
                <label for="code_postal">Code Postal de l'adhérent :</label>
                <input type="text" id="code_postal" name="code_postal" class="champ" value="">
          		</div>

              <div id="input_adherent_ville" class="form-group">
                <label for="ville">Ville de l'adhérent :</label>
                <input type="text" id="ville" name="ville" class="champ" value="">
          		</div>

              <div id="input_adherent_telephone_domicile" class="form-group">
                <label for="telephone_domicile">Numero de téléphone du domicile de l'adhérent :</label>
                <input type="text" id="telephone_domicile" name="telephone_domicile" class="champ" value="">
          		</div>

              <div id="input_adherent_telephone_mobile1" class="form-group">
                <label for="telephone_mobile1">Numero de téléphone du mobile 1 de l'adhérent :</label>
                <input type="text" id="telephone_mobile1" name="telephone_mobile1" class="champ" value="">
          		</div>

              <div id="input_adherent_telephone_mobile2" class="form-group">
                <label for="telephone_mobile2">Numero de téléphone du mobile 2 de l'adhérent :</label>
                <input type="text" id="telephone_mobile2" name="telephone_mobile2" class="champ" value="">
          		</div>

              <div id="input_adherent_adresse_mail" class="form-group">
                <label for="adresse_mail">Adresse email de l'adhérent :</label>
                <input type="text" id="adresse_mail" name="adresse_mail" class="champ" value="">
          		</div>

              <div id="input_date_naissance" class="form-group">
                <label for="date_naissance">Date de naissance de l'adhérent :</label>
                <input type="date" id="date_naissance" name="date_naissance" class="champ" value="">
          		</div>

              <div id="input_sexe" class="form-group">
                <label for="sexe">Sexe de l'adhérent :</label>
                <select name="sexe" id="sexe">
                     <option value="M">M</option>
                     <option value="F">F</option>
                </select>
          		</div>

              <div id="input_categorie" class="form-group">
                <label for="categorie">Categorie de l'adhérent :</label>
                <select name="categorie" id="categorie">
                     <option value="+16G">+16G</option>
                     <option value="+16F">+16F</option>
                     <option value="-20G">-20G</option>
                     <option value="-18G">-18G</option>
                     <option value="-18F">-18F</option>
                     <option value="-17G">-17G</option>
                     <option value="-15G">-15G</option>
                     <option value="-15F">-15F</option>
                     <option value="-13G">-13G</option>
                     <option value="-13F">-13F</option>
                     <option value="-11G">-11G</option>
                     <option value="-11F">-11F</option>
                     <option value="-9">-9</option>
                     <option value="ecole">Ecole</option>
                     <option value="loisir">Loisir</option>
                     <option value="dirigeant">Dirigeant</option>
                </select>
          		</div>

              <div id="input_fonction" class="form-group">
                <label for="fonction">Fonction de l'adhérent :</label>
                <select name="fonction" id="fonction">
                     <option value="dirigeant">Dirigeant</option>
                     <option value="bureau">Bureau</option>
                     <option value="arbitre">Arbitre</option>
                     <option value="entraineur">Entraineur</option>
                     <option value="joueur" selected="selected">Joueur</option>
                </select>
          		</div>

              <div id="input_mutation" class="form-group">
                <label for="mutation">Mutation (Oui/Non) :</label>
                <select name="mutation" id="mutation">
                     <option value="1">Oui</option>
                     <option value="0" selected="selected">Non</option>
                </select>
          		</div>

              <div id="input_moyen_paiement1" class="form-group">
                <label for="moyen_paiement1">Moyen de paiement 1 :</label>
                <select name="moyen_paiement1" id="moyen_paiement1">
                     <option value="aucun" selected="selected">Aucun</option>
                     <option value="liquide">Liquide</option>
                     <option value="cheque">Chèque</option>
                     <option value="bon_caf">Bon CAF</option>
                     <option value="cheque_vacance">Chèque vacance</option>
                     <option value="coupon_sport">Coupon Sport</option>
                </select>
          		</div>

              <div id="input_montant_paiement1" class="form-group">
                <label for="montant_paiement1">Montant du paiement 1 de l'adhérent :</label>
                <input type="number" id="montant_paiement1" name="montant_paiement1" class="champ" value="">
          		</div>

              <div id="input_moyen_paiement2" class="form-group">
                <label for="moyen_paiement2">Moyen de paiement 2 :</label>
                <select name="moyen_paiement2" id="moyen_paiement2">
                     <option value="aucun" selected="selected">Aucun</option>
                     <option value="liquide">Liquide</option>
                     <option value="cheque">Chèque</option>
                     <option value="bon_caf">Bon CAF</option>
                     <option value="cheque_vacance">Chèque vacance</option>
                     <option value="coupon_sport">Coupon Sport</option>
                </select>
          		</div>

              <div id="input_montant_paiement2" class="form-group">
                <label for="montant_paiement2">Montant du paiement 2 de l'adhérent :</label>
                <input type="number" id="montant_paiement2" name="montant_paiement2" class="champ" value="">
          		</div>

              <div id="input_moyen_paiement3" class="form-group">
                <label for="moyen_paiement3">Moyen de paiement 3 :</label>
                <select name="moyen_paiement3" id="moyen_paiement3">
                     <option value="aucun" selected="selected">Aucun</option>
                     <option value="liquide">Liquide</option>
                     <option value="cheque">Chèque</option>
                     <option value="bon_caf">Bon CAF</option>
                     <option value="cheque_vacance">Chèque vacance</option>
                     <option value="coupon_sport">Coupon Sport</option>
                </select>
          		</div>

              <div id="input_montant_paiement3" class="form-group">
                <label for="montant_paiement3">Montant du paiement 3 de l'adhérent :</label>
                <input type="number" id="montant_paiement3" name="montant_paiement3" class="champ" value="">
          		</div>

              <div id="input_moyen_paiement4" class="form-group">
                <label for="moyen_paiement4">Moyen de paiement 4 :</label>
                <select name="moyen_paiement4" id="moyen_paiement4">
                     <option value="aucun" selected="selected">Aucun</option>
                     <option value="liquide">Liquide</option>
                     <option value="cheque">Chèque</option>
                     <option value="bon_caf">Bon CAF</option>
                     <option value="cheque_vacance">Chèque vacance</option>
                     <option value="coupon_sport">Coupon Sport</option>
                </select>
          		</div>

              <div id="input_montant_paiement4" class="form-group">
                <label for="montant_paiement4">Montant du paiement 4 de l'adhérent :</label>
                <input type="number" id="montant_paiement4" name="montant_paiement4" class="champ" value="">
          		</div>

              <div id="input_moyen_paiement5" class="form-group">
                <label for="moyen_paiement5">Moyen de paiement 5 :</label>
                <select name="moyen_paiement5" id="moyen_paiement5">
                     <option value="aucun" selected="selected">Aucun</option>
                     <option value="liquide">Liquide</option>
                     <option value="cheque">Chèque</option>
                     <option value="bon_caf">Bon CAF</option>
                     <option value="cheque_vacance">Chèque vacance</option>
                     <option value="coupon_sport">Coupon Sport</option>
                </select>
          		</div>

              <div id="input_montant_paiement5" class="form-group">
                <label for="montant_paiement5">Montant du paiement 5 de l'adhérent :</label>
                <input type="number" id="montant_paiement5" name="montant_paiement5" class="champ" value="">
          		</div>

              <div id="input_cheque_caution_numero" class="form-group">
                <label for="cheque_caution_numero">Numéro du chèque de caution de l'adhérent :</label>
                <input type="text" id="cheque_caution_numero" name="cheque_caution_numero" class="champ" value="">
          		</div>

              <div id="input_doc_manquant" class="form-group">
                <label>Document Maquant :</label><br>
                <div class="">
                  <input type="checkbox" id="tous" name="tous" class="champ" value="tous">
                  <label for="tous">Tous</label>
                </div>
                <div class="">
                  <input type="checkbox" id="photo" name="photo" class="champ" value="photo">
                  <label for="photo">Photo</label>
                </div>
                <div class="">
                  <input type="checkbox" id="autorisation_parentale" name="autorisation_parentale" class="champ" value="autorisation_parentale">
                  <label for="autorisation_parentale">Autorisation Parentale</label>
                </div>
                <div class="">
                  <input type="checkbox" id="certificat_medicale" name="certificat_medicale" class="champ" value="certificat_medicale">
                  <label for="certificat_medicale">Certificat Médicale</label>
                </div>
                <div class="">
                  <input type="checkbox" id="questionnaire_sante" name="questionnaire_sante" class="champ" value="questionnaire_sante">
                  <label for="questionnaire_sante">Questionnaire de santé</label>
                </div>
                <div class="">
                  <input type="checkbox" id="piece_identite" name="piece_identite" class="champ" value="piece_identite">
                  <label for="piece_identite">Pièce d'identitée</label>
                </div>

          		</div>

              <div id="input_date_qualification" class="form-group">
                <label for="date_qualification">Date de qualification de l'adhérent :</label>
                <input type="date" id="date_qualification" name="date_qualification" class="champ" value="">
          		</div>

              <div id="input_fiche_inscription" class="form-group">
                <label for="fiche_inscription">Fiche d'inscription (Oui/Non) :</label>
                <select name="fiche_inscription" id="fiche_inscription">
                     <option value="1">Oui</option>
                     <option value="0">Non</option>
                </select>
          		</div>

              <div id="input_charte_bonne_conduite" class="form-group">
                <label for="charte_bonne_conduite">Charte de Bonne conduite (Oui/Non) :</label>
                <select name="charte_bonne_conduite" id="charte_bonne_conduite">
                     <option value="1">Oui</option>
                     <option value="0">Non</option>
                </select>
          		</div>

              <div id="input_commentaire" class="form-group">
                <label for="commentaire">Commentaire :</label>
                <textarea name="commentaire" rows="8" cols="60"></textarea>
          		</div>

              <div id="input_numero_teeshirt" class="form-group" style="margin-top:110px;">
                <label for="numero_teeshirt">Numéro du tee-shirt :</label>
                <input type="text" id="numero_teeshirt" name="numero_teeshirt" class="champ" value="" placeholder="00">
          		</div>

              <div id="input_taille_teeshirt" class="form-group">
                <label for="taille_teeshirt">Taille du tee-shirt :</label>
                <select name="taille_teeshirt" id="taille_teeshirt">
                     <option value="">Aucun</option>
                     <option value="116/128">116/128</option>
                     <option value="140/152">140/152</option>
                     <option value="164/176">164/176</option>
                     <option value="S">S</option>
                     <option value="M">M</option>
                     <option value="L">L</option>
                     <option value="XL">XL</option>
                     <option value="XXL">XXL</option>
                </select>
          		</div>

              <div id="input_status_teeshirt" class="form-group">
                <label for="status_teeshirt">Status du tee-shirt :</label>
                <select name="status_teeshirt" id="status_teeshirt">
                     <option value="vide">Vide</option>
                     <option value="commande">En commande</option>
                     <option value="stock">En Stock</option>
                     <option value="affecte">Affecté</option>
                </select>
          		</div>



              <div id="input_taille_chaussette" class="form-group">
                <label for="taille_chaussette">Taille des chaussette :</label>
                <select name="taille_chaussette" id="taille_chaussette">
                     <option value="">Aucune</option>
                     <option value="33/35">33/35</option>
                     <option value="36/38">36/38</option>
                     <option value="39/42">39/42</option>
                     <option value="43/45">43/45</option>
                     <option value="46/48">46/48</option>
                </select>
              </div>

              <div id="input_status_chaussette" class="form-group">
                <label for="status_chaussette">Status des chaussette :</label>
                <select name="status_chaussette" id="status_chaussette">
                     <option value="vide">Vide</option>
                     <option value="commande">En commande</option>
                     <option value="stock">En Stock</option>
                     <option value="affecte">Affecté</option>
                </select>
              </div>


              <div id="input_taille_ballon" class="form-group">
                <label for="taille_ballon">Taille du ballon :</label>
                <select name="taille_ballon" id="taille_ballon">
                     <option value="" selected="selected" >Aucun</option>
                     <option value="T0">T0</option>
                     <option value="T1">T1</option>
                     <option value="T2">T2</option>
                     <option value="T3">T3</option>
                </select>
              </div>

              <div id="input_status_ballon" class="form-group">
                <label for="status_ballon">Status du ballon :</label>
                <select name="status_ballon" id="status_ballon">
                     <option value="vide">Vide</option>
                     <option value="commande">En commande</option>
                     <option value="stock">En Stock</option>
                     <option value="affecte">Affecté</option>
                </select>
              </div>


              <div id="input_taille_chasuble" class="form-group">
                <label for="taille_chasuble">Taille du chasuble :</label>
                <select name="taille_chasuble" id="taille_chasuble">
                     <option value="" selected="selected" >Aucun</option>
                     <option value="116/128">116/128</option>
                     <option value="140/152">140/152</option>
                     <option value="164/176">164/176</option>
                     <option value="S">S</option>
                     <option value="M">M</option>
                     <option value="L">L</option>
                     <option value="XL">XL</option>
                     <option value="XXL">XXL</option>
                </select>
          		</div>

              <div id="input_status_chasuble" class="form-group">
                <label for="status_chasuble">Status du chasuble :</label>
                <select name="status_chasuble" id="status_chasuble">
                     <option value="vide">Vide</option>
                     <option value="commande">En commande</option>
                     <option value="stock">En Stock</option>
                     <option value="affecte">Affecté</option>
                </select>
          		</div>

              <div class=" col-lg-4 col-lg-offset-4 bouton">
                <input type="submit" name="ajout" value="Ajouter" class="btn btn-success">
              </div>
            </form>
        </div>
    </div>
</div>
