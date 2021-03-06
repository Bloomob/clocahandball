<?php 

	session_start();

	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// Initialisation des variables
	$page = 'contact';
	$titre = 'Nous contacter';
	$titre_page = 'contact';
	$filAriane = array(
		'home',
		array(
			'url' => $page,
			'libelle' => $titre_page
		)
	);
	
	// On inclue la page de connexion à la BDD
	include_once("inc/connexion_bdd_pdo.php");
	include_once("inc/constantes.php");
	include_once("inc/fonctions.php");
	include_once("inc/date.php");
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
								<h2><i class="fa fa-pencil" aria-hidden="true"></i><?=$titre?></h2>
								<div class="wrapper">
									<fieldset>
										<p>Pour toute question relative au club : <a href="mailto:clocahandball@gmail.com">clocahandball@gmail.com</a></p>
										<p>Pour toute question relative au site internet : <a href="mailto:clocahandball@gmail.com">clocahandball@gmail.com</a></p>
									</fieldset>
								</div>
							</div>
						</article>
						<article class="col-sm-4 modules">
							<article>
								<?php include_once('inc/modules/infos-home.php'); ?>
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
	   <?php include('inc/script.php'); ?>
	</body>
</html>