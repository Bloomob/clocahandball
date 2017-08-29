<?php
	$getDossier = '';
	$retourDossier = '';
	if(isset($_POST['dossier'])) {
		$getDossier = $_POST['dossier'];
		$pos = strrpos($getDossier, '/');
		$retourDossier = substr($getDossier, 0, $pos);
	}

	$table_fichier = array();
	$nb_fichier = 0;
	if($dossier = opendir('../../images/albums'.$getDossier.'/')){
		while(false !== ($fichier = readdir($dossier))){
			if($fichier != '.' && $fichier != '..' && $fichier != 'index.php'){
				$nb_fichier++; // On incrémente le compteur de 1
				$table_fichier[] = $fichier;
			}
		}
		echo 'Il y a <strong>' . $nb_fichier .'</strong> dossier(s) et/ou fichier(s) dans le dossier';
		closedir($dossier);
	}
	else
	     echo 'Le dossier n\' a pas pu être ouvert';
?>
<div class="liste"><?php
	if(!empty($retourDossier)) {?>
		<a href="#" data-chemin="<?=$retourDossier;?>" class="nav retour"><i class="fa fa-undo fa-4x" aria-hidden="true"></i><br>Remonter d'un dossier</a><?php
	}
	else if(empty($retourDossier) && !empty($getDossier)) {?>
		<a href="#" data-chemin="<?=$retourDossier;?>" class="nav retour"><i class="fa fa-undo fa-4x" aria-hidden="true"></i><br>Remonter d'un dossier</a><?php
	}

	foreach ($table_fichier as $key => $value) {
		if(preg_match("#(.jpg|.png|.gif)$#", $value)) {?>
			<a class="file_img" href="#" data-chemin="<?=$getDossier.'/'.$value;?>"><img src="images/albums<?=$getDossier.'/'.$value;?>" alt="<?=$value;?>" /></a><?php
		}
		else {?>
			<a class="nav" href="#" data-chemin="<?=$getDossier.'/'.$value;?>"><i class="fa fa-folder-o fa-5x" aria-hidden="true"></i><br><?=$value;?></a><?php
		}
	}
	if(!isset($_POST['format']) || $_POST['format'] != 'min'):?>
		<a href="#" class="nav dir_plus">Ajouter un dossier</a>
		<a href="#" class="nav picture_plus">Ajouter une photo</a><?php
	endif; ?>
</div>