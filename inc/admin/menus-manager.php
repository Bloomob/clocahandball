<div class="tab_container">
	<div class="tab_content2 admin_page">
		<div>
			<h3>Menu manager</h3>
		</div>
		<div class="right">
			<div><a href="#" class="add">Ajouter</a></div>
		</div>
		<div class="clear_b"></div>
		<table id="tab_admin">
			<tr class="titre">
				<th></th>
				<th>Nom</th>
				<th>Ordre</th>
				<th>Image</th>
				<th>Actif</th>
				<th>Est supprimable ?</th>
				<th></th>
			</tr><?php
			// On instancie les variables
			$i=0;
			$annee_actuelle = $annee;
			$options = array();
			// Si on récupère le param 'parent' dans l'url, on l'ajoute dans l'array $options
			if(isset($_GET['parent']))
				$options['parent'] = intval($_GET['parent']);
			else
				$options['parent'] = 0;

			$listeMenuManager = listeMenuManager($options);
			if(is_array($listeMenuManager)):
				foreach($listeMenuManager as $unMenuManager):?>
					<tr class="<?php if($i%2==1) echo 'odd'; ?>">
						<td><input type="checkbox" name="id_<?=$unMenuManager['id'];?>"/></td>
						<td><?=$unMenuManager['nom'];?></td>
						<td><?=$unMenuManager['ordre'];?></td>
						<td><?=$unMenuManager['image'];?></td>
						<td><?=retournePictoBool($unMenuManager['actif']);?></td>
						<td><?=retourneTextBool($unMenuManager['estSupprimable']);?></td>
						<td><a href="?onglet=menus-manager&amp;parent=<?=$unMenuManager['id'];?>">Options</td>
						<td class="boutons">
							<a href="<?=$unMenuManager['id'];?>" class="suppr">Supprimer</a>
							<a href="<?=$unMenuManager['id'];?>" class="modif">Modifier</a>
							<a href="<?=$unMenuManager['id'];?>" class="voir">Voir</a>
						</td>
					</tr><?php
					$i++;
				endforeach;
			else:?>
				<tr>
					<td colspan="7">Aucun menu enregistré</td>
				</tr><?php
			endif;
			?>
		</table>
	</div>
</div>