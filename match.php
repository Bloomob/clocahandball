<?php 
	session_start();
	include_once("inc/fonctions.php");
	include_once("inc/date.php");
	include_once("inc/connexion.php");
	
	$page = 'match';
	$titre_page = 'Infos Match';
	$id = 0;
	
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
	}
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
			<section id="content">
				<nav>
					<ul>
						<li class="nav navtit2"><span><?=$titre_page?></span></li>
					</ul>
				</nav>
				<div class="bg1 pad">
					<article class="col2 marg-right1">
						<h2><?=$titre_page?></h2>
						<div><?php
							if($id != 0) {
								$infosMatch = retourneUnMatch($id);
								// echo '<pre>';
								// var_dump($infosMatch);
								// echo '</pre>'; ?>
								<div class="infos_match">
									<div class="infos_rencontre"><?php
										if($infosMatch['lieu']==0) { ?>
											<div class="home">Ach&egrave;res</div><div class="score-time"><?=$infosMatch['score'];?></div><div class="away"><?=$infosMatch['adversaire'];?></div><?php
										} else { ?>
											<div class="home"><?=$infosMatch['adversaire'];?></div><div class="score-time"><?=$infosMatch['score'];?></div><div class="away">Ach&egrave;res</div><?php
										} ?>
									</div>
									<div class="infos_horaire">
										<span><?=$infosMatch['laDate'];?> à <?=$infosMatch['lHeure'];?></span>
									</div>
								</div><?php
							} ?>
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
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
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