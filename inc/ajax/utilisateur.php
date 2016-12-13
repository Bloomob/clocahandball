<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	include_once('../constantes.php');
	include_once('../date.php');
	
	$id = 0;
	if(isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	
	$unUtilisateur = retourneUtilisateurById($id);
	if(!is_array($unUtilisateur)) {
		$unUtilisateur = array('nom' => '', 'prenom' => '', 'mail' => '', 'photo' => '', 'tel_port' => '');
	}
?>
<div class="utilisateur">
	<form action="processupload.php" method="post" enctype="multipart/form-data" id="UploadForm">
		<fieldset>
			<legend>Infos personnelles :</legend>
			<div>
				Nom : <input type="text" id="utilisateur_nom" name="utilisateur_nom" value="<?=$unUtilisateur['nom'];?>">
			</div>
			<div>
				Pr&eacute;nom : <input type="text" id="utilisateur_prenom" name="utilisateur_prenom" value="<?=$unUtilisateur['prenom'];?>">
			</div>
			<div>
				Mail : <input type="text" id="utilisateur_email" name="utilisateur_email" value="<?=$unUtilisateur['mail'];?>">
			</div>
			<div>
				Photo : <input type="file" id="utilisateur_photo" name="utilisateur_photo" />
				<a href="#">Upload</a>
			</div>
			<div>
				T&eacute;l : <input type="text" id="utilisateur_tel" name="utilisateur_tel" value="<?=$unUtilisateur['tel_port'];?>"/>
			</div>
		</fieldset>
	</form>
</div>