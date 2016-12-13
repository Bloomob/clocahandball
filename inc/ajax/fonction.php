<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	include_once('../constantes.php');
?>
<div class="">
	<div>
		<fieldset>
			<legend>Type :</legend>
			<div>
				<select id="fonction_type"><?php
					$liste_organigramme_types = liste_organigramme_types();
					foreach($liste_organigramme_types as $key => $unType) {?>
						<option value="<?=$unType?>"><?=$unType?></option><?php
					}?>
				</select>
			</div>
		</fieldset>
	</div>
	<div>
		<fieldset>
			<legend>Cat&eacute;gorie :</legend>
			<div>
				<select id="fonction_categorie"><?php
					$liste_categorie = liste_categorie();
					foreach($liste_categorie as $uneCategorie) {?>
						<option value="<?=$uneCategorie['id'];?>"><?=$uneCategorie['cat'];?></option><?php
					}?>
				</select>
			</div>
		</fieldset>
	</div>
	<div>
		<fieldset>
			<legend>Nom / Prénom</legend>
			<div>
				<input type="text" id="fonction_nom_prenom">
				<input type="hidden" id="fonction_id_nom_prenom" value="0">
			</div>
		</fieldset>
	</div>
	<div>
		<fieldset id="fonction_active">
			<legend>Fonction active ?</legend>
			Oui <input type="radio" name="fonction_active" value="1"> | Non <input type="radio" name="fonction_active" checked value="0">
		</fieldset>
	</div>
</div>
<script>
	$(function() {
		$( "#fonction_nom_prenom" ).autocomplete({
			source: "inc/ajax/liste_entraineurs.autocomplete.php",
			minLength: 2,
			select: function( event, ui ) {
				(ui.item ? $('#fonction_id_nom_prenom').val(ui.item.id) : $('#fonction_id_nom_prenom').val(0));
			}
		});
    });
</script>