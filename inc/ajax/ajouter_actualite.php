<?php
	session_start();
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD & les constantes
	include_once("../connexion_bdd_pdo.php");

	$ActuManager = new ActualiteManager($connexion);
	$ajoutActu = new Actualite(array());

	/** Titre **/
	if(isset($_POST['titre'])) {
		if(!empty($_POST['titre'])) {
			$titre = htmlspecialchars_decode(htmlentities($_POST['titre'], ENT_QUOTES, "UTF-8"));
			$ajoutActu->setTitre($titre);
		}
	}

	/** Sous-titre **/
	if(isset($_POST['sous_titre'])) {
		if(!empty($_POST['sous_titre'])) {
			$sous_titre = htmlspecialchars_decode(htmlentities($_POST['sous_titre'], ENT_QUOTES, "UTF-8"));
			$ajoutActu->setSous_titre($sous_titre);
		}
	}

	/** Contenu **/
	if(isset($_POST['contenu'])) {
		if(!empty($_POST['contenu'])) {
			$contenu = htmlspecialchars_decode(htmlentities($_POST['contenu'], ENT_QUOTES, "UTF-8"));
			$ajoutActu->setContenu($contenu);
		}
	}

	/** Theme **/
	if(isset($_POST['theme'])) {
		if(!empty($_POST['theme'])) {
			$theme = htmlspecialchars_decode(htmlentities($_POST['theme'], ENT_QUOTES, "UTF-8"));
			$ajoutActu->setTheme($theme);
		}
	}

	/** Tags **/
	if(isset($_POST['tags'])) {
		if(!empty($_POST['tags'])) {
			$tags = htmlspecialchars_decode(htmlentities($_POST['tags'], ENT_QUOTES, "UTF-8"));
			$ajoutActu->setTags($tags);
		}
	}

	/** Image **/
	if(isset($_POST['image'])) {
		if(!empty($_POST['image'])) {
			$image = htmlspecialchars_decode(htmlentities($_POST['image'], ENT_QUOTES, "UTF-8"));
			$ajoutActu->setImage($image);
		}
	}

	/** Slider **/
	if(isset($_POST['slider'])) {
		if(!empty($_POST['slider'])) {
			if($_POST['slider'] == 'true')
				$ajoutActu->setSlider(1);
			else
				$ajoutActu->setSlider(0);
		}
	}

	/** Importance **/
	if(isset($_POST['importance'])) {
		if(!empty($_POST['importance'])) {
			$importance = htmlspecialchars_decode(htmlentities($_POST['importance'], ENT_QUOTES, "UTF-8"));
			$ajoutActu->setImportance($importance);
		}
	}

	/** Publie **/
	if(isset($_POST['publie'])) {
		if(!empty($_POST['publie'])) {
			if($_POST['publie'] == 'true')
				$ajoutActu->setPublie(1);
			else
				$ajoutActu->setPublie(0);
		}
		else {
			$ajoutActu->setPublie(0);
		}
	}

	if(isset($_SESSION['id']))
		$ajoutActu->setId_auteur_crea($_SESSION['id']);
	
	$ajoutActu->setDate_creation(date('Ymd'));
	$ajoutActu->setHeure_creation(date('Hi'));
		
	if($ActuManager->ajouter($ajoutActu))
		echo "L'actualit&eacute; a bien &eacute;t&eacute; ajout&eacute;e !";
	else
		echo "L'actualit&eacute; n'a pas &eacute;t&eacute; ajout&eacute;e !";
?>