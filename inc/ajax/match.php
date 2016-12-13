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
	include_once('../date.php');

	$id = (isset($_POST['id'])) ? $_POST['id'] : 0;

	$MatchManager = new MatchManager($connexion);
	$options = array('where' => 'id = '. $id);
	$unMatch = $MatchManager->retourne($options);
?>

<div class='popin'>
	<div class="ligne">
		<div class="colone1">
			<label for="titre">Categorie :</label>
		</div>
		<div class="colone2">
			<input type="text" id="titre" class="champ" value="<?=$unMatch->getCategorie();?>">
		</div>
	</div>
	<div class="ligne">
		<div class="colone1">
			<label for="sous_titre">Sous-titre :</label>
		</div>
		<div class="colone2">
			<input type="text" id="sous_titre" class="champ" value="<?=htmlspecialchars_decode($uneActu->getSous_titre());?>">
		</div>
	</div>
	<div class="ligne">
		<div class="colone1">
			<label for="contenu">Contenu :</label>
		</div>
		<div class="colone2">
			<textarea id="contenu" name="contenu" class="champ tinymce"><?=htmlspecialchars_decode($uneActu->getContenu());?></textarea>
		</div>
	</div>
	<div class="ligne">
		<div class="colone1">
			<label for="theme">Theme :</label>
		</div>
		<div class="colone2">
			<select id="theme" class="champ"><?php
				foreach($tabTheme as $cle => $unTheme) { ?>
					<option value="<?=$cle;?>" <?=($uneActu->getTheme()==$cle)?"selected='selected'":'';?>><?=$unTheme;?></option><?php
				}?>
			</select>
		</div>
	</div>
</div>
<div class="ajout_match">
	<div>
		<fieldset>
			<legend>Cat&eacute;gorie :</legend>
			<div><?php
				if($laCategorie) {
					$uneCategorie = liste_categorie($laCategorie); ?>
					<span><?=$uneCategorie[0]['cat']?></span>
					<input type="hidden" id="team_categorie" name="team_categorie" value="<?=$uneCategorie[0]['id']?>"><?php
				}
				elseif($unMatch) {
					$uneCategorie = liste_categorie($unMatch['categorie']); ?>
					<span><?=$uneCategorie[0]['categorie']?></span>
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
						<option value="<?=$i?>" <?=(date('j')==$i)?'selected="selected"':'';?>><?=$i?></option><?php
					}?>
				</select>
				/
				<select id="team_mois" name="team_mois"><?php
					foreach($mois_de_lannee as $key => $unMois) {?>
						<option value="<?=$key+1?>" <?=(date('n')==$key+1)?'selected="selected"':'';?>><?=$unMois?></option><?php
					}?>
				</select>
				/
				<select id="team_annee" name="team_annee"><?php
					$annee_saison = retourne_annee();
					for($i=$annee_saison; $i<$annee_saison+2; $i++) {?>
						<option value="<?=$i?>" <?=(date('Y')==$i)?'selected="selected"':'';?>><?=$i?></option><?php
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
		<fieldset>
			<legend>Lieu :</legend>
			<div>
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
		</fieldset>
	</div>
	<div id="bloc_journee">
		<fieldset>
			<legend>Comp&eacute;tition :</legend>
			<div>
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
			<div>
				Journ&eacute;e : <input type="text" id="team_journee" name="team_journee" size="5" maxlength="2">
			</div>
			<div>
				Tour : <input type="text" id="team_tour" name="team_tour" size="10">
			</div>
		</fieldset>
	</div>
	<div>
		<fieldset>
			<legend>Adversaire(s) :</legend>
			<div>
				<input type="text" id="team_adversaire1" name="team_adversaire1"> | <input type="text" id="team_dom1" name="team_dom1" size="5" maxlength="2"> - <input type="text" id="team_ext1" name="team_ext1" size="5" maxlength="2">
			</div>
			<div>
				<input type="text" id="team_adversaire2" name="team_adversaire2"> | <input type="text" id="team_dom2" name="team_dom2" size="5" maxlength="2"> - <input type="text" id="team_ext2" name="team_ext2" size="5" maxlength="2">
			</div>
			<div>
				<input type="text" id="team_adversaire3" name="team_adversaire3"> | <input type="text" id="team_dom3" name="team_dom3" size="5" maxlength="2"> - <input type="text" id="team_ext3" name="team_ext3" size="5" maxlength="2">
			</div>
		</fieldset>
	</div>
	<div id="team_joue">
		<fieldset>
			<legend>Match jou&eacute; ?</legend>
			<div>
				Oui <input type="radio" name="team_joue" value="1"> | Non <input type="radio" name="team_joue" checked value="0">
			</div>
		</fieldset>
	</div>
	<div>
		<fieldset>
			<legend>Arbitre :</legend>
			<div>
				<input type="text" id="team_arbitre" name="team_arbitre">
			</div>
		</fieldset>
	</div>
	<div>
		<fieldset>
			<legend>Classement :</legend>
			<div>
				<input type="text" id="team_classement" name="team_classement">
			</div>
		</fieldset>
	</div>
</div>