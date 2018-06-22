<?php 
	// On inclue la page de connexion à la BDD
	include_once("inc/init_session.php");
	include_once("inc/connexion_bdd_pdo.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");

	// Initialisation des variables
	$page = 'actualites';
	$titre_page = 'actualites';
	$titre = 'Actualités';
	$id_actualite = 0;
	$theme = '';
	$filAriane = array(
        'home', 
        array(
            'url' => $page,
            'libelle' => $titre_page
        )
    );
	
	// Initialisation des managers
	$ActuManager = new ActualiteManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	
	// Si on a spécifié une ID d'actualité dans l'url
	if(isset($_GET['id']))
		$id_actualite = intval($_GET['id']);
	
	// Si on a spécifié un thème d'actualité dans l'url	
	if(isset($_GET['onglet']))
		$theme = $_GET['onglet'];

	if($id_actualite > 0):
		$options = array('where' => 'id = '. $id_actualite);
		$listeActualites = $ActuManager->retourne($options);
		$filAriane[2] = array(
            'url' => $listeActualites->getTheme(),
            'libelle' => $listeActualites->getTheme()
        );
        $filAriane[3] = '';
	else:
		$options = array('where' => 'date_publication > 20170701', 'orderby' => 'date_publication desc, heure_publication desc', 'limit' => '0, 10');
		if($theme != '' && $options['where'] == '')
			$options['where'] = 'theme = "'. $theme .'"';
        elseif($theme != '')
			$options['where'] .= ' AND theme = "'. $theme .'"';
		$listeActualites = $ActuManager->retourneListe($options);
	endif;
	if($theme != ''):
		$filAriane[2] = array(
            'url' => $theme,
            'libelle' => $theme
        );
        $filAriane[3] = '';
    endif;
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
		<main class="<?=$page;?>">
			<section id="content">
				<?php include_once('inc/fil_ariane.php'); ?>
				<div class="container">
                    <div class="row">
                        <article class="col-sm-8"><?php
                            if(is_object($listeActualites) && $listeActualites->getId() != 0 && $theme == ''):
                                include_once("inc/parts/actualites/details.php");
                            elseif(!$listeActualites ||is_array($listeActualites)):
                                include_once("inc/parts/actualites/liste.php");
                            else: ?>
                                <div>
                                    <p>Cette actualité n'existe pas.<br/>Pour la liste des actualités : <a href="actualites.php">Cliquez-ici</a></p>
                                </div><?php
                            endif; ?>
                        </article>
                        <article class="col-sm-4 modules">
                            <?php include_once('inc/modules/partenaires.php'); ?>
                            <?php include_once('inc/modules/facebook-home.php'); ?>
                            <?php include_once('inc/modules/liens-utiles-home.php'); ?>
                        </article>
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