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
<div class="popin">
	<fieldset>
		<legend>Club</legend>
		<div style="float: right;"><?php
			if($unClub->getActif()) {
				echo "<span style='background: rgb(0, 210, 0); color: rgb(255, 255, 255); padding: 5px;'>ACTIF</span>";
			}
			else { 
				echo "<span style='color: rgb(233, 12, 12);'>INACTIF</span>";
			} ?>
		</div>
		<div class="colone1">
			Nom :
		</div>
		<div class="colone2">
			<?=$unClub->getNom();?>
		</div>
		<div class="colone1">
			Raccoourci :
		</div>
		<div class="colone2">
			<?=$unClub->getRaccourci();?>
		</div>
		<div class="colone1">
			Num&eacute;ro :
		</div>
		<div class="colone2">
			<?=$unClub->getNumero();?>
		</div>
		<div class="colone1">
			Ville :
		</div>
		<div class="colone2">
			<?=$unClub->getVille();?>
		</div>
		<div class="colone1">
			Code postal :
		</div>
		<div class="colone2">
			<?=$unClub->getCode_postal();?>
		</div>
	</fieldset>
</div>