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
	
	/** Id **/
	if(isset($_POST['id'])) {
		if($ActuManager->existeId($_POST['id'])) {
			$id = $_POST['id'];
			
			$options = array('where' => 'id = '. $id);
			$modifActu = $ActuManager->retourne($options);

			/** Titre **/
			if(isset($_POST['titre'])) {
				if(!empty($_POST['titre'])) {
					$titre = htmlspecialchars_decode(htmlentities($_POST['titre'], ENT_QUOTES, "UTF-8"));
					$modifActu->setTitre($titre);
				}
			}

			/** Sous-titre **/
			if(isset($_POST['sous_titre'])) {
				if(!empty($_POST['sous_titre'])) {
					$sous_titre = htmlspecialchars_decode(htmlentities($_POST['sous_titre'], ENT_QUOTES, "UTF-8"));
					$modifActu->setSous_titre($sous_titre);
				}
			}

			/** Contenu **/
			if(isset($_POST['contenu'])) {
				if(!empty($_POST['contenu'])) {
					$contenu = htmlspecialchars_decode(htmlentities($_POST['contenu'], ENT_QUOTES, "UTF-8"));
					$modifActu->setContenu($contenu);
				}
			}

			/** Theme **/
			if(isset($_POST['theme'])) {
				if(!empty($_POST['theme'])) {
					$theme = htmlspecialchars_decode(htmlentities($_POST['theme'], ENT_QUOTES, "UTF-8"));
					$modifActu->setTheme($theme);
				}
			}

			/** Tags **/
			if(isset($_POST['tags'])) {
				if(!empty($_POST['tags'])) {
					$tags = htmlspecialchars_decode(htmlentities($_POST['tags'], ENT_QUOTES, "UTF-8"));
					$modifActu->setTags($tags);
				}
			}

			/** Image **/
			if(isset($_POST['image'])) {
				if(!empty($_POST['image'])) {
					$image = htmlspecialchars_decode(htmlentities($_POST['image'], ENT_QUOTES, "UTF-8"));
					$modifActu->setImage($image);
				}
			}

			/** Slider **/
			if(isset($_POST['slider'])) {
				if(!empty($_POST['slider'])) {
					if($_POST['slider'] == 'true')
						$modifActu->setSlider(1);
					else
						$modifActu->setSlider(0);
				}
			}

			/** Importance **/
			if(isset($_POST['importance'])) {
				if(!empty($_POST['importance'])) {
					$importance = htmlspecialchars_decode(htmlentities($_POST['importance'], ENT_QUOTES, "UTF-8"));
					$modifActu->setImportance($importance);
				}
			}

			/** Publie **/
			if(isset($_POST['publie'])) {
				if(!empty($_POST['publie'])) {
					if($_POST['publie'] == 'true')
						$modifActu->setPublie(1);
					else
						$modifActu->setPublie(0);
				}
				else {
					$modifActu->setPublie(0);
				}
			}

			if(isset($_SESSION['id']))
				$modifActu->setId_auteur_modif($_SESSION['id']);
			
			$modifActu->setDate_modification(date('Ymd'));
			$modifActu->setHeure_modification(date('Hi'));

			if($ActuManager->modifier($modifActu))
				echo "L'actualit&eacute; a bien &eacute;t&eacute; modifi&eacute;e !";
			else
				echo "L'actualit&eacute; n'a pas &eacute;t&eacute; modifi&eacute;e !";

		}
		else {
			echo "L'actualit&eacute; n'existe pas !";
		}
	}
?>