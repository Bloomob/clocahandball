<?php 
	session_start();

	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On définit les variables
	$page = 'admin';
	$titre_page = 'administration';

	// On inclue la page de connexion à la BDD
	require_once("inc/connexion_bdd_pdo.php");
	require_once("inc/connexion_bdd.php");
	require_once("inc/fonctions.php");
	require_once("inc/date.php");
	require_once("inc/constantes.php");
	require_once("inc/connexion.php");

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
	<body id="page1" class="admin">
		<header>
			<?php include_once('inc/header_admin.php'); ?>
		</header>
		<div id='main'>
			<section id="content">
				<nav>
					<ul>
						<li class="nav navhome"><a href="index.php">Home</a></li>
						<li class="nav navtit2"><a href="admin.php">Administration</a></li></li>
						<li><a href="#"><?=$tab;?></a></li>
					</ul>
				</nav>
				<div class="bg1 pad">
					<article class="col0 admin_panel"><?php
						$liens = array();
						$options = array('where' => 'actif = 1 && parent > 0');
						$listeTousMenuManager = $MenuManagerManager->retourneListe($options);
						
						foreach ($listeTousMenuManager as $unMenuManager) {
							if($unMenuManager->getLien() != "")
								$liens[] = $unMenuManager->getLien();
						}
						if(in_array($tab, $liens))
							include_once('inc/admin/'.$tab.'.php');
						else {
							include_once('inc/admin/default.php');
						}?>
					</article>
				</div>
			</section>
			<footer>
				<?php include_once('inc/footer.php'); ?>
			</footer>
			<div id="fond" class="fond_transparent"></div>
		</div>
		<div id="maDiv"></div>
		<?php include('inc/script.php'); ?>
		<script src="javascript/admin2.js"></script>
	</body>
</html>