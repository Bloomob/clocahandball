<?php
	// On initialise et on charge les fonctions
	require_once("inc/init_session.php");
	require_once("inc/connexion_bdd_pdo.php");
	require_once("inc/fonctions.php");
	require_once("inc/date.php");
	require_once("inc/constantes.php");

	// On définit les variables
	$page = 'index';
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
		<main class="home">
            <section class="slider-home">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php include_once('inc/modules/slider-home.php'); ?>
                        </div>
                    </div>
                </div>
            </section>
            <section class="modules">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-8">
                            <?php include_once('inc/modules/favoris-home.php'); ?>
                            <?php include_once('inc/modules/tableau-bord-home.php'); ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php include_once('inc/modules/phototheque-home.php'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <?php include_once('inc/modules/videotheque-home.php'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <?php include_once('inc/modules/infos-home.php'); ?>
                            <?php include_once('inc/modules/facebook-home.php'); ?>
                            <?php include_once('inc/modules/liens-utiles-home.php'); ?>
                        </div>
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