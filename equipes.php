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
	$filAriane = array('home', $titre_page);
	$bilan = "";

	// On inclue la page de connexion à la BDD
	include_once("inc/connexion_bdd_pdo.php");
	require_once("inc/connexion_bdd.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");
	// include_once("inc/connexion.php");
	
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
				'raccourci' => $onglet,
				'categorie' => $laCategorie->getCategorie(),
				'genre' => $laCategorie->getGenre()
			);
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
                                        <h3>Fiche équipe</h3>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="photo_groupe">
                                                    <img src='images/equipe_lambda.png' alt='Lambda' width='100%' />
                                                </div>
                                            </div>
                                            <div class="col-sm-9 infos">
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
                                                        <ul class="list1"><?php
                                                            $tag = $laCategorie->getRaccourci();
                                                            $options = array('where' => 'tags LIKE "%'.$tag.'%" AND date_publication > '.$annee_actuelle.'0701', 'limit' => '0, 5');
                                                            $listeActu = $ActualiteManager->retourneListe($options);
                                                            // debug($listeActu);
                                                            if(is_array($listeActu)):
                                                                foreach($listeActu as $uneActu) :?>
                                                                    <li <?php if($uneActu->getImportance()) echo 'class="news_importante"'; ?>>
                                                                        <a href="actualites.php?id=<?=$uneActu->getId();?>">
                                                                            <span class="news_date"><?=$uneActu->dateTypeNews();?></span> <?=$uneActu->getTitre();?>
                                                                        </a>
                                                                    </li><?php
                                                                endforeach;
                                                            else: ?>
                                                                <li>Pas d'info pour le moment</li><?php
                                                            endif; ?>
                                                        </ul>
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
                                    <?php
                                    // var_dump($laCategorie->getId(), $annee_actuelle, $annee_suiv);
                                    $options = array('where' => 'categorie = '. $laCategorie->getId() .' AND date > '. $annee_actuelle .'0701 AND date < '. $annee_suiv .'0630', 'orderby' => 'date, heure');
                                    $listeMatchs = $MatchManager->retourneListe($options);
                                    // debug($listeMatchs);
                                    if(!empty($listeMatchs)):?>
                                        <div class="calendrier">
                                            <div class="wrapper">
                                                <h3>calendrier & résultats</h3>
                                                <table class="table"><?php
                                                    $k=2;
                                                    $mois = '';
                                                    foreach($listeMatchs as $unMatch): /*
                                                        if(intval(substr($unMatch->getDate(),4,2))-1 != $mois) {?>
                                                            <tr>
                                                                <th colspan='6'><?=$mois_de_lannee[intval(substr($unMatch->getDate(),4,2))-1];?> <?=substr($unMatch->getDate(),0,4);?></th>
                                                            </tr><?php
                                                        }*/ ?>
                                                        <tr>
                                                            <td class="laDate">
                                                                <div class="tr2">
                                                                    <div class="td0">
                                                                        <div class="jour"><?=intval(substr($unMatch->getDate(),6,2));?></div>
                                                                        <div class="mois"><?=$mois_de_lannee_min[intval(substr($unMatch->getDate(),4,2))-1];?></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="competition">
                                                                <div class="competition_<?=$unMatch->getCompetition();?>_<?=$unMatch->getNiveau();?>">
                                                                    <?=$listeCompetition[$unMatch->getCompetition()];?>
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
                                                                            echo "<strong>Ach&egrave;res</strong><br/>";
                                                                            echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero().'<br/>';
                                                                            echo '</div>';
                                                                        endforeach;
                                                                    else:
                                                                        $unClub = $ClubManager->retourne($club);
                                                                        echo '<div>';
                                                                        echo "<strong>Ach&egrave;res</strong><br/>";
                                                                        echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero();
                                                                        echo '</div>';
                                                                    endif; ?>
                                                                </td>
                                                                <td class="score"><?php
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
                                                                        echo "<span>". $unMatch->remplace_heure() ."</span>";
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
                                                                            echo "<strong>Ach&egrave;res</strong>";
                                                                            echo '</div>';
                                                                        endforeach;
                                                                    else:
                                                                        $unClub = $ClubManager->retourne($club);
                                                                        echo '<div>';
                                                                        echo $unClub->getRaccourci()." ".$unClub->getNumero();
                                                                        echo "<strong>Ach&egrave;res</strong>";
                                                                        echo '</div>';
                                                                    endif; ?>
                                                                </td>
                                                                <td class="score"><?php
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
                                                                        echo "<span>". $unMatch->remplace_heure() ."</span>";
                                                                    endif; ?>
                                                                </td><?php
                                                            endif; ?>
                                                        </tr><?php
                                                        $k++;
                                                        if($k==3) $k=1;
                                                        $mois = intval(substr($unMatch->getDate(),4,2))-1;
                                                    endforeach;?>
                                                </table>
                                            </div>
                                        </div><?php
                                    endif;
                                    $options = array('where' => 'categorie = '.$laCategorie->getId());
                                    $listeJoueurs = $JoueurManager->retourneListe($options);
                                    if(!empty($listeJoueurs) && false) { ?>
                                        <div class="wrapper">
                                            <h3>joueurs</h3>
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
                                    }
                                    $listeStats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle);
                                    if(!empty($listeStats)) {?>
                                        <div class="wrapper">
                                            <h3>statistiques</h3>
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
                                            </div>
                                        </div><?php
                                    }?>
                            </article><?php
                        else: ?>
                            <article class="liste_equipe col-sm-8">
                                <div class="contenu">
                                    <h2><i class="fa fa-users" aria-hidden="true"></i><?=$titre?></h2>
                                    <div class="wrapper"><?php
                                        $options = array('where' => 'annee = '. $annee_actuelle, 'orderby' => 'niveau');
                                        $listeEquipe = $EquipeManager->retourneListe($options);
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
                                                // $serie = cinq_dernier_match($laCategorie->getRaccourci(), $annee_actuelle);

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
                                                            <p><strong>Championnat :</strong><?=$listeChampionnat[$uneEquipe->getChampionnat()];?></p>
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
			$(document).ready(function() {
				// $.jqplot.config.enablePlugins = true;
				<?php
					$liste_stats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle);
					if(!empty($liste_stats)) {
						echo "var data1 = [";
						echo "['Victoires', ". $liste_stats['nb_vic'] ."],";
						echo "['Nuls', ". $liste_stats['nb_nul'] ."],";
						echo "['D&eacute;faites', ". $liste_stats['nb_def'] ."]";
						echo "];";
						?>
						var nbr_match = <?=$liste_stats['nb_vic'];?> + <?=$liste_stats['nb_nul'];?> + <?=$liste_stats['nb_def'];?>;
						var plot2 = $.jqplot('chartdiv1', [data1], {
							seriesColors:['#009933', '#FFA319', '#FF3333'],
							seriesDefaults: {
						        // Make this a donut chart.
						        renderer: $.jqplot.DonutRenderer, 
						        rendererOptions: {
						            showDataLabels: true,
						           	startAngle: -90,
						            dataLabels: 'value',
									//dataLabelFormatString: "%d",
						        }
						    },
						    grid: {
					            backgroundColor: 'transparent',
					            borderWidth: 0,
					            shadow:false,
					        },
					        legend: { 
					        	show: true,
					        	location: 'e',
					        	fontSize: '12px',
					        	border: 'none',
					        },
					        // title: "<span>" + nbr_match + "</span> matchs disput&eacute;s",
						});<?php
					}
				?>
			});
		</script>
	</body>
</html>