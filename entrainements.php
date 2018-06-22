<?php
	// On inclue la page de connexion à la BDD
	include_once("inc/init_session.php");
	include_once("inc/connexion_bdd_pdo.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");

	// Initialisation des variables
	$page = 'entrainements';
	$titre_page = 'entrainements';
	$filAriane = array(
        'home',
        array(
            'url' => $page,
            'libelle' => $titre_page
        ),
        array(
            array(
                'url' => 'horaires_entrainement',
                'libelle' => 'Horaires'
            ),
            array(
                'url' => 'gymnases',
                'libelle' => 'Gymnases'
            )
        )
    );
	
	// Initialisation des managers
	$HoraireManager = new HoraireManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	
	if(isset($_GET['onglet']))
		$onglet = $_GET['onglet']; // On récupère la catégorie de staff choisi
	else
		$onglet = 'horaires_entrainement'; // Par défaut

	switch($onglet) {
		case 'gymnases':
			$titre = 'Les gymnases';
		break;
		case 'horaires_entrainement':
		default:
			$titre = 'Les horaires d\'entrainement';
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
		<main class="<?=$page;?>">
			<section id="content">
				<?php include_once('inc/fil_ariane.php'); ?>
				<div class="container">
                    <div class="row">
                        <article class="col-sm-8">
                            <div class="contenu">
                                <h2><i class="fa fa-clock-o" aria-hidden="true"></i><?=$titre?></h2>
                                <div class="wrapper"><?php
                                    switch($onglet):
                                        case "gymnases":
                                            include_once('inc/parts/entrainements/gymnases.php');
                                        break;
                                        case "horaires_entrainement":
                                        default:
                                            include_once('inc/parts/entrainements/horaires_entrainement.php');
                                        break;
                                    endswitch; ?>
                                </div>
                            </div>
                        </article>
                        <article class="col-sm-4 modules">
                            <?php include_once('inc/modules/infos-home.php'); ?>
                            <?php include_once('inc//modules/partenaires.php'); ?>
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