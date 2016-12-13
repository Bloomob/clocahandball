<?php 
	$page = 'boutique';
	$titre_page = 'boutique';
	session_start();
	include_once("inc/fonctions.php");
	include_once("inc/date.php");
	include_once("inc/connexion.php");
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>C.L.O.C.A. Handball</title>
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
		<link href="lightbox/css/lightbox.css" rel="stylesheet" />
		<link rel="icon" href="images/icon_hr.png" type="image/x-icon">
	</head>
	<body id="page1">
		<header>
			<?php include_once('inc/header_admin.php'); ?>
		</header>
		<div id='main'>
			<section id="content">
				<nav>
					<ul>
						<li class="nav navtit2"><span><?=$titre_page?></span></li>
						<li><span>home</span></li>
					</ul>
				</nav>
				<div class="bg1 pad">
					<article class="col2 marg-right1 minheight1">
						<h2>Boutique</h2>
						<div>
							<div style="width: 620px;height: 860px;"> 
								<object data="upload/boutique_2013_2014.pdf" type="text/html" codetype="application/pdf" width="620" height="860" ></object> 
							</div>
							<div style="width: 620px;height: 860px;"> 
								<object data="upload/bon_de_commande_2013_2014.pdf" type="text/html" codetype="application/pdf" width="620" height="860" ></object> 
							</div> 
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
		<script type="text/javascript" src="lightbox/js/lightbox-2.6.min.js"></script>
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