<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	if(isset($_POST['raccourci']))
		$cat = $_POST['raccourci'];
	if(isset($_POST['j']))
		$j = $_POST['j'];
	else
		$j = 0;
		
	$unJoueur = retourneJoueurById($j);
	if(!is_array($unJoueur)) {
		$unJoueur = array();
	}
?>
<div class='popin add_joueur'>
	<div class="colone1">
		Cat&eacute;gorie
	</div>
	<div class="colone2"><?php
		if($cat) {
			$uneCategorie = liste_categorie($cat); ?>
			<span><?=$uneCategorie[0]['cat']?></span>
			<input type="hidden" id="joueur_categorie" value="<?=$uneCategorie[0]['id']?>"><?php
		}
		else {?>
			<select id="joueur_categorie"><?php
				$liste_categorie = liste_categorie();
				foreach($liste_categorie as $uneCategorie) {?>
					<option value="<?=$uneCategorie['id']?>"><?=$uneCategorie['cat']?></option><?php
				}?>
			</select>
			<?php
		} ?>
	</div>
	<div class="colone1">
		Nouveau joueur
	</div>
	<div class="colone2 nv_joueur">
		Est-ce un nouveau joueur ?</br>
		<label for="oui_nv_j">Oui</label> <input type="radio" id="oui_nv_j" name="nv_j" value="oui"/> | 
		<label for="non_nv_j">Non</label> <input type="radio" id="non_nv_j" name="nv_j" value="non"/>
	</div>
	<div class="infos_joueur" style="display: none;">
		<div class="colone1">
			Pr&eacute;nom / Nom
		</div>
		<div class="colone2 nom_prenom non">
			<input type="text" id="prenom_nom" value="Entrez son nom ou son prenom"/>
			<input type="hidden" id="id_prenom_nom" value="0"/>
		</div>
		<div class="colone2 nom_prenom oui">
			<input type="text" id="joueur_prenom" value="Entrez son prenom"/><br/><br/>
			<input type="text" id="joueur_nom" value="Entrez son nom"/>
		</div>
		<div class="colone1">
			Num&eacute;ro
		</div>
		<div class="colone2">
			<select id='joueur_numero'>
				<option value='0'>Selectionnez un numero</option><?php
				for ($i=1; $i<100; $i++) {?>
					<option value='<?=$i;?>' <?//=($uneActualite['image']==$uneImage['nom'])?"selected='selected'":'';?>><?=$i;?></option><?php
				}?>
			</select>
		</div>
		<div class="colone1">
			Poste
		</div>
		<div class="colone2">
			<select id='joueur_poste'>
				<option value='0'>Selectionnez un poste</option>
				<option value='1'>Gardien</option>
				<option value='2'>Demi-centre</option>
				<option value='3'>Arri&egrave;re Gauche</option>
				<option value='4'>Arri&egrave;re Droit</option>
				<option value='5'>Ailier Gauche</option>
				<option value='6'>Ailier Droit</option>
				<option value='7'>Pivot</option>
			</select>
		</div>
	</div>
</div>
<script>
	$(function() {
	
		$( ".nv_joueur input:radio" ).change( function() {
			$('.infos_joueur').show();
			$( ".nom_prenom" ).hide();
			if($(this).val() == 'oui')
				$('.nom_prenom.oui').show();
			else
				$('.nom_prenom.non').show();
		});
	
		$( ".nom_prenom input:text" ).focus( function() {
			if($(this).val() == "Entrez son nom" || $(this).val() == "Entrez son prenom" || $(this).val() == "Entrez son nom ou son prenom") {
				$(this).val('');
				$(this).css('color', '#000');
			}
		});
		
		$( "#prenom_nom" ).autocomplete({
			source: "inc/ajax/liste_joueurs.autocomplete.php",
			minLength: 2,
			select: function( event, ui ) {
				(ui.item ? $('#id_prenom_nom').val(ui.item.id) : $('#id_prenom_nom').val(0));
			}
		});
		
		
    });
</script>