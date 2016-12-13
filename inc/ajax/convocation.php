<?php
	session_start();
	
	function chargerClasse($classname)
    {
        require_once('../../classes/'.$classname.'.class.php');
    }
    spl_autoload_register('chargerClasse');


	include_once("../connexion_bdd_pdo.php");
	include_once("../connexion_bdd.php");

	include_once("../fonctions.php");
	include_once("../date.php");

	$annee = retourne_annee();

	// Initialisation des managers
	$UtilisateurManager = new UtilisateurManager($connexion);
	$FonctionManager = new FonctionManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$HoraireManager = new HoraireManager($connexion);
	$MatchManager = new MatchManager($connexion);
	$ClubManager = new ClubManager($connexion);
	$JoueurManager = new JoueurManager($connexion);
	
	if(isset($_POST['id_cat']))
		$id_cat = $_POST['id_cat'];
?>
<div class="demo"><?php
	$unMatch = $MatchManager->prochainMatch($id_cat);
	debug($unMatch);
	$nbr_joueurs_max = 0;
	if(!empty($unMatch)) { ?>
		<h4>Convocation de match</h4>
		<div class="infos_match">
			<div class="infos_rencontre"><?php
				$tab = explode(',', $unMatch->getAdversaires());
				$retour = '';
				if(!empty($tab)):
					foreach($tab as $club):
						$unClub = $ClubManager->retourne($club);
						$retour = '<div>';
						$retour .= stripslashes($unClub->getRaccourci())." ".$unClub->getNumero();
						$retour .= '</div>';
					endforeach;
				endif;
				if($unMatch->getLieu()==0) { ?>
					<div class="home">Ach&egrave;res</div>
					<div class="away"><?=$retour;?></div><?php
				} else { ?>
					<div class="home"><?=$retour;?></div>
					<div class="away">Ach&egrave;res</div><?php
				} ?>
			</div>
			<div class="infos_horaire">
				<span><?=$unMatch->remplace_date(2);?> à <?=$unMatch->remplace_heure();?></span>
			</div>
		</div><?php
		$nbr_joueurs_max = retourneNbrJoueursMax($unMatch->getCompetition());
	}
	$options = array('where' => 'categorie = '.$id_cat);
	$listeJoueurs = $JoueurManager->retourneListe($options);
	if(is_array($listeJoueurs)) {
		$nbr = count($listeJoueurs);?>
		<div id="boutons">
			<input type="button" id="recupDerMatch" value="Récupérer la liste du dernier match"/><?php
			$toutSelect = ($nbr<13) ? 'inline' : 'none'; ?>
			<input type="button" id="toutSelect" style="display:<?=$toutSelect;?>" value="Tout sélectionner"/>
			<input type="button" id="toutEffacer" style="display:none;" value="Tout effacer"/>
			<input type="button" id="valider" style="display:none;" value="Valider la liste"/>
		</div>
		<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix"><?php
			foreach($listeJoueurs as $unJoueur) {?>
				<li class="ui-widget-content ui-corner-tr">
					<h5 class="ui-widget-header"><?=$unJoueur['prenom'];?> <?=$unJoueur['nom'];?></h5>
					<div>
						<a href="images/inconnu.gif" title="Zoomer" class="ui-icon ui-icon-zoomin">Zoomer</a>
						<a href="#" title="Ajouter ce joueur" class="ui-icon ui-icon-plus">Ajouter ce joueur</a>
						<span><?=$unJoueur['poste'];?></span><span style="float: right;">N°<?=$unJoueur['num'];?></span>
					</div>
				</li><?php
			}?>
		</ul>
		<div id="trash" class="ui-widget-content ui-state-default">
			<h4 class="ui-widget-header"><span class="ui-icon ui-icon-note">Liste des joueurs</span> Liste des joueurs <span class="compteur"><span class="num_actif">0</span>/<span class="num_max"><?=$nbr_joueurs_max?></span></span></h4>
		</div><?php
	}
	else {?>
		Pas de joueurs enregistr&eacute;s pour cette équipe.<?php
	}?>
</div>
<script type="text/javascript" src="javascript/ajax.js"></script>