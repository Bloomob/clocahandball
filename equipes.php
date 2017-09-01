<?php 
	session_start();
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// initialisation des variables
	$page = 'equipes';
	$titre_page = 'equipes';
	$titre = 'Les &eacute;quipes';
	$filAriane = array(
		'home',
		array(
			'url' => $page,
			'libelle' => $titre_page
		)
	);
	$bilan = "";

	// On inclue la page de connexion à la BDD
	include_once("inc/connexion_bdd_pdo.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");
	
	// Initialisation des managers
	$ActualiteManager = new ActualiteManager($connexion);
	$EquipeManager = new EquipeManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	$HoraireManager = new HoraireManager($connexion);
	$MatchManager = new MatchManager($connexion);
	$ClubManager = new ClubManager($connexion);
	$JoueurManager = new JoueurManager($connexion);

	if(isset($_GET['onglet'])) {
		$onglet = $_GET['onglet'];

		$options = array('where' => 'raccourci LIKE "'.$onglet.'"');
		$laCategorie = $CategorieManager->retourne($options);
		// debug($laCategorie);

		if($laCategorie->getId() == 0)
			header('Location: '.$page.'.php');

		$titre = 'Les '.$laCategorie->getCategorieAll();
		$options = array('where' => 'categorie = '. $laCategorie->getId() .' AND annee = '. $annee_actuelle);
		$detailsEquipe = $EquipeManager->retourne($options);
		// debug($detailsEquipe);
		
		if($detailsEquipe->getActif()) {
			$filAriane[2] = array(
				'url' => $onglet,
				'libelle' => $laCategorie->getCategorie()
			);
			$filAriane[3] = '';
		}
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
					<div class="row"><?php
						if(isset($filAriane[2])): ?>
							<article class="details_equipe col-sm-8">
								<div class="contenu">
									<h2><i class="fa fa-users" aria-hidden="true"></i><?=$titre?></h2>
									<div class="wrapper">
										<ul class="nav nav-tabs" role-list="tablist">
											<li role="presentation" class="active">
												<a href="#resume" aria-controls="resume" role="tab" data-toggle="tab"><i class="fa fa-info" aria-hidden="true"></i>Résumé</a>
											</li>
											<li role="presentation">
												<a href="#calendrier" aria-controls="calendrier" role="tab" data-toggle="tab"><i class="fa fa-calendar" aria-hidden="true"></i>Calendrier</a>
											</li>
											<li role="presentation">
												<a href="#joueurs" aria-controls="joueurs" role="tab" data-toggle="tab"><i class="fa fa-male" aria-hidden="true"></i>Effectif</a>
											</li>
											<li role="presentation">
												<a href="#statistiques" aria-controls="statistiques" role="tab" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i>Statistiques</a>
											</li>
										</ul>
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane fade in active" id="resume">
												<div class="row">
													<div class="col-xs-12"><?php
                                                        if($detailsEquipe->getId_photo_equipe()):?>
                                                            <div class="photo_groupe">
                                                                <img src='images/equipe_lambda.png' alt='Lambda' width='100%' />
                                                            </div><?php
                                                        endif;?>
													</div>
													<div class="col-sm-12 infos marginT">
														<div class="bloc">
															<?php  ?>
															<h4><i class="fa fa-search" aria-hidden="true"></i>L'&eacute;quipe &agrave; la loupe</h4>
															<div class="row">
																<div class="col-sm-4">Niveau</div>
																<div class="col-sm-8"><?=$listeNiveau[$detailsEquipe->getNiveau()];?></div>
															</div>
															<div class="row">
																<div class="col-sm-4">Championnat</div><?php
																$championnat = $listeChampionnat[$detailsEquipe->getChampionnat()]; ?>
																<div class="col-sm-8"><?=($championnat)?$championnat:'D&eacute;layage';?></div>
															</div>
															<div class="row">
																<div class="col-sm-4">Entraineurs</div>
																<div class="col-sm-8"><?php
																$tab = explode(',', $detailsEquipe->getEntraineurs());
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
																<div class="col-sm-4">Entrainements</div>
																<div class="col-sm-8"><?php
																$tab = explode(',', $detailsEquipe->getEntrainements());
																if(is_array($tab)):
																	foreach($tab as $entrainement):
																	$options = array('where' => 'id = '. $entrainement);
																		$unHoraire = $HoraireManager->retourne($options);
																		echo $jours[$unHoraire->getJour()].' de '.$unHoraire->remplace_heure($unHoraire->getHeure_debut()).' &agrave; '.$unHoraire->remplace_heure($unHoraire->getHeure_fin()).' ('. $gymnases[$unHoraire->getGymnase()] .')<br/>';
																	endforeach;
																endif; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-sm-4">Bilan</div>
																<div class="col-sm-8"><?php
																	$liste_stats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle);
																	if(!empty($liste_stats)):
																		$bilan = '<span class="vert">'.$liste_stats['nb_vic'].'V</span> <span class="orange">'.$liste_stats['nb_nul'].'N</span> <span class="rouge">'.$liste_stats['nb_def'].'D</span>';
																	endif; ?>
																	<?=$bilan;?>
																</div>
															</div>
															<div class="row">
																<div class="col-sm-4">S&eacute;rie</div>
																<div class="col-sm-8"><?php
																	$serie = $MatchManager->cinq_derniers_matchs($laCategorie->getId());?>
																	<?=$serie;?>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="marginT">
													<div class="row">
														<div class="col-sm-6 dernieres_actus">
															<div class="bloc">
																<h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Les dernières actus</h4>
																<?php
																$tag = $laCategorie->getRaccourci();
																$options = array('where' => 'tags LIKE "%'.$tag.'%" AND date_publication > '.$annee_actuelle.'0701', 'limit' => '0, 5');
																$listeActu = $ActualiteManager->retourneListe($options);
																// debug($listeActu);
																if(!empty($listeActu)):?>
														            <ul><?php
														                foreach($listeActu as $uneActu):?>
														                    <li>
														                        <a href="actualites.php?id=<?=$uneActu->getId();?>" class="puce<?=($uneActu->getImportance() == 1) ? ' important' : '';?>">
														                            <span class="date-info"><?=$uneActu->dateTypePublicationNews();?></span><?=$uneActu->getTitre();?>
														                        </a>
														                    </li>
														                    <?php
														                endforeach;?>
														            </ul><?php
														        else: ?>
														            <p>Pas d'actualité pour le moment</p><?php
														        endif?>
															</div>
														</div>
														<div class="col-sm-6 saison_passee">
															<div class="bloc">
																<h4><i class="fa fa-line-chart" aria-hidden="true"></i>La saison passee</h4><?php
																$liste_stats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle-1);
																if(is_array($liste_stats)) {?>
																	<p>Nombre de victoires : <?=$liste_stats['nb_vic'];?></p>
																	<p>Nombre de nuls : <?=$liste_stats['nb_nul'];?></p>
																	<p>Nombre de défaites : <?=$liste_stats['nb_def'];?></p>
																	<p>Nombre de buts pour : <?=$liste_stats['nb_bp'];?></p>
																	<p>Nombre de buts contre : <?=$liste_stats['nb_bc'];?></p><?php
																}
																else { ?>
																	<p>Pas de statistique sur la saison derni&egrave;re</p><?php
																}?>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane" id="calendrier"><?php
												// var_dump($laCategorie->getId(), $annee_actuelle, $annee_suiv);
												$options = array('where' => 'categorie = '. $laCategorie->getId() .' AND date > '. $annee_actuelle .'0701 AND date < '. $annee_suiv .'0630', 'orderby' => 'date, heure');
												$listeMatchs = $MatchManager->retourneListe($options);
												// debug($listeMatchs);
												if(!empty($listeMatchs)):?>
													<div class="calendrier">
														<div class="wrapper"><?php
															if(!empty($listeMatchs)):
													            foreach($listeMatchs as $unMatch): ?>
													                <div class="row">
													                    <div class="col-sm-2 col-lg-2 date">
													                        <div class="jour"><?=$unMatch->getJour();?></div>
													                        <div class="mois"><?=$mois_de_lannee_min[$unMatch->getMois()-1];?></div>
													                    </div>
													                    <div class="col-sm-2">
													                        <div class="compet competition_<?=$unMatch->getCompetition();?>_<?=$unMatch->getNiveau();?>">
													                            <span><?=($unMatch->getJournee()!=0)?'J'.$unMatch->getJournee():$unMatch->getTour();?></span>
													                        </div>
													                    </div><?php
													                    $options2 = array('where' => 'id = '. $unMatch->getCategorie());
													                    $uneCategorie = $CategorieManager->retourne($options2);
													                    if($unMatch->getLieu() == 0):?>
													                        <div class="col-sm-6 col-lg-6">
													                            <div class="dom puce"><div class="cat_<?=$uneCategorie->getRaccourci();?>"></div><a href="equipes.php?onglet=<?=$uneCategorie->getRaccourci();?>"><strong><?=$uneCategorie->getCategorie();?> <?=substr($uneCategorie->getGenre(),0,1);?><?=$uneCategorie->getNumero();?></strong></a></div>
													                            <div class="ext"><?php
													                                $tab = explode(',', $unMatch->getAdversaires());
													                                if(is_array($tab) ):
													                                    foreach($tab as $key => $club):
													                                        if($key > 0) { echo " - "; }
													                                        $unClub = $ClubManager->retourne($club);
													                                        echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero();
													                                    endforeach;
													                                endif; ?>
													                            </div>
													                        </div><?php
													                    else: ?>
													                        <div class="col-sm-6 col-lg-6">
													                            <div class="dom"><?php
													                                $tab = explode(',', $unMatch->getAdversaires());
													                                if(is_array($tab)):
													                                    foreach($tab as $key => $club):
													                                        if($key > 0) { echo " - "; }
													                                        $unClub = $ClubManager->retourne($club);
													                                        echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero();
													                                    endforeach;
													                                endif; ?>
													                            </div>
													                            <div class="ext puce"><div class="cat_<?=$uneCategorie->getRaccourci();?>"></div><a href="equipes.php?onglet=<?=$uneCategorie->getRaccourci();?>"><strong><?=$uneCategorie->getCategorie();?> <?=substr($uneCategorie->getGenre(),0,1);?><?=$uneCategorie->getNumero();?></strong></a></div>
													                        </div><?php
													                    endif; ?>
													                    <div class="col-sm-2 heure"><span><?=$unMatch->remplace_heure()?></span></div>
													                    <!-- <div class="col-sm-2">
													                        <span><a href="#"><i class="fa fa-flag" aria-hidden="true"></i></a></span>
													                    </div> -->
													                </div><?php
													            endforeach;
													        else: ?>
													            <p>Pas de match pr&eacute;vu pour le moment</p><?php
													        endif; ?>
														</div>
													</div><?php
												endif;?>
											</div>
											<div role="tabpanel" class="tab-pane" id="joueurs"><?php
												$options = array('where' => 'categorie = '.$laCategorie->getId());
												$listeJoueurs = $JoueurManager->retourneListe($options);
												if(!empty($listeJoueurs) && false): ?>
													<div class="wrapper">
														<div id="tab_joueur"><?php
															$k=2;
															$poste = 0;
															foreach($listeJoueurs as $unJoueur) {
																if($unJoueur->getPoste() != $poste) {?>
																	<div class="clear_b"></div>
																	<div class="titre_poste"><?=$postes[$unJoueur->getPoste()];?></div><?php
																}
																$unUtilisateur = $UtilisateurManager->retourneById($unJoueur->getId_utilisateur());
																?>
																<div class="ligne_joueur">
																	<div class="left"><img src="images/inconnu.gif" alt="Lambda" width="100px" /><?//=$unJoueur->getPhoto();?></div>
																	<div>
																		<div class="result"><?=$unUtilisateur->getNom();?></div>
																	</div>
																	<div>
																		<div class="result"><?=$unUtilisateur->getPrenom();?></div>
																	</div>
																	<div>
																		<div class="result"><?=$unJoueur->getDate_naissance();?></div>
																	</div><?php /*
																	<div>
																		<div class="result"><?=$unJoueur['matchs_joues'];?> match</div>
																	</div>*/?>
																	<div class="maillot">
																		<img src="images/petit_maillot.jpg" alt="maillot" width="50px">
																		<span class="petit_maillot"><?=$unJoueur->getNumero();?></span>
																	</div>
																</div><?php
																$k++;
																if($k==3) $k=1;
																$poste = $unJoueur->getPoste();
															}?>
														</div>
													</div><?php
												endif;?>
											</div>
											<div role="tabpanel" class="tab-pane" id="statistiques"><?php
												$listeStats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle);
												if(!empty($listeStats)):?>
													<div class="marginT">
														<div class="row">
															<div class="col-sm-6 bilan_matchs">
																<div id="chartdiv1"></div>
															</div>
															<div class="col-sm-6 stats_buts"><?php
																$liste_stats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle);
																// debug($liste_stats);?>
																<div class="buts_pour clear_b">
																	<h4>Buts marqu&eacute;s</h4>
																	<div class="total_buts_pour"><?=$liste_stats['nb_bp'];?></div>
																	<div class="total_buts_pour_dom">Domicile : <strong><?=$liste_stats['nb_bp_dom'];?></strong></div>
																	<div class="total_buts_pour_ext">Exterieur : <strong><?=$liste_stats['nb_bp_ext'];?></strong></div>
																</div>
																<div class="buts_contre clear_b">
																	<h4>Buts encaiss&eacute;s</h4>
																	<div class="total_buts_contre"><?=$liste_stats['nb_bc'];?></div>
																	<div class="total_buts_contre_dom">Domicile : <strong><?=$liste_stats['nb_bc_dom'];?></strong></div>
																	<div class="total_buts_contre_ext">Exterieur : <strong><?=$liste_stats['nb_bc_ext'];?></strong></div>
																</div>
																<div class="<?=($liste_stats['nb_bp']-$liste_stats['nb_bc']>0)?'buts_diff_pos':'buts_diff_neg';?> clear_b">
																	<h4>Diff&eacute;rence de buts</h4>
																	<div class="total_buts_diff"><?=($liste_stats['nb_bp']-$liste_stats['nb_bc']>0)?'+':'';?><?=$liste_stats['nb_bp']-$liste_stats['nb_bc'];?></div>
																	<div class="total_buts_diff_dom">Domicile : <strong><?=($liste_stats['nb_bp']-$liste_stats['nb_bc']>0)?'+':'';?><?=$liste_stats['nb_bp_dom']-$liste_stats['nb_bc_dom'];?></strong></div>
																	<div class="total_buts_diff_ext">Exterieur : <strong><?=($liste_stats['nb_bp']-$liste_stats['nb_bc']>0)?'+':'';?><?=$liste_stats['nb_bp_ext']-$liste_stats['nb_bc_ext'];?></strong></div>
																</div>
															</div>
														</div>
													</div><?php
												endif;?>
											</div>
										</div>
									</div>
								</div>
							</article><?php
						else: ?>
							<article class="liste_equipe col-sm-8">
								<div class="contenu">
									<h2><i class="fa fa-users" aria-hidden="true"></i><?=$titre?></h2>
									<div class="wrapper"><?php
										$options = array('where' => 'annee = '. $annee_actuelle, 'orderby' => 'niveau, championnat');
										$listeEquipe = $EquipeManager->retourneListe($options);
                                        // debug($listeEquipe);
										if(!empty($listeEquipe)) {
											$i = 0;
											$niveau_actuel = '';
											foreach($listeEquipe as $uneEquipe):
												$options = array('where' => 'id = '.$uneEquipe->getCategorie());
												$laCategorie = $CategorieManager->retourne($options);

												$liste_stats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle);
												if(!empty($liste_stats)):
													$bilan = '<span class="vert">'.$liste_stats['nb_vic'].'V</span> <span class="orange">'.$liste_stats['nb_nul'].'N</span> <span class="rouge">'.$liste_stats['nb_def'].'D</span>';
												endif;

												/*$liste_stats = liste_stats($laCategorie->getRaccourci(), $annee_actuelle);
												if(is_array($liste_stats)) {

												}*/

												$serie = $MatchManager->cinq_derniers_matchs($laCategorie->getId());

												if($uneEquipe->getNiveau() != $niveau_actuel):
													if($i>0):?>
														</div><?php
													endif;?>
													<h3>Niveau <?=$listeNiveau[$uneEquipe->getNiveau()];?></h3>
													<div class="row"><?php
												elseif($i%2 == 0) :?>
													</div>
													<div class="row marginT"><?php
												endif;?>
												<div class="col-sm-6">
													<div class="bloc <?=$laCategorie->getRaccourci();?>">
														<h4><a href="?onglet=<?=$laCategorie->getRaccourci();?>"><?=$laCategorie->getCategorieAll();?></a></h4>
														<div class="pad">
															<p><strong>Championnat : </strong><?=$listeChampionnat[$uneEquipe->getChampionnat()];?></p>
															<p><strong>Série : </strong><?=$serie;?></p>
															<p><strong>Bilan : </strong><?=$bilan;?></p>
														</div>
													</div>
												</div><?php
												$niveau_actuel = $uneEquipe->getNiveau();
												$i++;
											endforeach;
											if($i%2==1):?>
												<div class="col-sm-6"></div><?php
											endif; ?>
											</div><?php
										}?>
									</div>
								</div>
							</article><?php
						endif; ?>
					   <article class="col-sm-4 modules">
							<article>
								<?php include_once('inc/modules/infos-home.php'); ?>
							</article>
							<article>
								<?php // include_once('inc/modules/qui-en-ligne-home.php'); ?>
							</article>
							<article>
								<?php include_once('inc/modules/partenaires.php'); ?>
							</article>
						</article>
					</div>
				</div>
			</section>
			<footer>
				<?php include_once('inc/footer.php'); ?>
			</footer>
		</div>
		<?php include_once('inc/script.php'); ?>
	</body>
</html>