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
	$titre_page = 'contact';
	$filAriane = array('home', $titre_page);
	
	// On inclue la page de connexion à la BDD
	include_once("inc/connexion_bdd_pdo.php");
	require_once("inc/connexion_bdd.php");
	include_once("inc/constantes.php");
	include_once("inc/fonctions.php");
	include_once("inc/connexion.php");
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php include_once('inc/head.php'); ?>
	</head>
	<body id="page1">
		<header>
			<?php include_once('inc/header.php'); ?>
		</header>
		<div id='main'>
			<section id="content" class="<?=$page;?>">
				<?php include_once('inc/fil_ariane.php'); ?>
				<div class="bg1 pad">
					<article class="col2 marg-right1 minheight2">
						<h2>Nous contacter</h2>
						<div>
							<fieldset>
								<p>Pour toute question relative au club : <a href="mailto:contact@clocahandball.fr">contact@clocahandball.fr</a></p>
								<p>Pour toute question relative au site internet : <a href="mailto:contact@clocahandball.fr">contact@clocahandball.fr</a></p>
							</fieldset>
						</div>
					</article>
					<article class="col1">
						<article>
							<?php include_once('inc/infoflash.php'); ?>
						</article>
						<article class="marginT">
							<?php include_once('inc/infos.php'); ?>
						</article>
						<article class="marginT">
							<?php include_once('inc/who_online.php'); ?>
						</article>
						<article class="marginT">
							<?php include_once('inc/partenaires.php'); ?>
						</article>
					</article>
				</div>
			</section>
			<footer>
				<?php include_once('inc/footer.php'); ?>
			</footer>
			<div id="fond" class="fond_transparent"></div>
		</div>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<script type="text/javascript" src="javascript/script.js"></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-43491471-1', 'clocahandball.fr');
		  ga('send', 'pageview');

		</script>
	</body>
</html>