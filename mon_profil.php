<?php 
	session_start();

	if(!isset($_SESSION['id'])) {
		header("Location: index.php");
		exit;
	}

	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');


	// Variables de la page
	$page = 'mon_profil';
	$titre_page = 'profil de <span>'.$_SESSION['prenom'] .' '.$_SESSION['nom'].'</span>';
	$titre = 'Mes �quipes';
	$filAriane = array('home', $titre_page);

	// var_dump($_SESSION);exit;

	// On inclue la page de connexion � la BDD
	include_once("inc/connexion_bdd_pdo.php");
	include_once("inc/connexion_bdd.php");

	include_once("inc/fonctions.php");
	include_once("inc/connexion.php");
	include_once("inc/date.php");
	
	$annee = retourne_annee();


	// Initialisation des managers
	$UtilisateurManager = new UtilisateurManager($connexion);
	$FonctionManager = new FonctionManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$HoraireManager = new HoraireManager($connexion);
	$MatchManager = new MatchManager($connexion);
	$ClubManager = new ClubManager($connexion);
	$JoueurManager = new JoueurManager($connexion);
	
	if(isset($_GET['onglet']))
		$onglet = $_GET['onglet']; // On r�cup�re la cat�gorie de staff choisi
	else
		$onglet = 'equipes'; // Par d�faut
	
	$fil_ariane = array(
		array(
			'url' => 'mon_profil.php?onglet=infos',
			'libelle' => 'Mes infos',
			'titre' => 'Mes infos',
			'grp' => 1
		),
		array(
			'url' => 'mon_profil.php?onglet=equipes',
			'libelle' => 'Mes �quipes',
			'titre' => 'Mes �quipes',
			'grp' => 1
		)
	);
	
	switch($onglet) {
		case 'infos':
			$titre = 'Mes infos';
		break;
		case 'equipes':
		default:
			$titre = 'Mes �quipes';
		break;
	}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php include_once('inc/head.php'); ?>
	</head>
	<body id="page1">
		<header>
			<?php include_once('inc/header.php'); ?>
		</header>
		<div id='main'>
			<section id="content">
				<nav>
					<ul>
						<li class="nav navhome"><a href="index.php">Home</a></li>
						<li class="nav navtit2"><span><?=$titre_page?></span></li><?php
						foreach($fil_ariane as $fil) {
							$ong = explode('=', $fil['url']);
							if($onglet != $ong[1] /*&& $fil['grp'] == 1*/) {?>
								<li><span><a href="<?=$fil['url']?>"><?=$fil['libelle']?></a></span></li><?php
							}
							elseif($onglet == $ong[1] /*&& $fil['grp'] == 1*/) {?>
								<li><span class="select"><?=$fil['libelle']?></span></li><?php
							}
						}?>
					</ul>
				</nav>
				<div class="bg1 pad">
					<article class="col marg-right1">
						<h2><?=$titre?></h2><?php
						$options = array('where' => 'type = 4 AND id_utilisateur = '.$_SESSION['id'].' AND annee_fin = 0');
						$listeFonctions = $FonctionManager->retourneListe($options);
						
						if(is_array($listeFonctions)) {?>
							<ul class="tabs2"><?php
								$i = 1;
								foreach($listeFonctions as $uneFonction) {
									$uneCategorie = $CategorieManager->retourneById($uneFonction->getRole());?>
									<li <?php if($i==1) {?>class="active"<?php }?>>
										<a href="#tab<?=$i;?>_2"><?=$uneCategorie->getCategorieAll();?></a>
									</li><?php
									$i++;
								}?>
							</ul><?php
							$j = 1;
							foreach($listeFonctions as $uneFonction) {
								$uneCategorie = $CategorieManager->retourneById($uneFonction->getRole());?>
								<div id="tab<?=$j;?>_2" class="tab_content2" style="display: <?=($j==1)?"block":"none"?>;">
									<div class="wrapper pad_bot1">
										<div class="bloc_profil">
											<h2>Tableau de bord <?=$uneCategorie->getCategorieAll();?></h2>
											<div class="ligne_profil">
												<a href="infos" class="infos">Infos</a>
												<a href="calendar" class="calendar">Calendrier</a>
												<a href="players" class="players">Joueurs</a>
												<a href="news" class="news">News</a>
												<a href="classement" class="classement">Classement</a>
												<input type="hidden" id="id_equipe" value="<?=$uneCategorie->getId();?>" />
											</div>
										</div>
										<div class="contenu_monProfil">
											<div class="infos"><?php
												$options = array('where' => 'categorie = '. $uneCategorie->getId() .' AND annee = '. $annee_actuelle);
												$ficheEquipe = $EquipeManager->retourne($options);?>
												
												<div class="table">
													<div class="row">
														<div class="cell cell-1-5">
															<div class="photo_groupe">
																<img src='images/equipe_lambda.png' alt='Lambda' width='100%' />
															</div>
														</div>
														<div class="cell cell-4-5 infos">
															<div class="bloc">
																<h4><span class="icone"><img src="images/icon/png_white/zoom.png" /></span>L'&eacute;quipe &agrave; la loupe</h4>
																<div class="table">
																	<div class="row">
																		<div class="cell cell-1-3">Niveau</div>
																		<div class="cell cell-2-3">
																			<span>
																				<?=retourneNiveauById($ficheEquipe->getNiveau());?>
																			</span>
																			<select display="none">

																			</select>
																		</div>
																	</div>
																	<div class="row">
																		<div class="cell cell-1-3">Championnat</div><?php
																		$championnat = retourneChampionnatById($ficheEquipe->getChampionnat()); ?>
																		<div class="cell cell-2-3"><?=($championnat)?$championnat:'D&eacute;layage';?></div>
																	</div>
																	<div class="row">
																		<div class="cell cell-1-3">Entraineurs</div>
																		<div class="cell cell-2-3"><?php
																		$tab = explode(',', $ficheEquipe->getEntraineurs());
																		if(is_array($tab)):
																			foreach($tab as $entraineur):
																			$options = array('where' => 'id = '. $entraineur);
																				$unEntraineur = $UtilisateurManager->retourne($options);
																				echo $unEntraineur->getPrenom().' '.$unEntraineur->getNom().'<br/>';
																			endforeach;
																		else:
																			$options = array('where' => 'id = '. $tab);
																			$unEntraineur = $UtilisateurManager->retourne($options);
																			echo $unEntraineur->getPrenom().' '.$unEntraineur->getNom();
																		endif; ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="cell cell-1-3">Entrainements</div>
																		<div class="cell cell-2-3"><?php
																		$tab = explode(',', $ficheEquipe->getEntrainements());
																		if(is_array($tab)):
																			foreach($tab as $entrainement):
																			$options = array('where' => 'id = '. $entrainement);
																				$unHoraire = $HoraireManager->retourne($options);
																				echo $jours[$unHoraire->getJour()].' de '.$unHoraire->remplace_heure($unHoraire->getHeure_debut()).' &agrave; '.$unHoraire->remplace_heure($unHoraire->getHeure_fin()).'<br/>';
																			endforeach;
																		else:
																			$options = array('where' => 'id = '. $tab);
																			$unHoraire = $HoraireManager->retourne($options);
																			echo $jours[$unHoraire->getJour()].' de '.$unHoraire->remplace_heure($unHoraire->getHeure_debut()).' &agrave; '.$unHoraire->remplace_heure($unHoraire->getHeure_fin());
																		endif; ?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="calendar"><?php
												$nbr_par_page = 25;
												$num_page = 1;

												$limite_start =  ($num_page-1) * $nbr_par_page;
												$limite_end = $nbr_par_page;

												$options = array('where' => 'date > '. $annee_actuelle .'0701 AND date < '. $annee_suiv .'0630 AND categorie = '.$uneCategorie->getId());
												$listeMatchs = $MatchManager->retourneListe($options);
												$nbr_matchs = count($listeMatchs);?>
												<div id="zone-ajout">
													<div class="boutons-actions action-ajout">
														<div class="left">
															<a href="#" class="btn btn-ajout ajout-match">Ajouter un match</a>
															<a href="#" class="btn btn-ajout ajout-champ">Ajouter un championnat</a>
														</div>
														<div class="right">
															<a href="#" class="btn btn-search" data-default="Afficher les filtres">Afficher les filtres</a>
														</div>
														<div class="clear_b"></div>
													</div>
												</div>
												<div id="tab_admin">
													<div id="filtres" style="display: none;">
														<div class="table">
															<div class="row boutons-actions">
																<div class="cell cell-1-2">
																	<div class="btn btn-valide"> Valider</div>
																</div>
																<div class="cell cell-1-2 align_right">
																	<div class="btn btn-reset btn-picto"> R�initialis�</div>
																</div>
															</div>
														</div>
														<div class="table marginT">
															<div class="row">
																<div class="cell cell-1-1">
																	<h4><div class="icon">+</div> Cat�gories</h4>
																	<div class="liste_categories" style="display: none;">
																		<div>
																			<input type="checkbox" id="cat_all" class="checked" /> <label for="cat_all">Tout</label>
																		</div><?php
																		$options2 = array('orderby' => 'ordre');
																		$listeCategorie = $CategorieManager->retourneListe($options2);
																		foreach($listeCategorie as $uneCategorie) {?>
																			<div>
																				<input type="checkbox" id="cat_<?=$uneCategorie->getId();?>" class="checked" /> <label for="cat_<?=$uneCategorie->getId();?>"><?=$uneCategorie->getCategorieAll();?></label>
																			</div><?php
																		}?>
																	</div>
																	<input type="hidden" id="filtres_categories"/>
																</div>
															</div>
															<div class="row">
																<div class="cell cell-1-1">
																	<h4><div class="icon">+</div> Comp�titions</h4>
																	<div class="liste_competitions" style="display: none;">
																		<div>
																			<input type="checkbox" id="comp_all" class="checked" /> <label for="comp_all">Tout</label>
																		</div><?php
																		$liste_competition = liste_competition();
																		foreach($liste_competition as $key => $uneCompetition) {?>
																			<div>
																				<input type="checkbox" id="comp_<?=$key;?>" class="checked"/> <label for="comp_<?=$key;?>"><?=$uneCompetition;?></label>
																			</div><?php
																		}?>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="cell cell-1-1">
																	<h4><div class="icon">+</div> Dates</h4>
																	<div class="liste_dates" style="display: none;">
																		<div>
																			<input type="checkbox" id="date_all" class="checked" /> <label for="date_all">Tout</label>
																		</div><?php
																		$liste_date = liste_date($annee);
																		foreach($liste_date as $key => $uneDate) {?>
																			<div>
																				<input type="checkbox" id="date_<?=$key;?>" class="checked" /> <label for="date_<?=$key;?>"><?=$uneDate;?></label>
																			</div><?php
																		}?>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="cell cell-1-1">
																	<h4><div class="icon">+</div> Jou�</h4>
																	<div class="liste_joue" style="display: none;">
																		<div>
																			<input type="checkbox" id="joue" class="" /> <label for="joue">Jou�</label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<table>
														<tr class="titres">
															<th></th>
															<th class="boutons-actions">
																<h4>Date</h4>
																<div>
																	<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
																	<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
																</div>
															</th>
															<th class="boutons-actions">
																<h4>Comp�tition</h4>
																<div>
																	<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
																	<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
																</div>
															</th>
															<th class="boutons-actions">
																<h4>Adversaires</h4>
																<div>
																	<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
																	<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
																</div>
															</th>
															<th class="boutons-actions">
																<h4>Scores</h4>
																<div>
																	<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
																	<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
																</div>
															</th>
															<th>
																<h4>Options</h4>
															</th>
														</tr><?php
														$convoc = true;
														if(!empty($listeMatchs)):
															foreach($listeMatchs as $unMatch):
																// On r�cup�re les infos de la cat�gorie
																$options = array('where' => 'id = '. $unMatch->getCategorie());
																$uneCategorie = $CategorieManager->retourne($options); ?>
																<tr>
																	<td><input type="checkbox" id="match_<?=$unMatch->getId();?>"/></td>
																	<td>
																		<?php if($unMatch->getJoue()) {
																			echo '<span class="boutons-actions"><span class="btn btn-play btn-slim btn-unclickable">'.$unMatch->remplace_date(1).'</span></span>';
																		} else {
																			echo '<span class="boutons-actions"><span class="btn btn-pause btn-slim btn-unclickable">'.$unMatch->remplace_date(1).'</span></span>'; 
																		} ?>
																	</td>
																	<td class="competition">
																		<div class="competition_<?=$unMatch->getCompetition();?>_<?=$unMatch->getNiveau();?>">
																			<?=retourneCompetitionById($unMatch->getCompetition());?>
																			<br/><?=($unMatch->getJournee()!=0)?'Journ&eacute;e '.$unMatch->getJournee():$unMatch->getTour();?>
																		</div>
																	</td><?php
																	if($unMatch->getLieu()==0): ?>
																		<td class="equipes"><?php
																			$tab = explode(',', $unMatch->getAdversaires());
																			if(is_array($tab)):
																				foreach($tab as $club):
																					$unClub = $ClubManager->retourne($club);
																					echo '<div>';
																					echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero().'<br/>';
																					echo '</div>';
																				endforeach;
																			else:
																				$unClub = $ClubManager->retourne($club);
																				echo '<div>';
																				echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero();
																				echo '</div>';
																			endif; ?>
																		</td>
																		<td class="score-team2"><?php
																			if($unMatch->getJoue()):
																				$score_dom = explode(',', $unMatch->getScores_dom());
																				$score_ext = explode(',', $unMatch->getScores_ext());
																				if(is_array($score_dom) && is_array($score_ext)):
																					for($i=0; $i<count($score_dom); $i++):
																						if($score_dom[$i]>$score_ext[$i]):
																							$color = "vert";
																						elseif($score_dom[$i]<$score_ext[$i]):
																							$color = "rouge";
																						else:
																							$color = "orange";
																						endif;
																						echo '<div>';
																						echo "<span class=".$color.">".$score_dom[$i]."<br/>".$score_ext[$i].'</span>';
																						echo '</div>';
																					endfor;
																				else:
																					if($score_dom>$score_ext):
																						$color = "vert";
																					elseif($score_dom<$score_ext):
																						$color = "rouge";
																					else:
																						$color = "orange";
																					endif;	
																					echo '<div>';
																					echo "<span class=".$color.">".$score_dom."<br/>".$score_ext.'</span>';
																					echo '</div>';
																				endif;
																			else:
																				echo "<span class='violet'>". $unMatch->remplace_heure() ."</span>";
																			endif; ?>
																		</td><?php
																	else: ?>
																		<td class="equipes"><?php
																			$tab = explode(',', $unMatch->getAdversaires());
																			if(is_array($tab)):
																				foreach($tab as $club):
																					$unClub = $ClubManager->retourne($club);
																					echo '<div>';
																					echo $unClub->getRaccourci()." ".$unClub->getNumero().'<br/>';
																					echo '</div>';
																				endforeach;
																			else:
																				$unClub = $ClubManager->retourne($club);
																				echo '<div>';
																				echo $unClub->getRaccourci()." ".$unClub->getNumero();
																				echo '</div>';
																			endif; ?>
																		</td>
																		<td class="score-team2"><?php
																			if($unMatch->getJoue()):
																				$score_dom = explode(',', $unMatch->getScores_dom());
																				$score_ext = explode(',', $unMatch->getScores_ext());
																				if(is_array($score_dom) && is_array($score_ext)):
																					for($i=0; $i<count($score_dom); $i++):
																						if($score_dom[$i]<$score_ext[$i]):
																							$color = "vert";
																						elseif($score_dom[$i]>$score_ext[$i]):
																							$color = "rouge";
																						else:
																							$color = "orange";
																						endif;
																						echo '<div>';
																						echo "<span class=".$color.">".$score_dom[$i]."<br/>".$score_ext[$i].'</span><br/>';
																						echo '</div>';
																					endfor;
																				else:
																					if($score_dom<$score_ext):
																						$color = "vert";
																					elseif($score_dom>$score_ext):
																						$color = "rouge";
																					else:
																						$color = "orange";
																					endif;
																					echo '<div>';
																					echo "<span class=".$color.">".$score_dom."<br/>".$score_ext.'</span><br/>';
																					echo '</div>';
																				endif;
																			else:
																				echo "<span class='violet'>". $unMatch->remplace_heure() ."</span>";
																			endif; ?>
																		</td><?php
																	endif; ?>
																	<td class="boutons-actions convoc">
																		<a href="<?=$unMatch->getId();?>" class="btn btn-modif btn-slim" title="Modifier le match">Modifier le match</a>
																		<a href="<?=$unMatch->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer le match">Supprimer le match</a><?php
																		if($convoc && $unMatch->getJoue()==0 && $unMatch->getDate() > date('Ymd')) {?>
																			<a href="<?=$unMatch->getId()?>_<?=$j;?>" class="btn btn-convoc btn-slim">Convocation de match</a><?php
																			$convoc = false;
																		}?>
																	</td>
																</tr><?php
															endforeach;
														else : ?>
															<tr>
																<td colspan='7'>Pas de match enregistr�</td>
															</tr><?php
														endif;?>
													</table>
													<div class="pagination">
														Page : <?php
														$nbrPage = ceil($nbr_matchs/$nbr_par_page);
														for($i=1; $i<=$nbrPage; $i++) {
															if($num_page == $i)
																echo '<span>'.$i.'</span> ';
															else
																echo '<a href="admin.php?page=calendrier&amp;num_page='.$i.'">'.$i.'</a> ';
														}?>
													</div>
												</div>
											</div>
											<div class="players">
												<div class="tab_container">
													<div>
														<h3 class="">Liste des joueurs</h3>
													</div>
													<div id="zone-ajout">
														<div class="boutons-actions action-ajout">
															<div class="left">
																<a href="#" class="btn btn-ajout">Ajouter un joueur</a>
															</div>
															<div class="clear_b"></div>
														</div>
													</div>
													<div id="tab_admin">
														<table>
															<tr class="titres">
																<th></th>
																<th class="num w_5">N�</th>
																<th class="nom align_left w_50">Nom/Pr�nom</th>
																<th class="age w_5">Age</th>
																<th class="equipe align_left w_15">Equipe</th>
																<th class="poste align_left w_5">Poste</th>
																<th class="actif align_left w_5">Actif</th>
																<th class="options w_15"></th>
															</tr><?php
															$i = 0;
															$options = array('where' => 'categorie = '.$uneCategorie->getId());
															$listeJoueurs = $JoueurManager->retourneListe($options);
															if(!empty($listeJoueurs)):
																foreach($listeJoueurs as $unJoueur):?>
																	<tr <?=($i%2==1) ? 'class="odd"' : '';?>>
																		<td><input type="checkbox" name="joueurs_check" class="joueurs_check"/></td>
																		<td><span class="joueurs_num"><?=$unJoueur['num'];?></span></td>
																		<td><span class="joueurs_nom"><?=$unJoueur['nom'];?></span></td>
																		<td><span class="joueurs_prenom"><?=$unJoueur['prenom'];?></span></td>
																		<td><span class="joueurs_age"><?=$unJoueur['age'];?></span></td>
																		<td><span class="joueurs_poste"><?=$unJoueur['poste'];?></span></td>
																		<td class="boutons">
																			<a href="<?=$unJoueur['id'];?>" class="suppr" title="Supprimer">Supprimer le joueur</a>
																			<a href="<?=$unJoueur['id'];?>" class="modif" title="Modifier">Modifier le joueur</a>
																			<a href="<?=$unJoueur['id'];?>" class="voir" title="Voir">Voir le joueur</a>
																		</td>
																	</tr><?php
																	$i++;
																endforeach;
															else:?>
																<tr>
																	<td colspan="8">Aucun joueur enregistr�</td>
																</tr><?php
															endif;?>
														</table>
													</div>
												</div>
											</div>
											<div class="news">
												News
											</div>
											<div class="classement">
												Classement
											</div>
										</div>
									</div>
									<div id="convoc<?=$j;?>"></div>
								</div><?php
								$j++;
							}
						}?>

					</article>
				</div>
			</section>
			<footer>
				<?php include_once('inc/footer.php'); ?>
			</footer>
			<div id="fond" class="fond_transparent"></div>
		</div>
		<div id="modif_match"></div>
		<?php include('inc/script.php'); ?>
		<script src="javascript/mon_profil.js"></script>
	</body>
</html>