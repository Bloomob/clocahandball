<?php 
	// On inclue la page de connexion à la BDD
    include_once("inc/init_session.php");
    include_once("inc/connexion_bdd_pdo.php");
    include_once("inc/fonctions.php");
    require_once("inc/date.php");
    include_once("inc/constantes.php");

	// On définit les variables
	$page = 'admin';
	$titre_page = 'admin';
	$titre = 'Administration';
    $filAriane = array(
        'home', 
        array(
            'url' => $page,
            'libelle' => $titre_page
        )
    );
	$annee = retourne_annee();

	if(!isset($_SESSION['rang']) OR !accesAutorise($_SESSION['rang'])) {
		header("Location: index.php");
		exit;
	}
		
	if(isset($_GET['page']))
		$tab = $_GET['page']; // On récupère la page choisie
	else
		$tab = ''; // Par défaut
		
	if(isset($_GET['num_p']))
		$num_page = $_GET['num_p']; // On récupère le numéro de la page choisie
	else
		$num_page = 1; // Par défaut
	
	if(isset($_GET['nb_pp']))
		$nb_par_page = $_GET['nb_pp']; // On récupère le nombre de résultats par page choisie
	else
		$nb_par_page = 25; // Par défaut
	
	$filtres = array();
	$input_filtres = "";
	if(isset($_GET['filtre_calendrier'])) {
		if(isset($_GET['filtre_categorie']) && $_GET['filtre_categorie'] != "-") {
			$filtres['categorie'] = $_GET['filtre_categorie'];
			$input_filtres .= "filtre_categorie=". $filtres['categorie'] ."&amp;";
		}
		if(isset($_GET['filtre_competition']) && $_GET['filtre_competition'] != "-") {
			$filtres['competition'] = $_GET['filtre_competition'];
			$input_filtres .= "filtre_competition=". $filtres['competition']."&amp;";
		}
		if(isset($_GET['filtre_date']) && $_GET['filtre_date'] != "-"){
			$filtres['date'] = $_GET['filtre_date'];
			$input_filtres .= "filtre_date=". $filtres['date']."&amp;";
		}
	}
	if(isset($_GET['filtre_fonctions'])) {
		if(isset($_GET['filtre_type']) && $_GET['filtre_type'] != "-") {
			$filtres['type'] = $_GET['filtre_type'];
			$input_filtres .= "filtre_type=". $filtres['type'] ."&amp;";
		}
		if(isset($_GET['filtre_fonction']) && $_GET['filtre_fonction'] != "-") {
			$filtres['fonction'] = $_GET['filtre_fonction'];
			$input_filtres .= "filtre_fonction=". $filtres['fonction']."&amp;";
		}
		if(isset($_GET['filtre_actif'])){
			$filtres['actif'] = $_GET['filtre_actif'];
			$input_filtres .= "filtre_actif=". $filtres['actif']."&amp;";
		}
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
					<article class="admin-panel">
                        <div class="contenu">
                            <h2><i class="fa fa-bank" aria-hidden="true"></i><?=$titre?></h2><?php
                            $liens = array();
                            $liens2 = array('afficher_tenue', 'ajout_tenue', 'modifier_tenue', 'afficher_adherents', 'ajout_adherent', 'modifier_adherent');
                            $options = array('where' => 'actif = 1 && parent > 0');
                            $listeTousMenuManager = $MenuManagerManager->retourneListe($options);

                            foreach ($listeTousMenuManager as $unMenuManager):
                                if($unMenuManager->getLien() != "")
                                    $liens[] = $unMenuManager->getLien();
                            endforeach;
                            if(in_array($tab, $liens) || in_array($tab, $liens2))
                                include_once('inc/admin/'.$tab.'.php');
                            else
                                include_once('inc/admin/default.php');
                            ?>
                        </div>
					</article>
				</div>
			</section>
		</main>
        <footer>
            <?php include_once('inc/footer.php'); ?>
        </footer>
		<?php include('inc/script.php'); ?>
	</body>
</html>