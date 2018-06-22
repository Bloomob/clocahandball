<?php 
    // On inclue la page de connexion à la BDD
	include_once("inc/init_session.php");
	include_once("inc/connexion_bdd_pdo.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");

	// initialisation des variables	
	$page = 'staff';
	$titre_page = 'staff';

	$filAriane = array(
		'home',
		array(
			'url' => $page,
			'libelle' => $titre_page
		),
        array(
            array(
                'url' => 'bur',
                'libelle' => 'Les membres du bureau'
            ),
            array(
                'url' => 'entr',
                'libelle' => 'Les entraineurs du club'
            ),
            array(
                'url' => 'arb',
                'libelle' => 'Les arbitres du club'
            )
        )
	);
	
	// Initialisation des managers
	$RoleManager = new RoleManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$FonctionManager = new FonctionManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	
	if(isset($_GET['onglet']))
		$onglet = $_GET['onglet']; // On récupère la catégorie de staff choisi
	else
		$onglet = 'bur'; // Par défaut
	
	switch($onglet) {
		case 'entr':
			$titre = 'Les entraineurs du club';
		break;
		case 'arb':
			$titre = 'Les arbitres du club';
		break;/*
		case 'devenir_entraineur':
			$titre = 'Comment devenir entraineur ?';
		break;
		case 'devenir_arbitre':
			$titre = 'Comment devenir arbitre ?';
		break;*/
		case 'bur':
		default:
			$titre = 'Les membres du bureau';
		break;
	}
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
                        <article id="staff" class="col-sm-8"> 
                            <div class="contenu">
								<h2><i class="fa fa-users" aria-hidden="true"></i><?=$titre?></h2>
                                <div class="row"><?php
                                    $options = array('where' => 'raccourci LIKE "'. $onglet .'"');
                                    $unRole = $RoleManager->retourne($options);
                                    // debug($unRole);
                                    if($unRole->getId()):
                                        $options = array('where' => 'annee_fin = 0 AND type = '. $unRole->getId(), 'orderby' => 'role');
                                        $listeStaff = $FonctionManager->retourneListe($options);
                                        // debug($listeStaff);
                                        if(!empty($listeStaff)):
                                            foreach($listeStaff as $unMembre):
                                                if($unMembre->getType() == 4):
                                                    $options = array('where' => 'id = '. $unMembre->getRole());
                                                    $uneCategorie = $CategorieManager->retourne($options);
                                                    $fonction = $uneCategorie->getCategorieAll();
                                                else:
                                                    $options = array('where' => 'id = '. $unMembre->getRole());
                                                    $roleMembre = $RoleManager->retourne($options);
                                                    $fonction = $roleMembre->getNom();
                                                endif; ?>
                                                <div class="col-sm-6">
                                                    <div class="fiche">
                                                        <h3><?=$fonction;?></h3>
                                                        <div class="membre">
                                                            <div class="row">
                                                                <div class="col-sm-4 photo"><img src="images/inconnu.gif" alt="Lambda" width="100px" /></div>
                                                                <div class="col-sm-8"><?php
                                                                    $options = array('where' => 'id = '. $unMembre->getId_utilisateur());
                                                                    $unUtilisateur = $UtilisateurManager->retourne($options); ?>
                                                                    <div class="description"><strong><?=$unUtilisateur->getPrenom();?> <?=$unUtilisateur->getNom();?></strong></div>
                                                                    <div class="description"><strong>Depuis</strong> : <?=$unMembre->getAnnee_debut();?></div>
                                                                    <div class="description"><strong>Email</strong> : <a href="mailto:<?=$unUtilisateur->getMail();?>"><?=$unUtilisateur->getMail();?></a></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><?php
                                            endforeach;
                                        else:
                                            echo "<div>Pas de données disponibles pour le moment.</div>";
                                        endif;
                                    else:
                                        echo "<div>Pas de données disponibles pour le moment.</div>";
                                    endif;?>
                                </div>
                            </div>
                        </article>
                        <article class="col-sm-4 modules">
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
		<?php include_once('inc/script.php'); ?>
	</body>
</html>