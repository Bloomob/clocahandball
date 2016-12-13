<?php
	include_once("../connexion_bdd.php");
	include_once('../fonctions.php');
	
	if(isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	$unJoueur = retourneJoueurById($id);
	// debug($unJoueur);
	$unUtilisateur = retourneUtilisateurById($unJoueur['id_utilisateur']);
?>
<div class="voir_joueur">
	<fieldset>
		<legend>Infos personnelles</legend>
		<div >
			Nom : <?=$unUtilisateur['nom'];?>
		</div>
		<div>
			Pr&eacute;nom : <?=$unUtilisateur['prenom'];?>
		</div>
		<div>
			Cat&eacute;gorie : <?=retourneCategorieById($unJoueur['categorie']);?>
		</div>
		<div>
			Poste : <?=retournePosteById($unJoueur['poste']);?>
		</div>
		<div>
			Ann&eacute;e d'arriv&eacute;e : <?=$unJoueur['annee_arrivee'];?>
		</div>
		<div>
			Num&eacute;ro : <?=$unJoueur['numero'];?>
		</div>
		<?php
			$now = date('Ymd');
			$date_de_naissance =  $now - $unJoueur['date_de_naissance'];
			$age = substr($date_de_naissance, 0, 2)." ans";
		?>
		<div>
			Age : <?=$age;?>
		</div>
		<?php
			if($unJoueur['affiche_photo']) {
				$affiche_photo = 'oui';
			}
			else {
				$affiche_photo = 'non';
			}
		?>
		<div>
			Photo : <?=$affiche_photo;?>
		</div>
		<?php
			if($unJoueur['actif']) {
				$actif = 'oui';
			}
			else {
				$actif = 'non';
			}
		?>
		<div>
			Actif : <?=$actif;?>
		</div>
	</fieldset>
</div>