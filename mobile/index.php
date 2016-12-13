<?php 
	if(!strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') && !strstr($_SERVER['HTTP_USER_AGENT'],'iPod')) {
		header("Location: ../index.php");
	}
	$page = 'index';
	session_start();
	include_once("../inc/fonctions.php");
	include_once("../inc/date.php");
	include_once("../inc/connexion.php");
?>

<!DOCTYPE html>
<html lang="fr" <!--manifest="cache.appcache"-->>
	<head>
		<title>C.L.O.C.A. Handball</title>
		<link rel="apple-touch-icon" href="../images/logo_iphone.png"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<link rel="stylesheet" href="css/jquery.mobile-1.3.2.min.css" />
		<link rel="stylesheet" href="css/style_s.css" />
		<script src="../javascript/jquery-ui/jquery-1.8.0.js"></script>
		<script src="javascript/jquery.mobile-1.3.2.min.js"></script>
	</head>
	<body>
		<!-- Page Home -->
		<div data-role="page" id="home" data-title="Home Page">
			<div data-role="header" data-position="fixed" data-theme="b">
				<h1>Achères HB</h1>
				<a href="#leMenu" data-icon="grid" data-iconpos="notext" data-theme="b" data-transition="slide">Menu</a>
			</div><!-- /header -->
			<div data-role="content">	
				<p>Hello world</p>		
				<p>Hello world 2</p>		
			</div><!-- /content -->
			<div data-role="footer" data-position="fixed" data-theme="b">
				<div data-role="navbar" data-theme="b">
					<ul>
						<li><a href="index.php">Accueil</a></li>
						<li><a href="actualites.php">Actualités</a></li>
						<li><a href="resultats.php">Résultats</a></li>
						<li><a href="direct.php">Direct</a></li>
					</ul>
				</div><!-- /navbar -->		
			</div><!-- /footer -->
			<div data-role="panel" id="leMenu">
				Test de panel
				<a href="#menu" data-icon="grid" data-iconpos="notext" data-theme="b" data-transition="slide">Menu</a>
			</div><!-- /panel -->
		</div><!-- /page -->
		
		<!-- Page Menu -->
		<div data-role="page" id="menu" data-title="Menu">
			<div data-role="header" data-position="fixed" data-theme="b">
				<h1>Achères HB</h1>
				<a href="#home" data-icon="back" data-iconpos="notext" data-theme="b" data-transition="slide" data-direction="reverse">Menu</a>
			</div><!-- /header -->
			<div data-role="content">
				<div data-role="controlgroup">
					<a href="index.php" data-icon="arrow-r" data-role="button" data-iconpos="right">Yes</a>
					<a href="index.php" data-icon="arrow-r" data-role="button" data-iconpos="right">No</a>
					<a href="index.php" data-icon="arrow-r" data-role="button" data-iconpos="right">Maybe</a>
				</div>
			</div><!-- /content -->
			<div data-role="footer" data-position="fixed" data-theme="b">
				<div data-role="navbar" data-theme="b">
					<ul>
						<li><a href="index.php">Accueil</a></li>
						<li><a href="actualites.php">Actualités</a></li>
						<li><a href="resultats.php">Résultats</a></li>
						<li><a href="direct.php">Direct</a></li>
					</ul>
				</div><!-- /navbar -->		
			</div><!-- /footer -->		
		</div><!-- /page -->
	</body>
</html>