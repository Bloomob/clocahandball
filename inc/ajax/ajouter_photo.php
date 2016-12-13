<?php
	if(isset($_POST))
	{
		 //Some Settings
		$ThumbSquareWidth        = 450; //Width
		$ThumbSquareHeight        = 450; //Height
		$DestinationDirectory   = '../../images/albums'; //Upload Directory ends with / (slash)
		$Quality                = 90;
		$getDossier = '';
		$retourDossier = '';

		if(isset($_POST['dossier'])) {
			$getDossier = $_POST['dossier'];
			$pos = strrpos($getDossier, '/');
			$retourDossier = substr($getDossier, 0, $pos);
			$DestinationDirectory .= $getDossier.'/';
		}
		if(isset($_POST['nom'])) {
			if(!empty($_POST['nom'])) {
				$nom = str_replace(' ', '_', $_POST['nom']);
			}
		}

		if(!isset($_FILES['imageFile']) || !is_uploaded_file($_FILES['imageFile']['tmp_name']))
		{
			echo $erreur = "Une erreur est survenue lors de l'upload !"; // output error when above checks fail.
		}
		
		// Random number for both file, will be added after image name
		$RandomNumber   = rand(0, 9999999999);
		$ImageName      = str_replace(' ','-',strtolower($_FILES['imageFile']['name']));
		$ImageSize      = $_FILES['imageFile']['size']; // Obtain original image size
		$TempSrc        = $_FILES['imageFile']['tmp_name']; // Tmp name of image file stored in PHP tmp folder
		$ImageType      = $_FILES['imageFile']['type']; //Obtain file type, returns "image/png", image/jpeg, text/plain etc.

		//Let's use $ImageType variable to check wheather uploaded file is supported.
		//We use PHP SWITCH statement to check valid image format, PHP SWITCH is similar to IF/ELSE statements
		//suitable if we want to compare the a variable with many different values
		switch(strtolower($ImageType))
		{
			case 'image/png':
				$CreatedImage =  imagecreatefrompng($_FILES['imageFile']['tmp_name']);
				break;
			case 'image/gif':
				$CreatedImage =  imagecreatefromgif($_FILES['imageFile']['tmp_name']);
				break;
			case 'image/jpeg':
			case 'image/pjpeg':
				$CreatedImage = imagecreatefromjpeg($_FILES['imageFile']['tmp_name']);
				break;
			default:
				$erreur = 'Fichier non supporté !'; //output error and exit
		}

		//PHP getimagesize() function returns height-width from image file stored in PHP tmp folder.
		//Let's get first two values from image, width and height. list assign values to $CurWidth,$CurHeight
		list($CurWidth,$CurHeight)=getimagesize($TempSrc);

	//Get file extension from Image name, this will be re-added after random name
		$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
		$ImageExt = str_replace('.','',$ImageExt);

		//remove extension from filename
		$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);

		//Construct a new image name (with random number added) for our new image.
		$NewImageName = $ImageName.'.'.$ImageExt;
		//set the Destination Image
		$DestRandImageName          = $DestinationDirectory.$NewImageName; //Name for Big Image

		//Resize image to our Specified Size by calling resizeImage function.
		if(resizeImage($CurWidth,$CurHeight,$ThumbSquareWidth,$DestRandImageName,$CreatedImage,$Quality,$ImageType)) {
			//Create a square Thumbnail right after, this time we are using cropImage() function
			if(!cropImage($CurWidth,$CurHeight,$ThumbSquareWidth,$DestRandImageName,$CreatedImage,$Quality,$ImageType)) {
				
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
			     echo 'Le dossier n\' a pas pu être ouvert';?>

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
						<a href="images/albums/<?=$getDossier.'/'.$value;?>"><img src="images/albums/<?=$getDossier.'/'.$value;?>" alt="<?=$value;?>" /></a><?php
					}
					else{?>
						<a class="nav" href="<?=$getDossier.'/'.$value;?>"><?=$value;?></a><?php
					}
				}?>
				<a href="#" class="nav dir_plus">Ajouter un dossier</a>
				<a href="#" class="nav picture_plus">Ajouter une photo</a>
			</div><?php
		}else {
			//output error
		}
	}

	// This function will proportionally resize image
	function resizeImage($CurWidth,$CurHeight,$MaxSize,$DestFolder,$SrcImage,$Quality,$ImageType) {
		//Check Image size is not 0
		if($CurWidth <= 0 || $CurHeight <= 0) {
			return false;
		}

		//Construct a proportional size of new image
		$ImageScale         = min($MaxSize/$CurWidth, $MaxSize/$CurHeight);
		$NewWidth           = ceil($ImageScale*$CurWidth);
		$NewHeight          = ceil($ImageScale*$CurHeight);
		$NewCanves          = imagecreatetruecolor($NewWidth, $NewHeight);

		// Resize Image
		if(imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight)) {
			switch(strtolower($ImageType)) {
				case 'image/png':
					imagepng($NewCanves,$DestFolder);
					break;
				case 'image/gif':
					imagegif($NewCanves,$DestFolder);
					break;
				case 'image/jpeg':
				case 'image/pjpeg':
					imagejpeg($NewCanves,$DestFolder,$Quality);
					break;
				default:
					return false;
			}
			//Destroy image, frees up memory
			if(is_resource($NewCanves)) { imagedestroy($NewCanves); }
		return true;
		}

	}

	//This function corps image to create exact square images, no matter what its original size!
	function cropImage($CurWidth,$CurHeight,$iSize,$DestFolder,$SrcImage,$Quality,$ImageType) {
		//Check Image size is not 0
		if($CurWidth <= 0 || $CurHeight <= 0) {
			return false;
		}

		//abeautifulsite.net has excellent article about "Cropping an Image to Make Square"
		//http://www.abeautifulsite.net/blog/2009/08/cropping-an-image-to-make-square-thumbnails-in-php/
		if($CurWidth>$CurHeight) {
			$y_offset = 0;
			$x_offset = ($CurWidth - $CurHeight) / 2;
			$square_size    = $CurWidth - ($x_offset * 2);
		}else {
			$x_offset = 0;
			$y_offset = ($CurHeight - $CurWidth) / 2;
			$square_size = $CurHeight - ($y_offset * 2);
		}

		$NewCanves  = imagecreatetruecolor($iSize, $iSize);
		if(imagecopyresampled($NewCanves, $SrcImage,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size)) {
			switch(strtolower($ImageType)) {
				case 'image/png':
					imagepng($NewCanves,$DestFolder);
					break;
				case 'image/gif':
					imagegif($NewCanves,$DestFolder);
					break;
				case 'image/jpeg':
				case 'image/pjpeg':
					imagejpeg($NewCanves,$DestFolder,$Quality);
					break;
				default:
					return false;
			}
		//Destroy image, frees up memory
			if(is_resource($NewCanves)) { imagedestroy($NewCanves); }
		return true;

		}
	}
?>