<?php 
	session_start();
	include_once("inc/fonctions.php");
	include_once("inc/date.php");
	include_once("inc/connexion.php");
	include_once("inc/constantes.php");
	
	$page = 'evenements';
	if(isset($_GET['date'])) {
		$date = $_GET['date'];
		$annee = substr( $_GET['date'], 0, 4);
		$mois = (substr( $_GET['date'], 4, 1) == 0)? substr($_GET['date'], 5, 1):substr($_GET['date'], 4, 2);
		$jour = substr($_GET['date'], 6, 2);
		$uneDate = $jour.' '.$mois_de_lannee[$mois-1].' '.$annee;
	}
	else {
		$uneDate = 'jour';
	}
	$titre_page = 'Evènements du '.$uneDate;
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
		<header>
			<?php include_once('inc/header.php'); ?>
		</header>
		<div id='main'>
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
						<li class="nav navtit2"><span><a href="resultats_classements.php?onglet=calendrier">Calendrier général</a></span></li>
						<li><span><?=$titre_page;?></span></li>
					</ul>
				</nav>
				<div class="bg1 pad">
					<article class="col2 marg-right1">
						<h2><?=ucfirst($titre_page)?></h2>
						<div class="evenement_jour_nav">
							<div class="bouton_hier"><a href="evenements.php?date=<?=$date-1;?>">Hier</a></div>
							<div class="bouton_event">Evènements</div>
							<div class="bouton_demain"><a href="evenements.php?date=<?=$date+1;?>">Demain</a></div>
						</div>
						<div class='clear_b'></div>
						<div class="evenement_jour">
							
							<?php
								$liste_matchs = liste_event_jour($date);
								// debug($liste_matchs);
								$horaire = "";
								if(is_array($liste_matchs)) {
									foreach($liste_matchs as $match) {
											
										$cat = $match['equipe'];
										
										if($match['lieu']==0) {
											$eq_dom = "<strong>".$cat."</strong>";
											$eq_ext = $match['adversaire'];
										}
										else {
											$eq_dom = $match['adversaire'];
											$eq_ext = "<strong>".$cat."</strong>";
										}
										
										if($horaire != $match['horaire']) { ?>
											<div class='horaire'><?=$match['horaire'];?></div><?php
										} ?>
										<div class='event_infos'>
											<h4><div class='cercle competition_<?=$match['id_compet'];?>_<?=$match['id_niveau'];?>'></div><?=$match['competition'];?></h4>
											<div class="journee"><?=$match['journee'];?></div>
											<div class='clear_b'></div>
											<div class='rencontre'>
												<div class='eq_dom'><?=$eq_dom;?></div>
												<div class='eq_ext'><?=$eq_ext;?></div>
												<div class='clear_b'></div>
											</div>
										</div><?php
										$horaire = $match['horaire'];
									}
								}
								else {
									echo "Aucun match programmé à cette date";
								}
							?>
							
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