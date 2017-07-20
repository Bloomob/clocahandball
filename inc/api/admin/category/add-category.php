<?php
    session_start();
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../../connexion_bdd_pdo.php");
	include_once("../../../date.php");

	$CategorieManager = new CategorieManager($connexion);

	if(isset($_POST['data'])) {

		$categorie = new Categorie(array());

		foreach ($_POST['data'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($categorie, $method)) {
				$categorie->$method(htmlspecialchars_decode(htmlentities($value['value'], ENT_QUOTES, "UTF-8")));
			}
		}
		$raccourci = 'm' . substr($categorie->getCategorie(),1,2) . substr(($categorie->getGenre() == 'masculin') ? 'g' : $categorie->getGenre(),0,1) . $categorie->getNumero();
		$categorie->setRaccourci(htmlspecialchars_decode(htmlentities($raccourci, ENT_QUOTES, "UTF-8")));

		// var_dump($categorie);

		
		$categorieId = $CategorieManager->ajouter($categorie);
        
        if($categorieId) {
			$options = array('where' => 'ordre >= ' . $categorie->getOrdre());
			$liste = $CategorieManager->retourneListe($options);
			foreach ($liste as $key => $cat) {
				$cat->setOrdre($cat->getOrdre() + 5);
			}
			// var_dump($liste);
			echo true;
			exit;
		}
        echo false;
        exit;
	}
?>