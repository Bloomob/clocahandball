<?php
	$getDossier = '';
	$retourDossier = '';
	if(isset($_GET['dossier'])) {
		$getDossier = $_GET['dossier'];
		$pos = strrpos($getDossier, '/');
		$retourDossier = substr($getDossier, 0, $pos);
	}
?>
<div class="tab_container">
	<div class="tab_content2 galerie">
		<div>
			<h3 class="">Galerie photos</h3>
		</div>
		<div>
			<div class="upload" style="display: none;">
				<form action="inc/ajax/upload_image.php" method="post" enctype="multipart/form-data">
					<input type="file" class="image" name="imageFile"/>
					<input type="submit" class="add" value="Ajouter une image"/>
				</form>
			</div>
			<div class="clear_b"></div>
			<div class="albums"><?php
				$table_fichier = array();
				$nb_fichier = 0;
				if($dossier = opendir('./images/albums/'.$getDossier.'/')){
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
					<input type='hidden' class='dir_courant' value='<?=$getDossier;?>' />
					<?php
						if(!empty($retourDossier)) {?>
							<a href="<?=$retourDossier;?>" class="nav retour">Remonter d'un dossier</a><?php
						}

						foreach ($table_fichier as $key => $value) {
							if(preg_match("#(.jpg|.png|.gif)$#", $value)) {?>
								<a href="images/albums/<?=$getDossier.'/'.$value;?>" data-lightbox="<?=$getDossier;?>"><img src="images/albums/<?=$getDossier.'/'.$value;?>" alt="<?=$value;?>" /></a><?php
							}
							else{?>
								<a class="nav" href="<?=$getDossier.'/'.$value;?>"><?=$value;?></a><?php
							}
						}
					?>
					<a href="#" class="nav dir_plus">Ajouter un dossier</a>
					<a href="#" class="nav picture_plus">Ajouter une photo</a>
				</div>
			</div>
		</div>
	</div>
</div>