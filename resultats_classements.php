<?php
	// On inclue la page de connexion à la BDD
	include_once("inc/init_session.php");
	include_once("inc/connexion_bdd_pdo.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");

	// Initialisation des variables
	$page = 'resultats_classements';
	$titre_page = 'resultats & classements';
	$titre = 'Les r&eacute;sultats & classements';
	$filAriane = array(
        'home',
        array(
			'url' => $page,
			'libelle' => $titre_page
		),
        array(
            array(
                'url' => 'calendrier',
                'libelle' => 'Calendrier'
            ),
            array(
                'url' => 'matchs_a_venir',
                'libelle' => 'Matchs à venir'
            ),
            array(
                'url' => 'resultats_week-end',
                'libelle' => 'Résultats de la semaine'
            ),
            array(
                'url' => 'classements',
                'libelle' => 'Classements'
            ),
            array(
                'url' => 'coupe_yvelines',
                'libelle' => 'CDY'
            ),
            array(
                'url' => 'coupe_france',
                'libelle' => 'CDF'
            )
        )
    );
	$annee = retourne_annee();
	
	// Initialisation des managers
	$CategorieManager = new CategorieManager($connexion);
	$MatchManager = new MatchManager($connexion);
	$ClubManager = new ClubManager($connexion);	
	
	if(isset($_GET['onglet'])):
		$onglet = $_GET['onglet']; // On récupère la catégorie de staff choisi
	else:
		$onglet = 'calendrier'; // Par défaut
    endif;
	
	switch($onglet):
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
		case 'calendrier':
		default:
			$titre = 'Le calendrier général';
		break;
	endswitch;
	
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
					<div class="row">
						<article class="col-sm-8">
							<div class="contenu">
								<h2><i class="fa fa-calendar" aria-hidden="true"></i><?=$titre?></h2>
								<div class="wrapper">
									<?php
									switch($onglet):
										case 'matchs_a_venir':
				                            include_once('inc/parts/resultats_classements/matchs_a_venir.php');
										break;
										case 'resultats_week-end':
				                            include_once('inc/parts/resultats_classements/resultats_weekend.php');
										break;
										case 'classements':
				                            include_once('inc/parts/resultats_classements/classements.php');
										break;
										break;
										case 'coupe_yvelines':
				                            include_once('inc/parts/resultats_classements/coupe_yvelines.php');
										break;
										case 'coupe_france':
				                            include_once('inc/parts/resultats_classements/coupe_france.php');
										break;
										case 'calendrier':
										default:
				                            include_once('inc/parts/resultats_classements/calendrier.php');
										break;
									endswitch; ?>
								</div>
							</div>
						</article>
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
	</body>
</html>