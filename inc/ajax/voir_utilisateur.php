<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	if(isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	$unUtilisateur = retourneUtilisateurById($id);
?>
<div class="voir_utilisateur">
	<fieldset>
		<legend>Infos personnelles</legend>
		<div >
			Nom : <?=$unUtilisateur['nom'];?>
		</div>
		<div>
			Pr&eacute;nom : <?=$unUtilisateur['prenom'];?>
		</div>
		<div>
			Mail : <?=$unUtilisateur['mail'];?>
		</div>
		<div>
			Photo : 
		</div>
		<div>
			T&eacute;l : <?=$unUtilisateur['tel_port'];?>
		</div>
	</fieldset>
	<fieldset>
		<legend>Infos compte</legend>
		<div >
			Actif : <?=$unUtilisateur['actif'];?>
		</div>
	</fieldset>
</div>