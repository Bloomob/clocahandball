<?php
	include_once("connexion_bdd.php");
	include_once('fonctions.php');
	include_once('constantes.php');
	include_once('date.php');
	
	$laCategorie = false;
	if(isset($_POST['laCategorie'])) {
		$laCategorie = $_POST['laCategorie'];
	}
?>

<div class="popin ajout_match">
	<div>
		<fieldset>
			<legend>Cat&eacute;gorie :</legend>
			<div><?php
				if($laCategorie) {
					$uneCategorie = liste_categorie($laCategorie); ?>
					<span><?=$uneCategorie[0]['cat']?></span>
					<input type="hidden" id="team_categorie" name="team_categorie" value="<?=$uneCategorie[0]['id']?>"><?php
				}
				else {?>
					<select id="team_categorie" name="team_categorie"><?php
						$liste_categorie = liste_categorie();
						foreach($liste_categorie as $uneCategorie) {?>
							<option value="<?=$uneCategorie['id']?>"><?=$uneCategorie['cat']?></option><?php
						}?>
					</select>
					<?php
				} ?>
			</div>
		</fieldset>
	</div>
	<div>
		<fieldset>
			<legend>Date :</legend>
			<div>
				<select id="team_jour" name="team_jour"><?php
					for($i=1; $i<32; $i++) {?>
						<option value="<?=$i?>"><?=$i?></option><?php
					}?>
				</select>
				/
				<select id="team_mois" name="team_mois"><?php
					foreach($mois_de_lannee as $key => $unMois) {?>
						<option value="<?=$key+1?>"><?=$unMois?></option><?php
					}?>
				</select>
				/
				<select id="team_annee" name="team_annee"><?php
					$annee_saison = retourne_annee();
					for($i=$annee_saison; $i<$annee_saison+2; $i++) {?>
						<option value="<?=$i?>"><?=$i?></option><?php
					}?>
				</select>
				&agrave;
				<select id="team_heure" name="team_heure"><?php
					for($i=9; $i<22; $i++) {?>
						<option value="<?=$i?>"><?=$i?></option><?php
					}?>
				</select>
				h
				<select id="team_minute" name="team_minute"><?php
					for($i=0; $i<61; $i+=15) {?>
						<option value="<?=$i?>"><?=$i?></option><?php
					}?>
				</select>
			</div>
		</fieldset>
	</div>
	<div>
		Lieu :
		<select id="team_lieu" name="team_lieu"><?php
			$lieux = array("Domicile", "Exterieur", "Neutre");
			foreach($lieux as $key=>$unLieu) {?>
				<option value="<?=$key?>"><?=$unLieu?></option><?php
			}?>
		</select>
	</div>
	<div>
		Gymnase : <input type="text" id="team_gymnase" name="team_gymnase">
	</div>
	<div>
		Adresse : <input type="text" id="team_adresse" name="team_adresse">
	</div>
	<div>
		Ville : <input type="text" id="team_ville" name="team_ville">
	</div>
	<div>
		Code postal : <input type="text" id="team_code_postal" name="team_code_postal" size="5" maxlength="5">
	</div>
	<div id="bloc_journee">
		Comp&eacute;tition : 
		<select id="team_competition" name="team_competition">
			<option value="-">-</value><?php
			$liste_competition = liste_competition();
			foreach($liste_competition as $key => $uneCompetition) {?>
				<option value="<?=$key?>"><?=$uneCompetition?></option><?php
			}?>
		</select>
		<select id="team_niveau" name="team_niveau">
			<option value="-">-</value><?php
			$liste_niveau = liste_niveau();
			foreach($liste_niveau as $key => $unNiveau) {?>
				<option value="<?=$key?>"><?=$unNiveau?></option><?php
			}?>
		</select>
	</div>
	<div id="bloc_journee">
		Journ&eacute;e : <input type="text" id="team_journee" name="team_journee" size="5" maxlength="2">
	</div>
	<div id="bloc_tour">
		Tour : <input type="text" id="team_tour" name="team_tour" size="10">
	</div>
	<div>
		Adversaire(s) : 
		<input type="text" id="team_adversaire1" name="team_adversaire1">
		<input type="text" id="team_adversaire2" name="team_adversaire2">
		<input type="text" id="team_adversaire3" name="team_adversaire3">
	</div>
	<div>
		Score(s) : 
		<input type="text" id="team_dom1" name="team_dom1" size="5" maxlength="2"> - <input type="text" id="team_ext1" name="team_ext1" size="5" maxlength="2"> |
		<input type="text" id="team_dom2" name="team_dom2" size="5" maxlength="2"> - <input type="text" id="team_ext2" name="team_ext2" size="5" maxlength="2"> |
		<input type="text" id="team_dom3" name="team_dom3" size="5" maxlength="2"> - <input type="text" id="team_ext3" name="team_ext3" size="5" maxlength="2">
	</div>
	<div id="team_joue">
		Match jou&eacute; ? : 
		Oui <input type="radio" name="team_joue" value="1"> | Non <input type="radio" name="team_joue" checked value="0">
	</div>
	<div>
		Arbitre : 
		<input type="text" id="team_arbitre" name="team_arbitre">
	</div>
	<div>
		Classement : 
		<input type="text" id="team_classement" name="team_classement">
	</div>
</div>