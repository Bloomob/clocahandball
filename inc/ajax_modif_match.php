<?php
	include_once("connexion_bdd.php");
	include_once('fonctions.php');
	
	if(isset($_POST['id']))
		$id_match = $_POST['id'];
?>
<script>
	
</script>
<?php
$unMatch = retourneUnMatch($id_match);
// echo '<pre>'; var_dump($unMatch); echo '</pre>';
if(is_array($unMatch)) {?>
	<div id="bloc_categorie">
		Cat&eacute;gorie : 
		<select id="team_categorie" name="team_categorie"><?php
			$liste_categorie = liste_categorie();
			foreach($liste_categorie as $uneCategorie) {?>
				<option value="<?=$uneCategorie['id']?>" <?php if($unMatch['id_categorie'] == $uneCategorie['id']) { echo 'selected'; } ?>><?=$uneCategorie['cat']?></option><?php
			}?>
		</select>
	</div>
	<div id="bloc_date">
		Date : 
		<input type="text" id="team_jour" name="team_jour" value="<?=$unMatch['jour']?>" size="2" maxlength="2">
		/
		<input type="text" id="team_mois" name="team_mois" value="<?=$unMatch['mois']?>" size="2" maxlength="2">
		/
		<input type="text" id="team_annee" name="team_annee" value="<?=$unMatch['annee']?>" size="4" maxlength="4">
		&agrave;
		<input type="text" id="team_heure" name="team_heure" value="<?=$unMatch['heure']?>" size="2" maxlength="2">
		h
		<input type="text" id="team_minute" name="team_minute" value="<?=$unMatch['minute']?>" size="2" maxlength="2">
	</div>
	<div>
		Lieu :
		<select id="team_lieu" name="team_lieu"><?php
			$lieux = array("Domicile", "Exterieur", "Neutre");
			foreach($lieux as $key=>$unLieu) {?>
				<option value="<?=$key?>" <?php if($unMatch['lieu'] == $key) { echo 'selected'; } ?>><?=$unLieu?></option><?php
			}?>
		</select>
	</div>
	<div>
		Gymnase : <input type="text" id="team_gymnase" name="team_gymnase" value="<?=$unMatch['gymnase']?>">
	</div>
	<div>
		Adresse : <input type="text" id="team_adresse" name="team_adresse" value="<?=$unMatch['adresse']?>">
	</div>
	<div>
		Ville : <input type="text" id="team_ville" name="team_ville" value="<?=$unMatch['ville']?>">
	</div>
	<div>
		Code postal : <input type="text" id="team_code_postal" name="team_code_postal" value="<?=$unMatch['code_postal']?>" size="5" maxlength="5">
	</div>
	<div id="bloc_journee">
		Comp&eacute;tition : 
		<select id="team_competition" name="team_competition">
			<option value="-">-</value><?php
			$liste_competition = liste_competition();
			foreach($liste_competition as $key => $uneCompetition) {?>
				<option value="<?=$key?>" <?php if($unMatch['compet'] == $key) { echo 'selected'; } ?>><?=$uneCompetition?></option><?php
			}?>
		</select>
		<select id="team_niveau" name="team_niveau">
			<option value="-">-</value><?php
			$liste_niveau = liste_niveau();
			foreach($liste_niveau as $key => $unNiveau) {?>
				<option value="<?=$key?>" <?php if($unMatch['niveau'] == $key) { echo 'selected'; } ?>><?=$unNiveau?></option><?php
			}?>
		</select>
	</div>
	<div id="bloc_journee">
		Journ&eacute;e : <input type="text" id="team_journee" name="team_journee" value="<?=$unMatch['journee']?>" size="5" maxlength="2">
	</div>
	<div id="bloc_tour">
		Tour : <input type="text" id="team_tour" name="team_tour" value="<?=$unMatch['tour']?>" size="10">
	</div>
	<div>
		Adversaire(s) : 
		<input type="text" id="team_adversaire1" name="team_adversaire1" value="<?=$unMatch['adversaire1']?>">
		<input type="text" id="team_adversaire2" name="team_adversaire2" value="<?=$unMatch['adversaire2']?>">
		<input type="text" id="team_adversaire3" name="team_adversaire3" value="<?=$unMatch['adversaire3']?>">
	</div>
	<div>
		Score(s) : 
		<input type="text" id="team_dom1" name="team_dom1" value="<?=$unMatch['score_dom1']?>" size="5" maxlength="2"> - <input type="text" id="team_ext1" name="team_ext1" value="<?=$unMatch['score_ext1']?>" size="5" maxlength="2"> |
		<input type="text" id="team_dom2" name="team_dom2" value="<?=$unMatch['score_dom2']?>" size="5" maxlength="2"> - <input type="text" id="team_ext2" name="team_ext2" value="<?=$unMatch['score_ext2']?>" size="5" maxlength="2"> |
		<input type="text" id="team_dom3" name="team_dom3" value="<?=$unMatch['score_dom3']?>" size="5" maxlength="2"> - <input type="text" id="team_ext3" name="team_ext3" value="<?=$unMatch['score_ext3']?>" size="5" maxlength="2">
	</div>
	<div id="team_joue">
		Match jou&eacute; ? : 
		Oui <input type="radio" name="team_joue" value="1" <?php if($unMatch['joue']) { echo 'checked="checked"'; } ?>> | 
		Non <input type="radio" name="team_joue" value="0" <?php if(!$unMatch['joue']) { echo 'checked="checked"'; } ?>>
	</div>
	<div>
		Arbitre : 
		<input type="text" id="team_arbitre" name="team_arbitre" value="<?=$unMatch['arbitre']?>">
	</div>
	<div>
		Classement : 
		<input type="text" id="team_classement" name="team_classement" value="<?=$unMatch['classement']?>">
	</div>
	<?php
}
else {?>
	<div>Ce match n'existe pas.</div><?php
}?>