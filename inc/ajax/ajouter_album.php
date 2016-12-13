<?php
	$getDossier = '';
	$retourDossier = '';
	if(isset($_POST['dossier'])) {
		$getDossier = $_POST['dossier'];
		$pos = strrpos($getDossier, '/');
		$retourDossier = substr($getDossier, 0, $pos);
	}
	if(isset($_POST['nom'])) {
		if(!empty($_POST['nom'])) {
			$nom = str_replace(' ', '_', $_POST['nom']);
			mkdir('../../images/albums'.$getDossier.'/'.$nom.'/');
		}
	}

	$table_fichier = array();
	$nb_fichier = 0;
	if($dossier = opendir('../../images/albums'.$getDossier.'/')){
		while(false !== ($fichier = readdir($dossier))){
			if($fichier != '.' && $fichier != '..' && $fichier != 'index.php'){
				$nb_fichier++; // On incrémente le compteur de 1
				$table_fichier[] = $fichier;
			} // On ferme le if (qui permet de ne pas afficher index.php, etc.)
		} // On termine la boucle
		echo 'Il y a <strong>' . $nb_fichier .'</strong> fichier(s) dans le dossier';
		closedir($dossier);
		 
	}
	else
	     echo 'Le dossier n\' a pas pu être ouvert';
?>
<div class="liste">
	<input type='hidden' class='dir_courant' value='<?=$getDossier;?>' /><?php
	if(!empty($retourDossier)) {?>
		<a href="<?=$retourDossier;?>" class="nav retour">Remonter d'un dossier</a><?php
	}
	else if(empty($retourDossier) && !empty($getDossier)) {?>
		<a href="#" class="nav retour">Remonter d'un dossier</a><?php
	}

	foreach ($table_fichier as $key => $value) { 
		if(preg_match("#(.jpg|.png|.gif)$#", $value)) {?>
			<a href="images/albums/<?=$getDossier.'/'.$value;?>" data-lightbox="<?=$getDossier;?>"><img src="images/albums/<?=$getDossier.'/'.$value;?>" alt="<?=$value;?>" /></a><?php
		}
		else{?>
			<a class="nav" href="<?=$getDossier.'/'.$value;?>"><?=$value;?></a><?php
		}
	}?>
	<a href="#" class="nav dir_plus">Ajouter un dossier</a>
	<a href="#" class="nav picture_plus">Ajouter une photo</a>
</div>