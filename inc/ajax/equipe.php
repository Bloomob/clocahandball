<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	include_once('../constantes.php');
	
	if(isset($_POST['id']))
		$id = $_POST['id'];
	else
		$id = 0;
	
	$uneEquipe = retourneEquipeById($id);
	// debug($uneEquipe);
	if(!is_array($uneEquipe)) {
		$uneEquipe = array('categorie' => '', 'championnat' => '', 'niveau' => '', 'entraineur1' => '', 'entraineur2' => '', 'actif' => '');
	}
?>
<div class="">
	<div>
		<fieldset>
			<legend>Cat&eacute;gorie :</legend>
			<div><?php
				if($uneEquipe['categorie']!='') {
					$uneCategorie = retourneCategorieById($uneEquipe['categorie']); ?>
					<span><?=$uneCategorie?></span>
					<input type="hidden" id="team_categorie" value="<?=$uneEquipe['categorie']?>"><?php
				}
				else {?>
					<select id="team_categorie"><?php
						$liste_categorie = liste_categorie();
						foreach($liste_categorie as $uneCategorie) {?>
							<option value="<?=$uneCategorie['id'];?>" <?=($uneCategorie['id']==$uneEquipe['categorie'])?'selected="selected"':'';?>><?=$uneCategorie['cat'];?></option><?php
						}?>
					</select><?php
				}?>
			</div>
		</fieldset>
	</div>
	<div>
		<fieldset>
			<legend>Championnat :</legend>
			<div>
				<select id="team_niveau" name="team_niveau">
					<option value="0">-</option><?php
					$liste_niveau = liste_niveau();
					foreach($liste_niveau as $key => $unNiveau) {?>
						<option value="<?=$key;?>" <?=($key==$uneEquipe['niveau'])?'selected="selected"':'';?>><?=$unNiveau;?></option><?php
					}?>
				</select>
				<select id="team_championnat" name="team_championnat">
					<option value="0">-</option><?php
					$liste_championnat = liste_championnat();
					foreach($liste_championnat as $key => $unChampionnat) {?>
						<option value="<?=$key;?>" <?=($key==$uneEquipe['championnat'])?'selected="selected"':'';?>><?=$unChampionnat;?></option><?php
					}?>
				</select>
			</div>
		</fieldset>
	</div>
	<div>
		<fieldset>
			<legend>Entraineur(s)</legend>
			<div>
				<?php $entraineur1 = retourneEntraineurById($uneEquipe['entraineur1']);?>
				<input type="text" id="team_entraineur1" value="<?=$entraineur1['prenom'].' '.$entraineur1['nom'];?>">
				<input type="hidden" id="team_id_entraineur1" value="<?=$uneEquipe['entraineur1'];?>">
				<?php $entraineur2 = retourneEntraineurById($uneEquipe['entraineur2']);?>
				<input type="text" id="team_entraineur2" value="<?=$entraineur2['prenom'].' '.$entraineur2['nom'];?>">
				<input type="hidden" id="team_id_entraineur2" value="<?=$uneEquipe['entraineur2'];?>">
			</div>
		</fieldset>
	</div>
	<div>
		<fieldset id="team_active">
			<legend>Equipe active ?</legend>
			Oui <input type="radio" name="team_active" value="1" <?=($uneEquipe['actif'])?"checked":'';?>> | Non <input type="radio" name="team_active" <?=(!$uneEquipe['actif'])?"checked":'';?> value="0">
		</fieldset>
	</div>
</div>
<script>
	$(function() {
		$( "#team_entraineur1" ).autocomplete({
			source: "inc/ajax/liste_entraineurs.autocomplete.php",
			minLength: 2,
			select: function( event, ui ) {
				(ui.item ? $('#team_id_entraineur1').val(ui.item.id) : $('#team_id_entraineur1').val(0));
			}
		});
		$( "#team_entraineur2" ).autocomplete({
			source: "inc/ajax/liste_entraineurs.autocomplete.php",
			minLength: 2,
			select: function( event, ui ) {
				(ui.item ? $('#team_id_entraineur2').val(ui.item.id) : $('#team_id_entraineur2').val(0));
			}
		});
    });
</script>