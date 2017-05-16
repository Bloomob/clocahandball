<div class="wrapper plus">
	<h3><i class="fa fa-camera" aria-hidden="true"></i>Photothèque</h3>
	<div class="contenu"><?php /*
		$table_fichier = array();
		$path = './images/albums/';
		$table_fichier = listeImages($path, $table_fichier);

		function listeImages($path, $table_fichier){
			if($dossier = opendir($path)):
				while(false !== ($fichier = readdir($dossier))):
					if($fichier != '.' && $fichier != '..' && $fichier != 'index.php'):
						if(preg_match("#(.jpg|.png|.gif|.JPG|.PNG|.GIF)$#", $fichier)):
							$table_fichier[] = $path.$fichier;
						else:
							$table_fichier = listeImages($path.$fichier.'/', $table_fichier);
						endif;
					endif;
				endwhile;
				closedir($dossier);
			endif;
			return $table_fichier;
		}

		foreach ($table_fichier as $key => $value):?>
			<div class="unePhoto<?=($key == 0)?' actif':'';?>">
				<a href="<?=$value;?>" data-lightbox="photos"><img src="<?=$value;?>" alt="<?=$value;?>" /></a>
			</div><?php
		endforeach;
        */?><?php
        if(false):?>
            <img src="" alt="" /><?php
        else:?>
            <p>Pas de photo pour le moment.</p><?php
        endif;?>
	</div>
    <nav>
        <a href="#" class="voir-plus">Voir plus<i class="fa fa-plus" aria-hidden="true"></i></a>
    </nav>
</div>