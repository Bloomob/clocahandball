<?php
	$CategorieManager = new CategorieManager($connexion);

	$options = array('orderby' => 'ordre');
	$listeCategories = $CategorieManager->retourneListe($options);
	// echo '<pre>';
	// var_dump($listeCategories);
	// echo '</pre>';
?>
<div class="tab_content2 categories">
	<h3>Liste des cat&eacute;gories</h3>
	<div id="zone-ajout">
		<div class="boutons-actions action-ajout">
			<div class="left">
				<a href="#" class="btn btn-ajout">Ajouter une categorie</a>
			</div>
			<div class="clear_b"></div>
		</div>
	</div>
	<div id="tab_admin">
		<table>
			<tr class="titres">
				<th></th>
				<th class="boutons-actions">
					<h4>Categorie</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Raccourci</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="cell"></th>
			</tr>
			</thead><?php
			$i=0;
			if(!empty($listeCategories)):?>
				<tbody><?php
					foreach($listeCategories as $uneCategorie):?>
						<tr id="id_<?=$uneCategorie->getId();?>" class="infos<?php if($i%2==1) echo ' odd'; ?><?php if($uneCategorie->getActif()==0) echo ' inactif'; ?>">
							<td><input type="checkbox"/></td>
							<td><?=$uneCategorie->getCategorie();?> <?=$uneCategorie->getGenre();?> <?=$uneCategorie->getNumero();?></td>
							<td><?=$uneCategorie->getRaccourci();?></td>
							<td class="boutons-actions">
								<a href="<?=$uneCategorie->getId();?>" class="btn btn-modif btn-slim" title="Modifier la categorie">Modifier la cat&eacute;gorie</a>
								<a href="<?=$uneCategorie->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer la categorie">Supprimer la cat&eacute;gorie</a>
							</td>
						</tr><?php
						$i++;
					endforeach;?>
				</tbody><?php
			else:?>
				<tr>
					<td colspan="4">Aucune cat&eacute;gorie enregistr&eacute;e</td>
				</tr><?php
			endif;?>
		</table>
	</div>
</div>