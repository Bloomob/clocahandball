<?php
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD & les constantes
	include_once("../connexion_bdd_pdo.php");
	include_once("../constantes.php");

	$id = (isset($_POST['id'])) ? $_POST['id'] : 0;

	$ActuManager = new ActualiteManager($connexion);
	$options = array('where' => 'id = '. $id);
	$uneActu = $ActuManager->retourne($options);
?>
<div class='popin'>
	<form>
		<div class="colone1">
			<label for="titre">Titre :</label>
		</div>
		<div class="colone2">
			<input type="text" id="titre" class="champ" value="<?=htmlspecialchars_decode($uneActu->getTitre());?>">
		</div>
		<div class="colone1">
			<label for="sous_titre">Sous-titre :</label>
		</div>
		<div class="colone2">
			<input type="text" id="sous_titre" class="champ" value="<?=htmlspecialchars_decode($uneActu->getSous_titre());?>">
		</div>
		<div class="colone1">
			<label for="contenu">Contenu :</label>
		</div>
		<div class="colone2">
			<textarea id="contenu" name="contenu" class="champ tinymce"><?=htmlspecialchars_decode($uneActu->getContenu());?></textarea>
		</div>
		<div class="colone1">
			<label for="theme">Theme :</label>
		</div>
		<div class="colone2">
			<select id="theme"><?php
				foreach($tabTheme as $cle => $unTheme) { ?>
					<option value="<?=$cle;?>" <?=($uneActu->getTheme()==$cle)?"selected='selected'":'';?>><?=$unTheme;?></option><?php
				}?>
			</select>
		</div>
		<div class="colone1">
			<label for="add_tag">Tags :</label>
		</div>
		<div class="colone2">
			<input type="hidden" id="tags" class="champ" value="<?=htmlspecialchars_decode($uneActu->getTags());?>">
			<div class="tags">
				<?php
					$strTags = htmlspecialchars_decode($uneActu->getTags());
					if(!empty($strTags)) {
						$listeTags = explode( ',', htmlspecialchars_decode($uneActu->getTags()));
						foreach ($listeTags as $key => $value) {?>
							<span class="tag"><span><?=$value;?></span><a href="#" title="Retirer le tag">x</a></span><?php
						}
					}
				?>
				<input type="text" id="add_tag" value="Ajouter" data-defaut="Ajouter" />
			</div>
		</div>
		<div class="colone1">
			<label for="image">Image</label>
		</div>
		<div class="colone2">
			<select id="image">
				<option value=0>Pas d'image</option><?php /*
				$liste_image = liste_image();
				if(is_array($liste_image)) {
					foreach($liste_image as $uneImage) {?>
						<option value="<?=$uneImage['nom'];?>" <?=($uneActu->getImage()==$uneImage['nom'])?"selected='selected'":'';?>><?=$uneImage['nom'];?></option><?php
					}
				}*/?>
			</select>
		</div>
		<div class="colone1">
			<label for="slider">Mettre sur le slider ?</label>
		</div>
		<div class="colone2">
			<input type="checkbox" id="slider" <?=($uneActu->getSlider())?"checked":'';?>/>
		</div>
		<div class="colone1">
			<label for="slider">Niveau d'importance ?</label>
		</div>
		<div class="colone2">
			<select id="importance">
				<option value="3" <?=($uneActu->getImportance()==3)?"selected='selected'":'';?>>Basse</option>
				<option value="2" <?=($uneActu->getImportance()==2)?"selected='selected'":'';?>>Moyenne</option>
				<option value="1" <?=($uneActu->getImportance()==1)?"selected='selected'":'';?>>Haute</option>
			</select>
		</div>
		<div class="colone1">
			<label for="publie">Publier ?</label>
		</div>
		<div class="colone2">
			<input type="checkbox" id="publie" <?=($uneActu->getPublie())?"checked":'';?>/>
		</div>
	</form>
	<script type="text/javascript">
	$(document).ready(function() {
		tinyMCE.init({
			selector: ".tinymce",
	        mode: "none",
			plugins: [
		        "advlist autolink lists link image charmap print preview anchor",
		        "searchreplace visualblocks code fullscreen",
		        "insertdatetime media table contextmenu paste"
		    ],
		    toolbar: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | link image"
	    });

		$(".popin .colone2 .tags").click( function() {
	    	$("#add_tag").focus().val('');
	    });

	    $("#add_tag").keyup(function(e) {
	    	if(e.keyCode == 13 || e.keyCode == 188) {
	    		add();
	    		$("#add_tag").val('');
	    	}
	    });

	    $("#add_tag").blur(function(e) {
	    	if($("#add_tag").data('defaut') != $("#add_tag").val()) {
	    		add();
	    		$("#add_tag").val($("#add_tag").data('defaut')).blur();
	    	}
	    });

	    $(".popin .colone2 .tags > .tag > a").click( function( event ) {
	    	remove(event);
	    	return false;
	    });

	    function add() {
	    	var tag = $("#add_tag").val();
	    	if(tag != '' && !existe(tag)) {
	    		$("#add_tag").before('<span class="tag"><span>'+ tag +'</span><a href="#" title="Retirer le tag">x</a></span>');
	    		var tagsListe = $("#tags").val();
	    		if(tagsListe != '')
	    			$("#tags").val(tagsListe+','+tag);
	    		else
	    			$("#tags").val(tag);
	    	}
	    	$(".popin .colone2 .tags > .tag > a").on('click', function( event ) {
	    		remove(event);
	    		return false;
	    	});
	    }

	    function remove(event) {
	    	var str = '';
	    	var listeTags = $('#tags').val().split(',');
    		for(var i = 0; i < listeTags.length; i++){
    			if(listeTags[i] != $(event.target).parent().find('span').text() && listeTags[i] != '') {
    				if(str == '')
						str += listeTags[i];
    				else
    					str += ','+ listeTags[i];
    			}
    		}
    		$("#tags").val(str);
	    	$(event.target).parent().remove();
	    }

	    function existe(value){
	    	var listeTags = $('#tags').val().split(',');
    		for(var i = 0; i < listeTags.length; i++){
    			if(listeTags[i] == value) {
    				return true;
    			}
    		}
    		return false;
	    }
	    
	});
</script>
</div>