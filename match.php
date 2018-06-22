<?php 
	// On initialise et on charge les fonctions
	require_once("inc/init_session.php");
	require_once("inc/connexion_bdd_pdo.php");
	require_once("inc/fonctions.php");
	require_once("inc/date.php");
	require_once("inc/constantes.php");
	
	// On définit les variables
	$page = 'match';
	$titre_page = 'D&eacute;tails d\'un match';
	$titre = 'D&eacute;tails d\'un match';
	$filAriane = array(
        'home', 
        array(
            'url' => $page,
            'libelle' => $titre_page
        )/*,
        array(
            array(
                'url' => 'infos',
                'libelle' => 'Mes infos'
            ),
            array(
                'url' => 'equipes',
                'libelle' => 'Mes équipes'
            )
        )*/
    );
	$id = 0;
	
	if(isset($_GET['id'])):
		$id = $_GET['id'];
    else:
        header("Location: index.php");
		exit;
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
                        <article class="col-md-8">
							<div class="contenu">
								<h2><i class="fa fa-calendar" aria-hidden="true"></i><?=$titre?></h2>
								<div class="wrapper">
                                    <?php
                                    if($id != 0):
                                        $infosMatch = retourneUnMatch($id);
                                        // degug($infosMatch);?>
                                        <div class="infos_match">
                                            <div class="infos_rencontre"><?php
                                                if($infosMatch['lieu']==0): ?>
                                                    <div class="home">Ach&egrave;res</div><div class="score-time"><?=$infosMatch['score'];?></div><div class="away"><?=$infosMatch['adversaire'];?></div><?php
                                                else: ?>
                                                    <div class="home"><?=$infosMatch['adversaire'];?></div><div class="score-time"><?=$infosMatch['score'];?></div><div class="away">Ach&egrave;res</div><?php
                                                endif; ?>
                                            </div>
                                            <div class="infos_horaire">
                                                <span><?=$infosMatch['laDate'];?> à <?=$infosMatch['lHeure'];?></span>
                                            </div>
                                        </div><?php
                                    endif; ?>
                                </div>
                            </div>
                        </article>
                        <article class="col-md-4 modules">
                            <?php include_once('inc/modules/infos-home.php'); ?>
                            <?php include_once('inc/modules/partenaires.php'); ?>
                        </article>
                    </div>
				</div>
			</section>
        </main>
        <footer>
            <?php include_once('inc/footer.php'); ?>
        </footer>
		<?php include('inc/script.php'); ?>
	</body>
</html>