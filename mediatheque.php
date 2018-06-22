<?php 
    // On inclue la page de connexion à la BDD
	include_once("inc/init_session.php");
	include_once("inc/connexion_bdd_pdo.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");

	// initialisation des variables
	$page = 'mediatheque';
	$titre_page = 'mediatheque';
	$titre = 'La médiatheque';
	$filAriane = array(
		'home',
		array(
			'url' => $page,
			'libelle' => $titre_page
		)
	);
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
                                <h2><i class="fa fa-users" aria-hidden="true"></i><?=$titre?></h2>
                                <div class="wrapper">
                                    <p>La page est en constuction.</p>
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