<?php 
	session_start();
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');


	// initialisation des variables
	$page = 'resultats_classements';
	$titre_page = 'resultats & classements';
	$titre = 'Les r&eacute;sultats & classements';
	$filAriane = array('home', $titre_page);

	// On inclue la page de connexion à la BDD
	include_once("inc/connexion_bdd_pdo.php");
	require_once("inc/connexion_bdd.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");
	// include_once("inc/connexion.php");
	
	// Initialisation des managers
	$CategorieManager = new CategorieManager($connexion);
	$MatchManager = new MatchManager($connexion);
	$ClubManager = new ClubManager($connexion);

	$annee = retourne_annee();	
	
	if(isset($_GET['onglet']))
		$onglet = $_GET['onglet']; // On récupère la catégorie de staff choisi
	else
		$onglet = 'calendrier'; // Par défaut
	
	$pages = array(
		array(
			'url' => 'resultats_classements.php?onglet=matchs_a_venir',
			'libelle' => 'Matchs à venir',
			'grp' => 1
		),
		array(
			'url' => 'resultats_classements.php?onglet=resultats_week-end',
			'libelle' => 'Résultats de la semaine',
			'grp' => 1
		),
		array(
			'url' => 'resultats_classements.php?onglet=classements',
			'libelle' => 'Classements',
			'grp' => 1
		),
		array(
			'url' => 'resultats_classements.php?onglet=coupe_yvelines',
			'libelle' => 'CDY',
			'grp' => 2
		),
		array(
			'url' => 'resultats_classements.php?onglet=coupe_france',
			'libelle' => 'CDF',
			'grp' => 2
		),
		// array(
		// 	'url' => 'resultats_classements.php?onglet=historique',
		// 	'libelle' => 'Historique',
		// 	'grp' => 2
		// ),
		array(
			'url' => 'resultats_classements.php?onglet=calendrier',
			'libelle' => 'Calendrier',
			'grp' => 1
		)
	);
	
	switch($onglet) {
		case 'matchs_a_venir':
			$titre = 'Les matchs à venir';
		break;
		case 'resultats_week-end':
			$titre = 'Les résultats de la semaine';
		break;
		case 'classements':
			$titre = 'Les classements';
		break;
		case 'coupe_yvelines':
			$titre = 'La coupe des Yvelines';
		break;
		case 'coupe_france':
			$titre = 'La coupe de France';
		break;
		// case 'historique':
		// 	$titre = 'L\'historique';
		// break;
		case 'calendrier':
		default:
			$titre = 'Le calendrier général';
		break;
	}
	
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php include_once('inc/head.php'); ?>
	</head>
	<body>
		<header id="entete">
			<?php include_once('inc/header.php'); ?>
		</header>
		<div id='main'>
			<section id="content" class="<?=$page;?>">
				<?php include_once('inc/fil_ariane.php'); ?>
				<div class="container">
					<div class="row">
						<article class="col-sm-8">
							<div class="contenu">
								<h2><i class="fa fa-calendar" aria-hidden="true"></i><?=$titre?></h2>
								<div class="resultats_classement">
									<?php
									switch($onglet) {
										case 'matchs_a_venir':
											$options = array('where' => 'date >= '. $now .' AND date < '. date_plus_7J($now) .' AND joue = 0', 'orderby' => 'date, heure');
											$listeMatchs = $MatchManager->retourneListe($options);
											// echo '<pre>'; var_dump($listeMatchs); echo '</pre>';?>
											<div class="legende">
												La liste des matchs prévus dans les 7 jours à venir
											</div><?php
											if(isset($_SESSION['rang'])):
												if($_SESSION['rang']==1):?>
													<img src="images/icon/png_black/doc-out.png" id="export_cal"/><?php
												endif;
											endif; ?>
											<table id="tab_result">
												<?php
												if(!empty($listeMatchs)):
													$i=2;
													$jour_actuel = '';
													foreach($listeMatchs as $unMatch) :
														$options2 = array('where' => 'id = '. $unMatch->getCategorie());
														$uneCategorie = $CategorieManager->retourne($options2); ?>
														<tr class="cell<?=$i;?>">
															<td class="date">
																<div class="jour"><?=$unMatch->getJour();?></div>
																<div class="mois"><?=$mois_de_lannee_min[$unMatch->getMois()-1];?></div>
															</td>
															<td class="competition">
																<div class="competition_<?=$unMatch->getCompetition();?>_<?=$unMatch->getNiveau();?>">
																	<?=retourneCompetitionById($unMatch->getCompetition());?>
																	<br/><?=($unMatch->getJournee()!=0)?'Journ&eacute;e '.$unMatch->getJournee():$unMatch->getTour();?>
																</div>
															</td>
															<td class="puce"><?php
																if($unMatch->getLieu()==0 ): ?>
																	<div class="cat_<?=$uneCategorie->getRaccourci();?>"></div><a href="equipes.php?onglet=<?=$uneCategorie->getRaccourci();?>"><strong><?=$uneCategorie->getCategorie();?> <?=substr($uneCategorie->getGenre(),0,1);?><?=$uneCategorie->getNumero();?></strong></a><br/><?php
																endif;
																$tab = explode(',', $unMatch->getAdversaires());
																if(is_array($tab)):															
																	foreach($tab as $club):
																		$options = array('where' => 'id = '. $club);
																		$unClub = $ClubManager->retourneById($club);
																		echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero().'<br/>';
																	endforeach;
																endif;
																if($unMatch->getLieu()>0 ): ?>
																	<div class="cat_<?=$uneCategorie->getRaccourci();?>"></div><a href="equipes.php?onglet=<?=$uneCategorie->getRaccourci();?>"><strong><?=$uneCategorie->getCategorie();?> <?=substr($uneCategorie->getGenre(),0,1);?><?=$uneCategorie->getNumero();?></strong></a><?php
																endif; ?>
															</td>
															<td class="heure"><span><?=$unMatch->remplace_heure();?></span></td>
														</tr><?php
														$i++;
														if($i==3) $i=1;
													endforeach;
												else: ?>
													<tr>
														<td colspan='8'>Pas de matchs à venir prochainement</td>
													</tr><?php
												endif;?>
											</table><?php
										break;
										case 'resultats_week-end':
											// $listeMatchs = liste_resultats_semaine($now);
											$options = array('where' => 'date <= '. $now .' AND date > '. date_moins_7J($now) .' AND joue = 1', 'orderby' => 'date, heure');
											$listeMatchs = $MatchManager->retourneListe($options);
											// echo '<pre>'; var_dump($listeMatchs); echo '</pre>';?>
											<div class="legende">La liste des matchs qui se sont déroulés lors des 7 derniers jours.</div>
											<table id="tab_result"><?php
												if(!empty($listeMatchs)):
													$i=2;
													foreach($listeMatchs as $unMatch):
														$options2 = array('where' => 'id = '. $unMatch->getCategorie());
														$uneCategorie = $CategorieManager->retourne($options2); ?>
														<tr class="cell<?=$i;?>">
															<td class="date">
																<div class="jour"><?=$unMatch->getJour();?></div>
																<div class="mois"><?=$mois_de_lannee_min[$unMatch->getMois()-1];?></div>
															</td>
															<td class="heure"><span><?=($unMatch->remplace_heure()!=0)?$unMatch->remplace_heure():'';?></span></td>
															<td class="competition">
																<div class="competition_<?=$unMatch->getCompetition();?>_<?=$unMatch->getNiveau();?>">
																	<?=retourneCompetitionById($unMatch->getCompetition());?>
																	<br/><?=($unMatch->getJournee()!=0)?'Journ&eacute;e '.$unMatch->getJournee():$unMatch->getTour();?>
																</div>
															</td>
															<td class="puce"><?php
																if($unMatch->getLieu()==0 ): ?>
																	<div class="cat_<?=$uneCategorie->getRaccourci();?>"></div><a href="equipes.php?onglet=<?=$uneCategorie->getRaccourci();?>"><strong><?=$uneCategorie->getCategorie();?> <?=substr($uneCategorie->getGenre(),0,1);?><?=$uneCategorie->getNumero();?></strong></a><br/><?php
																endif;
																$tab = explode(',', $unMatch->getAdversaires());
																if(is_array($tab)):															
																	foreach($tab as $club):
																		$options = array('where' => 'id = '. $club);
																		$unClub = $ClubManager->retourneById($club);
																		echo  stripslashes($unClub->getRaccourci())." ".$unClub->getNumero().'<br/>';
																	endforeach;
																endif;
																if($unMatch->getLieu()>0 ): ?>
																	<div class="cat_<?=$uneCategorie->getRaccourci();?>"></div><a href="equipes.php?onglet=<?=$uneCategorie->getRaccourci();?>"><strong><?=$uneCategorie->getCategorie();?> <?=substr($uneCategorie->getGenre(),0,1);?><?=$uneCategorie->getNumero();?></strong></a><?php
																endif; ?>
															</td>
															<td class="score-team2"><?php
																if($unMatch->getJoue()):
																	$score_dom = explode(',', $unMatch->getScores_dom());
																	$score_ext = explode(',', $unMatch->getScores_ext());
																	if($unMatch->getLieu()==0):
																		if(is_array($score_dom) && is_array($score_ext)):
																			for($i=0; $i<count($score_dom); $i++):
																				if($score_dom[$i]>$score_ext[$i]):
																					$color = "vert";
																				elseif($score_dom[$i]<$score_ext[$i]):
																					$color = "rouge";
																				else:
																					$color = "orange";
																				endif;
																				echo "<span class=".$color.">".$score_dom[$i]." - ".$score_ext[$i].'</span><br/>';
																			endfor;
																		else:
																			if($score_dom>$score_ext):
																				$color = "vert";
																			elseif($score_dom<$score_ext):
																				$color = "rouge";
																			else:
																				$color = "orange";
																			endif;	
																			echo "<span class=".$color.">".$score_dom." - ".$score_ext.'</span><br/>';
																		endif;
																	else:
																		if(is_array($score_dom) && is_array($score_ext)):
																			for($i=0; $i<count($score_dom); $i++):
																				if($score_dom[$i]<$score_ext[$i]):
																					$color = "vert";
																				elseif($score_dom[$i]>$score_ext[$i]):
																					$color = "rouge";
																				else:
																					$color = "orange";
																				endif;
																				echo "<span class=".$color.">".$score_dom[$i]." - ".$score_ext[$i].'</span><br/>';
																			endfor;
																		else:
																			if($score_dom<$score_ext):
																				$color = "vert";
																			elseif($score_dom>$score_ext):
																				$color = "rouge";
																			else:
																				$color = "orange";
																			endif;
																			echo "<span class=".$color.">".$score_dom." - ".$score_ext.'</span><br/>';
																		endif;
																	endif;
																else:
																	echo "<span>". $unMatch->remplace_heure() ."</span>";
																endif; ?>
															</td>
															<td><!--<a href="match.php?id=<?=$unMatch->getId();?>"><img src="images/infos.png" alt="infos" width="20px" height="20px" /></a>--></td>
														</tr><?php
														$i++;
														if($i==3) $i=1;
													endforeach;
												else :?>
													<tr>
														<td colspan='8'>Pas de résultats enregistrés pour cette saison.</td>
													</tr><?php
												endif;?>
											</table><?php
										break;
										case 'classements':?>
											<div class="legende">La liste des classements de toutes nos équipes engagées.</div>
											<div class="wrapper pad_bot1"><?php
												$lesClassements = retourne_tous_classements($annee);
												if(!is_array($lesClassements)) {?>
													Pas de classement pour le moment.<?php
												}
												else {
													foreach($lesClassements as $unClassement) {?>
														<div class="unClassement">
															<div class="table">
																<div class="row">
																	<div class="cell cell-1-3"><?=$unClassement['categorie']?></div>
																	<div class="cell cell-1-3">mise à jour : <?=$unClassement['newDate']?></div>
																	<div class="cell cell-1-3"><a href="<?=$unClassement['classement']?>" target="_blank">Lien vers le classement</a></div>
																</div>
															</div>
														</div><?php
													}
												}?>
											</div>
											<?php
										break;
										case 'calendrier':
											$year = retourne_annee();
											$dates = getAll($year);
											$events = getEvents($year);?>
											<div class="periods">
												<div class="year">
													<ul>
														<li><a href="#" id="linkYear<?php echo $year; ?>"><?php echo $year; ?></a></li>
														<li><a href="#" id="linkYear<?php echo $year+1; ?>"><?php echo $year+1; ?></a></li>
													</ul>
												</div>
												<div class="months">
													<ul><?php
														foreach($mois_de_lannee as $id=>$m) {?>
															<li><a href="#" id="linkMonth<?php echo $id+1; ?>"><?php echo substr($m, 0, 3); ?></a></li><?php
														}?>
													</ul>
												</div>
												<div class="clear_b"></div>
												<?php foreach($dates as $m=>$days) {?>
													<div class="month" id="month<?php echo $m ?>">
														<table>
															<thead>
																<tr>
																	<?php foreach($jour_de_la_semaine as $d) {?>
																		<th><?php echo $d;?></th>
																		<?php
																	}?>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<?php
																	$end = end($days);
																	foreach($days as $d=>$w) {
																		if(strlen($m)==1) $new_m = '0'.$m; else $new_m = $m;
																		if(strlen($d)==1) $new_d = '0'.$d; else $new_d = $d;
																		if($m < 7) $new_y = $year+1; else $new_y = $year;
																		$time = $new_y.$new_m.$new_d;
																		if($d == 1 && $w-1 != 0) {?>
																			<td colspan="<?php echo $w-1; ?>"></td><?php
																		}
																		?>
																		<td <?php echo liste_class($d, $m, $w); ?>>
																			<div class="relative">
																				<div class="day"><?php echo $d ;?></div>
																			</div>
																			<div class="daylight"><?php echo date_toutes_lettres($d, $w, $m);?></div>
																			<div class="events">
																				<span class="matchs"><?php
																					if(isset($events[$time])) { echo count($events[$time])." match"; if(count($events[$time])>1) echo "s"; }?>
																				</span>
																				<span class="extra"><?php ?>
																				</span>
																			</div>
																			<div class="laDate"><?php echo $time; ?></div>
																		</td><?php
																		if($w == 7) {?>
																			</tr><tr><?php
																		}
																	}
																	if($end != 7) {?>
																		<td colspan="<?php echo 7-$end; ?>"></td><?php
																	}?>
																</tr>
															</tbody>
														</table>
													</div><?php
												}
												?>
											</div><?php
										break;
										case 'coupe_yvelines':
											$options = array('where' => 'date >= '. $annee_actuelle .'0701 AND date < '. $annee_suiv .'0701 AND competition = 2', 'orderby' => 'categorie');
											$listeMatchs = $MatchManager->retourneListe($options);?>
											<div class="legende">Les résultats en coupe des Yvelines de nos équipes.</div>
											<table id="tab_result"><?php
												if(is_array($listeMatchs)) {
													$i=2;
													$cat = 0;
													foreach($listeMatchs as $unMatch) {
														if($unMatch->getCategorie() != $cat) {
															$uneCategorie = $CategorieManager->retourneById($unMatch->getCategorie());
															$cat = $uneCategorie->getId(); ?>
															<tr>
																<th colspan="4"><?=$uneCategorie->getCategorieAll();?></th>
															</tr><?php
														}
														$unClub = $ClubManager->retourneById($unMatch->getAdversaires());?>
														<tr class="cell<?=$i;?>">
															<td><?=$unMatch->remplace_date(2);?> <?=($unMatch->remplace_heure()!=0)?'&agrave; '. $unMatch->remplace_heure():'';?></td>
															<td><?=$unMatch->getTour();?></td>
															<td><?=$unClub->getRaccourci();?> <?=$unClub->getNumero()?></td>
															<td class="score-team2"><?php
																$score_dom = explode(',', $unMatch->getScores_dom());
																$score_ext = explode(',', $unMatch->getScores_ext());
																?>
															</td>
														</tr><?php
														$i++;
														if($i==3) $i=1;
													}
												}
												else {?>
													<tr>
														<td colspan='4'>Pas de résultats enregistrés pour cette saison.</td>
													</tr><?php
												}?>
											</table>
											<?php
										break;
										case 'coupe_france':
											$options = array('where' => 'date >= '. $annee_actuelle .'0701 AND date < '. $annee_suiv .'0701 AND competition = 3', 'orderby' => 'categorie');
											$listeMatchs = $MatchManager->retourneListe($options);?>
											<div class="legende">Les résultats en coupe des Yvelines de nos équipes.</div>
											<table id="tab_result"><?php
												if(is_array($listeMatchs)) {
													$i=2;
													$cat = "";
													foreach($listeMatchs as $unMatch) {
														if($unMatch->getCategorie() != $cat) {
															$uneCategorie = $CategorieManager->retourneById($unMatch->getCategorie());
															$cat = $uneCategorie->getId(); ?>
															<tr>
																<th colspan="4"><?=$uneCategorie->getCategorieAll();?></th>
															</tr><?php
														}
														$unClub = $ClubManager->retourneById($unMatch->getAdversaires());?>
														<tr class="cell<?=$i;?>">
															<td><?=$unMatch->remplace_date(2);?> <?=($unMatch->remplace_heure()!=0)?'&agrave; '. $unMatch->remplace_heure():'';?></td>
															<td><?=$unMatch->getTour();?></td>
															<td><?=$unClub->getRaccourci();?> <?=$unClub->getNumero()?></td>
															<td class="score-team2"><?php
																$score_dom = explode(',', $unMatch->getScores_dom());
																$score_ext = explode(',', $unMatch->getScores_ext());
																?>
															</td>
														</tr><?php
														$i++;
														if($i==3) $i=1;
													}
												}
												else {?>
													<tr>
														<td colspan='8'>Pas de résultats enregistrés pour cette saison.</td>
													</tr><?php
												}?>
											</table>
											<?php
										break;
										default:
											echo "<div>Pas de données disponibles pour le moment.</div>";
										break;
									} ?>
								</div>
							</div>
						</article>
						<article class="col-sm-4 modules">
							<article>
                                <?php include_once('inc/modules/infos-home.php'); ?>
                            </article>
                            <article>
                                <?php // include_once('inc/modules/qui-en-ligne-home.php'); ?>
                            </article>
                            <article>
                                <?php include_once('inc/partenaires.php'); ?>
                            </article>
						</article>
					</div>
				</div>
			</section>
			<footer>
				<?php include_once('inc/footer.php'); ?>
			</footer>
			<div id="fond" class="fond_transparent"></div>
		</div>
		<?php include_once('inc/script.php'); ?>
		<script>
			$(function() {
				$( ".periods td" ).click(function( event ) {
					if($( event.target ).is( '.events span' )) {
						location.href = "evenements.php?date="+$( this ).find('.laDate').text();
					}
				});
			});
		</script>
	</body>
</html>