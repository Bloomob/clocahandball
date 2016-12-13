<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	$id = 0;
	if(isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	
	$unDossier = retourneDossierById($id);
	if(!is_array($unDossier)) {
		$unDossier = array('titre' => 'Tapez un titre', 'sous_titre' => 'Tapez un sous-titre', 'contenu' => 'Tapez votre contenu', 'theme' => '', 'image' => '', 'publie' => '');
	}
?>
<div class='popin add_dossier'>
	<form id='form_add_dossier'>
		<div class="colone1">
			<label for="dossiers_titre">Titre :</label>
		</div>
		<div class="colone2">
			<input type="text" id="dossiers_titre" class="champ" value="<?=htmlspecialchars_decode($unDossier['titre']);?>">
		</div>
		<div class="colone1">
			<label for="dossiers_sous_titre">Sous-titre :</label>
		</div>
		<div class="colone2">
			<input type="text" id="dossiers_sous_titre" class="champ" value="<?=htmlspecialchars_decode($unDossier['sous_titre']);?>">
		</div>
		<div class="colone1">
			<label for="dossiers_contenu">Contenu :</label>
		</div>
		<div class="colone2">
			<textarea id="dossiers_contenu" class="champ tinymce"><?=htmlspecialchars_decode($unDossier['contenu']);?></textarea>
		</div>
		<div class="colone1">
			<label for="dossiers_theme">Theme :</label>
		</div>
		<div class="colone2">
			<input type="text" id="dossiers_theme" class="champ" value="<?=htmlspecialchars_decode($unDossier['theme']);?>">
		</div>
		<div class="colone1">
			<label for="dossiers_image">Image</label>
		</div>
		<div class="colone2">
			<select id="dossiers_image">
				<option value="">-</option><?php
				$liste_image = liste_image();
				if(is_array($liste_image)) {
					foreach($liste_image as $uneImage) {?>
						<option value="<?=$uneImage['nom'];?>" <?=($unDossier['image']==$uneImage['nom'])?"selected='selected'":'';?>><?=$uneImage['nom'];?></option><?php
					}
				}?>
			</select>
		</div>
		<div class="colone1">
			<label for="dossiers_publie">Publie :</label>
		</div>
		<div class="colone2">
			<input type="checkbox" id="dossiers_publie"  <?=($unDossier['publie'])?"checked":'';?>/>
			<input type="hidden" id="dossiers_id"  value="<?=$unDossier['id']?>"/>
		</div>
	</form>
</div>
<script type="text/javascript">
	tinyMCE.init({
        selector: "textarea",
		theme: "modern",
		plugins: [
	        "advlist autolink lists link image charmap print preview anchor",
	        "searchreplace visualblocks code fullscreen",
	        "insertdatetime media table contextmenu paste"
	    ],
	    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
	$('.champ').focus( function () {
		if($(this).val() == 'Tapez un titre' ||  $(this).val() == 'Tapez un sous-titre' ||  $(this).val() == 'Tapez votre contenu') {
			$(this).val('');
			$(this).css('color', 'black');
		}
	});
	$('#titre').blur( function () {
		if($(this).val() == '') {
			$(this).val('Tapez un titre');
			$(this).css('color', 'grey');
		}
	});
	$('#sous-titre').blur( function () {
		if($(this).val() == '') {
			$(this).val('Tapez un sous-titre');
			$(this).css('color', 'grey');
		}
	});
	$('#contenu').blur( function () {
		if($(this).val() == '') {
			$(this).val('Tapez votre contenu');
			$(this).css('color', 'grey');
		}
	});
</script>