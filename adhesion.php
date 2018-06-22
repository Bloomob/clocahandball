<?php
// On inclue la page de connexion à la BDD
include_once("inc/init_session.php");
include_once("inc/connexion_bdd_pdo.php");
include_once("inc/fonctions.php");
require_once("inc/date.php");
include_once("inc/constantes.php");

// Initialisation des variables
$page = 'adhesion';
$titre_page = 'adhésion';
$filAriane = array(
	'home', 
	array(
		'url' => $page,
		'libelle' => $titre_page
	),
	array(
		 array(
			'url' => 'comment_sinscrire',
			'libelle' => 'S\'inscrire'
		),
		 array(
			'url' => 'tarifs_cotisation',
			'libelle' => 'Tarifs'
		),
		 array(
			'url' => 'documents_a_telecharger',
			'libelle' => 'Documents'
		),
		 array(
			'url' => 'reglement_interieur',
			'libelle' => 'Règlement interieur'
		),
	)
);

if(isset($_GET['onglet'])):
	$onglet = $_GET['onglet']; // On récupère la catégorie de staff choisi
else:
	$onglet = 'comment_sinscrire'; // Par défaut
endif;
	
switch($onglet):
	case 'tarifs_cotisation':
		$titre = 'Les tarifs & cotisations';
	break;
	case 'reglement_interieur':
		$titre = 'Le règlement interieur';
	break;
	case 'documents_a_telecharger':
		$titre = 'Documents à télécharger';
	break;

	case 'comment_sinscrire':
	default:
		$titre = 'Comment s\'inscrire ?';
	break;
endswitch;
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
					<article class="col-sm-8">
						<div class="contenu">
							<h2><i class="fa fa-pencil" aria-hidden="true"></i><?=$titre?></h2>
							<div class="wrapper"><?php
                                switch($onglet):
									case 'tarifs_cotisation':
			                         include_once('inc/parts/adhesion/tarifs_cotisation.php');
                                    break;
									case 'reglement_interieur':
			                             include_once('inc/parts/adhesion/reglement_interieur.php');
                                    break;
									case 'documents_a_venir':
			                             include_once('inc/parts/adhesion/documents_a_venir.php');
                                    break;
									case 'comment_sinscrire':
                                    default:
			                             include_once('inc/parts/adhesion/comment_sinscrire.php');
                                    break;
                                endswitch;?>
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
	<?php include('inc/script.php'); ?>
</body>
</html>