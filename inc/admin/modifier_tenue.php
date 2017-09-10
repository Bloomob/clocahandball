<?php include_once('dev/modifier_tenue.traitement.php'); ?>
<div class="wrapper tenues">
    <div class="row text-center">
      <div class="col-md-12">
        <h3 id="title_tenue_ajout">Modifier Tenue</h3>
      </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form class="form_ajout_tenue" action="admin.php?page=modifier_tenue&amp;id=<?php echo $_GET['id']; ?>" method="post">
              <div id="input_numero_tenue">
                <label for="numero_tenue">Numéro de la tenue :</label>
          			<input type="text" id="numero_tenue" name="numero_tenue" class="champ" value="<?php echo $aTenue[0]['HR_TENUE_NUMERO']; ?>" readonly="readonly">
          		</div>

              <div id="input_taille_tenue">
                <label for="taille_tenue">Taille de la tenue :</label>
                <select name="taille_tenue" id="taille_tenue">
                     <option <?php if($aTenue[0]['HR_TENUE_TAILLE'] == 'XXS'){ ?>selected="selected" <?php } ?> value="XXS">XXS</option>
                     <option <?php if($aTenue[0]['HR_TENUE_TAILLE'] == 'XS'){ ?> selected="selected" <?php } ?> value="XS">XS</option>
                     <option <?php if($aTenue[0]['HR_TENUE_TAILLE'] == 'S'){ ?> selected="selected" <?php } ?> value="S">S</option>
                     <option <?php if($aTenue[0]['HR_TENUE_TAILLE'] == 'M'){ ?> selected="selected" <?php } ?> value="M">M</option>
                     <option <?php if($aTenue[0]['HR_TENUE_TAILLE'] == 'L'){ ?> selected="selected" <?php } ?> value="L">L</option>
                     <option <?php if($aTenue[0]['HR_TENUE_TAILLE'] == 'XL'){ ?> selected="selected" <?php } ?> value="XL">XL</option>
                     <option <?php if($aTenue[0]['HR_TENUE_TAILLE'] == 'XXL'){ ?> selected="selected" <?php } ?> value="XXL">XXL</option>
                     <option <?php if($aTenue[0]['HR_TENUE_TAILLE'] == 'XXXL'){ ?> selected="selected" <?php } ?> value="XXXL">XXXL</option>
                </select>
          		</div>
              <div id="input_sexe_tenue">
                <label for="sexe_tenue">Sexe de la tenue :</label>
                <select name="sexe_tenue" id="sexe_tenue">
                     <option <?php if($aTenue[0]['HR_TENUE_SEXE'] == 'M'){ ?> selected="selected" <?php } ?> value="M">M</option>
                     <option <?php if($aTenue[0]['HR_TENUE_SEXE'] == 'F'){ ?> selected="selected" <?php } ?> value="F">F</option>
                </select>
          		</div>

              <div id="input_poste_tenue">
                <label for="poste_tenue">Status de la tenue :</label>
                <select name="poste_tenue" id="poste_tenue">
                     <option <?php if($aTenue[0]['HR_TENUE_POSTE'] == 'gardien'){ ?> selected="selected" <?php } ?> value="gardien">Gardien</option>
                     <option <?php if($aTenue[0]['HR_TENUE_POSTE'] == 'joueur'){ ?> selected="selected" <?php } ?> value="joueur">Joueur</option>
                </select>
              </div>

              <div id="input_status_tenue">
                <label for="status_tenue">Status de la tenue :</label>
                <select name="status_tenue" id="status_tenue">
                     <option <?php if($aTenue[0]['HR_TENUE_STATUS'] == 'commande'){ ?> selected="selected" <?php } ?> value="commande">En commande</option>
                     <option <?php if($aTenue[0]['HR_TENUE_STATUS'] == 'stock'){ ?> selected="selected" <?php } ?> value="stock">En stock</option>
                     <option <?php if($aTenue[0]['HR_TENUE_STATUS'] == 'affecte'){ ?> selected="selected" <?php } ?> value="affecte">Affecté</option>
                </select>
              </div>

              <div id="input_type_tenue">
                <label for="type_tenue">Type de la tenue :</label>
                <select name="type_tenue" id="type_tenue">
                     <option <?php if($aTenue[0]['HR_TENUE_TYPE'] == 'acheres'){ ?> selected="selected" <?php } ?> value="acheres">Achères</option>
                     <option <?php if($aTenue[0]['HR_TENUE_TYPE'] == 'cap78'){ ?> selected="selected" <?php } ?> value="cap78">CAP78</option>
                     <option <?php if($aTenue[0]['HR_TENUE_TYPE'] == 'elite78'){ ?> selected="selected" <?php } ?> value="elite78">Elite78</option>
                     <option <?php if($aTenue[0]['HR_TENUE_TYPE'] == 'team2rives'){ ?> selected="selected" <?php } ?> value="team2rives">Team2Rives</option>
                </select>
              </div>
              <div class=" col-lg-4 col-lg-offset-4 bouton">
                <input type="submit" name="modifier" value="Modifier">
              </div>
            </form>
        </div>
    </div>
</div>
