<?php include_once('dev/ajout_tenue.traitement.php'); ?>
<div class="wrapper tenues">
    <div class="row text-center">
        <div class="col-md-12">
            <h3 id="title_tenue_ajout">Tenue Ajout</h3>
        </div>
    </div>
    <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <form class="form_ajout_tenue" action="ajout_tenue.php" method="post">
              <?php
              if ( !empty($aError) ) {

                ?>
              <div class="erreurs">
                <?php
                  foreach( $aError as $iError ) {
                    ?> <div class="logerreur"><?php echo $iError; ?> </div> <?php
                  }
                ?>
              </div>
              <?php } ?>
              <div id="input_numero_tenue">
                <label for="numero_tenue">Numéro de la tenue :</label>
          			<input type="text" id="numero_tenue" name="numero_tenue" class="champ" value="">
          		</div>

              <div id="input_taille_tenue">
                <label for="taille_tenue">Taille de la tenue :</label>
                <select name="taille_tenue" id="taille_tenue">
                     <option value="XXS">XXS</option>
                     <option value="XS">XS</option>
                     <option value="S">S</option>
                     <option value="M">M</option>
                     <option value="L">L</option>
                     <option value="XL">XL</option>
                     <option value="XXL">XXL</option>
                     <option value="XXXL">XXXL</option>
                </select>
          		</div>
              <div id="input_sexe_tenue">
                <label for="sexe_tenue">Sexe de la tenue :</label>
                <select name="sexe_tenue" id="sexe_tenue">
                     <option value="M">M</option>
                     <option value="F">F</option>
                </select>
          		</div>

              <div id="input_poste_tenue">
                <label for="poste_tenue">Poste de la tenue :</label>
                <select name="poste_tenue" id="poste_tenue">
                     <option value="gardien">Gardien</option>
                     <option value="joueur" selected="selected">Joueur</option>
                </select>
              </div>

              <div id="input_status_tenue">
                <label for="status_tenue">Status de la tenue :</label>
                <select name="status_tenue" id="status_tenue">
                     <option value="commande">En commande</option>
                     <option value="stock" selected="selected">En stock</option>
                     <option value="affecte">Affecté</option>
                </select>
              </div>

              <div id="input_type_tenue">
                <label for="type_tenue">Type de la tenue :</label>
                <select name="type_tenue" id="type_tenue">
                     <option value="acheres" selected="selected" >Achères</option>
                     <option value="cap78">CAP78</option>
                     <option value="elite78">Elite78</option>
                     <option value="team2rives">Team2Rives</option>
                </select>
              </div>

              <div id="input_joueur_tenue">
                <label for="joueur_tenue">Tenue du joueur :</label>
                <select name="joueur_tenue" id="joueur_tenue">
                     <option value="" selected="selected" >Aucun</option>
                    <?php foreach ($aAdherents as $key => $value){  ?>
                      <option value="<?php echo $value['HR_ADHERENT_ID']; ?>"><?php echo $value['HR_ADHERENT_NOM'] . ' ' . $value['HR_ADHERENT_PRENOM']  ; ?></option>
                      <?php } ?>
                </select>
              </div>
              <div class=" col-lg-4 col-lg-offset-4 bouton">
                <input type="submit" name="ajout" value="Ajouter">
              </div>
            </form>
        </div>
    </div>
</div>