<?php
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../inc/connexion_bdd_pdo.php");

	$id = (isset($_POST['id'])) ? $_POST['id'] : 0;

	$ClubManager = new ClubManager($connexion);
	$unClub = $ClubManager->retourne($id);

?>
<div class='popin'>
	<form>
		<div class="colone1">
			<label for="nom">Nom :</label>
		</div>
		<div class="colone2">
			<input type="text" id="nom" class="champ" value="<?=htmlspecialchars_decode($unClub->getNom());?>">
		</div>
		<div class="colone1">
			<label for="raccourci">Raccourci :</label>
		</div>
		<div class="colone2">
			<input type="text" id="raccourci" class="champ" value="<?=htmlspecialchars_decode($unClub->getRaccourci());?>">
		</div>
		<div class="colone1">
			<label for="numero">Numéro :</label>
		</div>
		<div class="colone2">
			<select id="numero">
				<option value="">-</option><?php
				for($i=1; $i<10; $i++) {?>
					<option value="<?=$i;?>" <?=($unClub->getNumero()==$i)?"selected='selected'":'';?>><?=$i;?></option><?php
				}?>
			</select>
		</div>
		<div class="colone1">
			<label for="ville">Ville :</label>
		</div>
		<div class="colone2">
			<input type="text" id="ville" class="champ" value="<?=htmlspecialchars_decode($unClub->getVille());?>">
		</div>
		<div class="colone1">
			<label for="code_postal">Code postal :</label>
		</div>
		<div class="colone2">
			<input type="text" id="code_postal" class="champ" value="<?=htmlspecialchars_decode($unClub->getCode_postal());?>">
		</div>
		<div class="colone1">
			<label for="actif">Actif ?</label>
		</div>
		<div class="colone2">
			<input type="checkbox" id="actif" <?=($unClub->getActif())?"checked":'';?>/>
		</div>
	</form>
	<script type="text/javascript">
	$(document).ready(function() {
		// JS
	});
</script>
</div>