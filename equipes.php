<?php
	// On inclue la page de connexion à la BDD
	include_once("inc/init_session.php");
	include_once("inc/connexion_bdd_pdo.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");

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
	
	// Initialisation des managers
	$ActualiteManager = new ActualiteManager($connexion);
	$EquipeManager = new EquipeManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	$HoraireManager = new HoraireManager($connexion);
	$MatchManager = new MatchManager($connexion);
	$ClubManager = new ClubManager($connexion);
	$JoueurManager = new JoueurManager($connexion);

	if(isset($_GET['onglet'])):
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
		
		if($detailsEquipe->getActif()):
			$filAriane[2] = array(
				'url' => $onglet,
				'libelle' => $laCategorie->getCategorie()
			);
			$filAriane[3] = '';
       endif;
	endif;
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
		<main class="<?=$page;?>">
			<section id="content">
				<?php include_once('inc/fil_ariane.php'); ?>
				<div class="container">
					<div class="row"><?php
						if(isset($filAriane[2])): ?>
							<article class="details_equipe col-sm-8">
								<div class="contenu">
									<h2><i class="fa fa-users" aria-hidden="true"></i><?=$titre?></h2>
									<div class="wrapper">
										<ul class="nav nav-tabs" role-list="tablist">
											<li role="resume" class="active">
												<a href="#resume" aria-controls="resume" role="tab" data-toggle="tab" class="resume"><i class="fa fa-info" aria-hidden="true"></i>Résumé</a>
											</li>
											<li role="calendrier">
												<a href="#calendrier" aria-controls="calendrier" role="tab" data-toggle="tab" class="calendrier"><i class="fa fa-calendar" aria-hidden="true"></i>Calendrier</a>
											</li>
											<li role="joueurs">
												<a href="#joueurs" aria-controls="joueurs" role="tab" data-toggle="tab" class="joueurs"><i class="fa fa-male" aria-hidden="true"></i>Effectif</a>
											</li>
											<li role="statistiques">
												<a href="#statistiques" aria-controls="statistiques" role="tab" data-toggle="tab" class="statistiques"><i class="fa fa-line-chart" aria-hidden="true"></i>Statistiques</a>
											</li>
										</ul>
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane fade in active" id="resume">
												<?php include_once('inc/parts/equipes/resume.php'); ?>
											</div>
											<div role="tabpanel" class="tab-pane" id="calendrier">
											    <?php include_once('inc/parts/equipes/calendrier.php'); ?>
											</div>
											<div role="tabpanel" class="tab-pane" id="joueurs">
											    <?php include_once('inc/parts/equipes/joueurs.php'); ?>
											</div>
											<div role="tabpanel" class="tab-pane" id="statistiques">
											    <?php include_once('inc/parts/equipes/statistiques.php'); ?>
											</div>
										</div>
									</div>
								</div>
							</article><?php
						else:
							include_once('inc/parts/equipes/liste.php');
						endif; ?>
					   <article class="col-sm-4 modules">
                            <?php include_once('inc/modules/infos-home.php'); ?>
                            <?php include_once('inc/modules/partenaires.php'); ?>
						</article>
					</div>
				</div>
			</section>
		</main>
        <footer>
            <?php include_once('inc/footer.php'); ?>
        </footer>
		<?php include_once('inc/script.php'); ?>
		
		<script type="text/javascript">
			$(function() {
                <?php
				$liste_stats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle);
                
                if(!empty($liste_stats)): ?>
                    $.jqplot.config.enablePlugins = true;
                    var data = [['Victoires', <?=$liste_stats['nb_vic'];?>], ['Nuls', <?=$liste_stats['nb_nul'];?>], ['Défaites', <?=$liste_stats['nb_def'];?>]];
                    var nbr_match = <?=$liste_stats['nb_vic'] + $liste_stats['nb_nul']+ $liste_stats['nb_def'];?>;

                    var plot = $.jqplot('chart', [data], {
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
                            location: 's',
                            fontSize: '16px',
                            border: 'none',
                        },
                        // title: "<span>" + nbr_match + "</span> matchs disput&eacute;s",
                    });<?php
                endif;?>
                $('ul.nav-tabs .statistiques').on('shown.bs.tab', function(event) {
                    if (plot._drawCount === 0) {
                        plot.replot();
                    }
                });
		   });
		</script>
	</body>
</html>