<div class="tab_container">
	<div class="tab_content2 images">
		<div>
			<h3>Gallerie d'images</h3>
		</div>
		<div style="margin: 10px 0;">
			<form action="inc/ajax/upload_image.php" method="post" enctype="multipart/form-data">
				<input type="file" class="image" name="imageFile"/>
				<input type="submit" class="add" value="Ajouter une image"/>
			</form>
		</div>
		<div class="clear_b"></div><?php
		$liste_images = liste_image();
		if(is_array($liste_images)) {
			foreach($liste_images as $uneImage) { ?>
				<div class="uneImage" >
					<img src="images/<?=$uneImage['nom'];?>.<?=$uneImage['extension'];?>" style="width: 100%;" /><br/>
					Nom : <?=$uneImage['nom'];?>.<?=$uneImage['extension'];?><br/>
					Taille : <?=$uneImage['width'];?> x <?=$uneImage['height'];?>
					<div class='croix'></div>
				</div><?php
			}
		}?>
		<div class="clear_b"></div>
	</div>
</div>