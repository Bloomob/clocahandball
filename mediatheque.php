<?php 
	$page = 'mediatheque';

	$titre_page = 'La médiathèque';
	$titre = 'La médiathèque';

	session_start();
	include_once("inc/fonctions.php");
	include_once("inc/connexion.php");
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>C.L.O.C.A. Handball</title>
		<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
		<link rel="icon" href="images/icon_hr.png" type="image/x-icon">
		<!--
		<link rel="apple-touch-icon" href="images/logo_iphone.png"/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport">
		-->
	</head>
	<body id="page1">
		<div id='main'>
			<header>
				<?php include_once('inc/header.php'); ?>
			</header>
			<div id="connexion">
				<img src="images/fermer.png" id="fermer"/>
				<div class="c_contenu">
					<form method="post" action="">
						<label for="login">Login</label><br/>
						<input type="text" id="login" name="login"/><br /><br />
						<label for="mot_de_passe">Mot de passe</label><br />
						<input type="password" id="mot_de_passe" name="mot_de_passe"/><br /><br />
						<input type="submit" id="bouton_connexion" name="bouton_connexion" value="SE CONNECTER"/>
					</form>
				</div>
			</div>
			<section id="content">
				<nav>
					<ul>
						<li class="nav navhome"><a href="index.php"><!--<img src="images/icon/png_white/home.png"/>-->Home</a></li>
						<li class="nav navtit2"><span><?=$titre_page?></span></li>
					</ul>
				</nav>
				<div class="bg1 pad">
					<article class="col2 marg-right1">
						<h2><?=$titre?></h2>
						<div>La page est en constuction.</div>
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