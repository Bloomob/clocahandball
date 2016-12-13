<?php 
	session_start();
	include_once("inc/fonctions.php");
	include_once("inc/connexion.php");
	include_once("inc/date.php");
	
	$annee = retourne_annee();
	
	$page = 'dossiers';
	$filAriane = array('home', 'dossiers', '');
	$id_dossier = 0;
	$theme_dossier = '';

	// On test si l'id du dossier est en paramètre
	if(isset($_GET['id'])) {
		$id_dossier = intval($_GET['id']);
		// Si l'id du dossier existe on affiche le dossier
		if(existe_idDossier($id_dossier)) {
			$listeDossiers = listeDossiers('', $id_dossier);
			$filAriane[2] = $listeDossiers[0]['theme'];
		}
		else
			header('Location: dossiers.php');
	}
	// On test si le thème du dossier est en paramètre
	elseif ($_GET['onglet']) {
		$theme_dossier = $_GET['onglet'];
		// Si le thème des dossiers existe on liste les 5 derniers dossiers de ce thème
		if(existe_themeDossier($theme_dossier)) {
			$listeDossiers = listeDossiers($theme_dossier);
			$filAriane[2] = $theme_dossier;
		}
		else
			header('Location: dossiers.php');
	}
	// Sinon on liste les 5 derniers dossiers
	else {
		$listeDossiers = listeDossiers();
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
				<?php include_once('inc/fil_ariane.php'); ?>
				<div class="bg1 pad">
					<article class="col2 marg-right1"><?php
						if(count($listeDossiers) == 1) { ?>
							<div class="unDossier">
								<h2><?=html_entity_decode($listeDossiers[0]['titre']);?></h2>
								<div class="auteur_date"><span><?=$listeDossiers[0]['auteur_date'];?></span></div>
								<div class="contenu">
									<h4><?php echo html_entity_decode($listeDossiers[0]['sous_titre']);?></h4>
									<div class="align_center"><img src="images/<?=$listeDossiers[0]['image'];?>.png" alt /></div>
									<div class="marginTB20"><?php echo html_entity_decode($listeDossiers[0]['contenu']);?></div>
								</div>
							</div><?php
						}
						else {
							foreach($listeDossiers as $unDossier) { ?>
								<div class="listeDossiers">
									<!--<div class="auteur_date"><span><?=$unDossier['auteur_date']?></span></div>-->
									<div class="image">
										<a href="?id=<?=$unDossier['id_dossier']?>"><img src="images/<?=$unDossier['image'];?>.png" /></a>
									</div>
									<h4><a href="?id=<?=$unDossier['id_dossier']?>"><?=html_entity_decode(stripslashes($unDossier['titre']))?></a></h4>
									<div class="contenu">
										<a href="?id=<?=$unDossier['id_dossier']?>"><?=html_entity_decode(stripslashes($unDossier['sous_titre']));?></a>
									</div>
									<div class="clear_b"></div>
								</div><?php
							}
						} ?>
					</article>
					<article class="col1">
						<article>
							<?php include_once('inc/infos.php'); ?>
						</article>
						<article class="marginT">
							<?php include_once('inc/infoflash.php'); ?>
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
		<script type="text/javascript" src="javascript/script.js"></script>
		<script type="text/javascript" src="javascript/mon_profil.js"></script>
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