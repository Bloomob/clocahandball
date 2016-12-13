<div class="tab_container">
	<div class="tab_content2 dossiers">
		<div>
			<h3>Liste des dossiers</h3>
		</div>
		<div class="right">
			<div><a href="#" class="add">Ajouter un dossier</a></div>
		</div>
		<div class="clear_b"></div>
		<table id="tab_admin">
			<tr class="titre">
				<th></th>
				<th>Date</th>
				<th>Titre</th>
				<th>Auteur</th>
				<th>Theme</th>
				<th></th>
			</tr><?php
			$i=0;
			$listeDossiers = listeDossiers();
			if(is_array($listeDossiers)):
				foreach($listeDossiers as $unDossier):?>
					<tr class="<?php if($i%2==1) echo 'odd'; ?>">
						<td><input type="checkbox" name="id_<?=$unDossier['id_dossier'];?>"/></td>
						<td><?=$unDossier['laDate'];?></td>
						<td class="align_left"><?=$unDossier['titre'];?></td>
						<td><?=$unDossier['prenom'];?></td>
						<td><?=$unDossier['theme'];?></td>
						<td class="boutons">
							<a href="<?=$unDossier['id_dossier'];?>" class="suppr">Supprimer une dossier</a>
							<a href="<?=$unDossier['id_dossier'];?>" class="modif">Modifier une dossier</a>
							<a href="<?=$unDossier['id_dossier'];?>" class="voir">Voir une dossier</a>
						</td>
					</tr><?php
					$i++;
				endforeach;
			else:?>
				<tr>
					<td colspan="7">Aucun dossier enregistré</td>
				</tr><?php
			endif;?>
		</table>
	</div>
</div>