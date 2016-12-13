<?php
	include_once("connexion_bdd.php");
	include_once('fonctions.php');
	
	$erreur = false;
	$nom = "";
	$url = "";
	$image = "";
	$parent = 0;
	
	/** Nom **/
	if(isset($_POST['menu_nom'])) {
		$nom = $_POST['menu_nom'];
	} else {
		$erreur = true;
	}	
	
	/** URL **/
	if(isset($_POST['menu_url'])) {
		$url = $_POST['menu_url'];
	} else {
		$erreur = true;
	}
	
	/** Image **/
	if(isset($_POST['menu_image'])) {
		$image = $_POST['menu_image'];
	} else {
		$erreur = true;
	}
	
	/** Parent **/
	if(isset($_POST['menu_parent'])) {
		$parent = $_POST['menu_parent'];
	} else {
		$erreur = true;
	}
		
	// echo '<pre>'; var_dump($nom, $url, $image, $parent); echo '</pre>';
	// exit;
	if(!$erreur) {
		ajout_menu($nom, $url, $image, $parent);
	} ?>
	<tr class="titre">
		<th></th>
		<th>ID</th>
		<th>Nom</th>
		<th>URL</th>
		<th>Image</th>
		<th></th>
	</tr><?php
	$i = 0;
	$liste_menu = liste_menu();
	if(is_array($liste_menu)):
		foreach($liste_menu as $unMenu):?>
			<tr <?php if($i%2==1) echo 'class="odd"'; ?>>
				<td><input type="checkbox" name="menu_ID_<?=$unMenu['id'];?>" class="menu_id_<?=$unMenu['id'];?>"/></td>
				<td><?=$unMenu['id'];?></td>
				<td><?php aParent($unMenu['id']);?> <span class="menu_nom_<?=$unMenu['id'];?>"><?=$unMenu['nom'];?></span></td>
				<td><span class="menu_url_<?=$unMenu['id'];?>"><?=$unMenu['url'];?></span></td>
				<td><span class="menu_image_<?=$unMenu['id'];?>"><?=$unMenu['image'];?></span></td>
				<td class="boutons">
					<a href="<?=$unMenu['id'];?>" class="suppr_menu">Supprimer le menu</a>
					<a href="<?=$unMenu['id'];?>" class="modif_menu">Modifier le menu</a>
				</td>
			</tr><?php
			$i++;
		endforeach;
	else:?>
		<tr>
			<td colspan="6">Aucun menu</td>
		</tr><?php
	endif;
?>