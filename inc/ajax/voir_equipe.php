<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	if(isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	$uneEquipe = retourneEquipeById($id);
?>
<div class="popin voir_equipe">
	<fieldset>
		<legend>Infos équipe</legend>
		<div >
			Catégorie : <?=$uneEquipe['categorie'];?>
		</div>
		<div>
			Niveau : <?=$uneEquipe['niveau'];?>
		</div>
		<div>
			Championnat : <?=$uneEquipe['championnat'];?>
		</div>
		<div>
			Année : <?=$uneEquipe['annee'];?>
		</div>
		<div>
			Actif : <?=$uneEquipe['actif'];?>
		</div>
	</fieldset>
</div>