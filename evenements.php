<?php
	// On inclue la page de connexion à la BDD
	include_once("inc/init_session.php");
	include_once("inc/connexion_bdd_pdo.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");

    // initialisation des variables
	$page = 'evenements';
	$titre_page = 'evenements';
	$filAriane = array(
		'home',
		array(
			'url' => $page,
			'libelle' => $titre_page
		)
	);
	$page = 'evenements';
	if(isset($_GET['date'])):
		$date = $_GET['date'];
		$annee = substr( $_GET['date'], 0, 4);
		$mois = (substr( $_GET['date'], 4, 1) == 0)? substr($_GET['date'], 5, 1):substr($_GET['date'], 4, 2);
		$jour = substr($_GET['date'], 6, 2);
		$uneDate = $jour.' '.$mois_de_lannee[$mois-1].' '.$annee;
	else:
		$uneDate = 'jour';
	endif;
	$titre_page = 'Evènements du '.$uneDate;
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
                                <h2><i class="fa fa-users" aria-hidden="true"></i><?=$titre?></h2>
                                <div class="wrapper">
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