<?php
	session_start();

	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On définit les variables
	$page = 'index';

	// On inclue la page de connexion à la BDD
	require_once("inc/connexion_bdd_pdo.php");
	// require_once("inc/connexion_bdd.php");
	require_once("inc/fonctions.php");
	require_once("inc/date.php");
	require_once("inc/constantes.php");
	// require_once("inc/connexion.php");
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
			<section class="home">
				<nav class="nav-home hidden">
					<ul>
						<li><a href="boutique.php">Boutique</a></li>
						<li><a href="resultats_classements.php?onglet=calendrier">Calendrier</a></li>
					</ul>
				</nav>
				<div class="slider-home">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php include_once('inc/modules/slider-home.php'); ?>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="modules">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6 col-lg-8">
                                <?php include_once('inc/modules/tableau-bord-home.php'); ?>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <?php include_once('inc/modules/infos-home.php'); ?>
                            </div>
                            <div class="col-sm-4">
                                <?php include_once('inc/modules/phototheque-home.php'); ?>
                            </div>
							<div class="col-sm-4">
                                <?php include_once('inc/modules/videotheque-home.php'); ?>
                            </div>
                            <div class="col-sm-4">
                                <?php include_once('inc/modules/liens-utiles-home.php'); ?>
                            </div>
							<div class="col-sm-4">
                                <?php include_once('inc/modules/fil-twitter-home.php'); ?>
                            </div>
							<div class="col-sm-4">
                                <?php include_once('inc/modules/facebook-home.php'); ?>
                            </div>
						</div>
					</div>
				</div>
			</section>
			<footer>
				<?php include_once('inc/footer.php'); ?>
			</footer>
			<div id="fond" class="fond_transparent"></div>
		</div>
		<?php include_once('inc/script.php'); ?>
	</body>
</html>