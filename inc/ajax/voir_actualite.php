<?php
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
	$UtilManager = new UtilisateurManager($connexion);
	$options = array('where' => 'id = '. $id);
	$uneActu = $ActuManager->retourne($options);
?>
<div class="popin voir_actualite">
	<fieldset>
		<legend>Actualit&eacute; n&deg;<?=$uneActu->getId();?></legend>
		<div style="float: right;"><?php
			if($uneActu->getPublie()) {
				echo "<span style='background: rgb(0, 210, 0); color: rgb(255, 255, 255); padding: 5px;'>PUBLI&Eacute;</span>";
			}
			else { 
				echo "<span style='color: rgb(233, 12, 12);'>NON PUBLI&Eacute;</span>";
			} ?>
		</div>
		<div class="colone1">
			Titre :
		</div>
		<div class="colone2">
			<?=$uneActu->getTitre();?>
		</div>
		<div class="colone1">
			Sous-titre :
		</div>
		<div class="colone2">
			<?=$uneActu->getSous_titre();?>
		</div>
		<div class="colone1">
			Contenu :
		</div>
		<div class="colone2">
			<?=nl2br($uneActu->getContenu());?>
		</div>
		<div class="colone1">
			Auteur :
		</div>
		<div class="colone2">
			<?php
				$options = array('where' => 'id = '. $uneActu->getId_auteur_crea());
				$auteur = $UtilManager->retourne($options);
				echo $auteur->getPrenom().' '.$auteur->getNom();
			?>
		</div>
		<div class="colone1">
			Date de cr&eacute;ation :
		</div>
		<div class="colone2">
			<?=$uneActu->remplace_date($uneActu->getDate_creation());?> &agrave; <?=$uneActu->remplace_heure($uneActu->getHeure_creation());?>
		</div>
		<div class="colone1">
			Date de modification :
		</div>
		<div class="colone2"><?php
			if($uneActu->getDate_modification() != 0) {?>
				<?=$uneActu->remplace_date($uneActu->getDate_modification());?> &agrave; <?=$uneActu->remplace_heure($uneActu->getHeure_modification());?><?php
			}
			else {?>
				Aucune modification effectu&eacute;e<?php
			}?>
		</div>
		<div class="colone1">
			Image :
		</div>
		<div class="colone2">
			<img src="images/<?=$uneActu->getImage();?>.png"/>
		</div>
	</fieldset>
</div>