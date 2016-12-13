<?php
	$TarifManager = new TarifManager($connexion);
	$CategorieManager = new CategorieManager($connexion);

	$options = array('orderby' => 'annee DESC, prix_old DESC', 'limit' => '0,20');
	$listeTarifs = $TarifManager->retourneListe($options);

	// echo '<pre>';
	// var_dump($annee, $listeTarifs);
	// echo '</pre>';
?>
<div class="tab_content2 tarifs">
	<h3 class="">Liste des tarifs</h3>
	<div id="zone-ajout">
		<div class="boutons-actions action-ajout">
			<div class="left">
				<a href="#" class="btn btn-ajout">Ajouter un tarif</a>
			</div>
			<div class="clear_b"></div>
		</div>
	</div>
	<div id="tab_admin">
		<table>
			<tr class="titres">
				<th></th>
				<th class="boutons-actions">
					<h4>N&eacute;(e)s en</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Cat&eacute;gorie</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Prix</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Condition</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Ann&eacute;e</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="cell"></th>
			</tr>
			</thead><?php
			$i=0;
			if(!empty($listeTarifs)):?>
				<tbody><?php
					foreach($listeTarifs as $unTarif):?>
						<tr id="id_<?=$unTarif->getId();?>" class="infos<?=(!$unTarif->getActif()) ? ' inactif' : '';?>">
							<td><input type="checkbox"/></td>
							<td><?=$unTarif->getDate_naissance();?></td>
							<?php
								$laCategorie = '';
								$tab = explode(',', $unTarif->getCategorie());
								if(is_array($tab)):
									foreach($tab as $key => $club):
										$options = array('where' => 'id = '. $club);
										$uneCategorie = $CategorieManager->retourne($options);
										$laCategorie .= $uneCategorie->getCategorie();
										$laCategorie .= ($unTarif->getGenre()) ? ' '.$uneCategorie->getGenre() : '';
										if($key < count($tab)-1):
											$laCategorie .= ', ';
										endif;
									endforeach;
								else:
									$options = array('where' => 'id = '. $tab);
									$uneCategorie = $CategorieManager->retourne($options);
									$laCategorie = $uneCategorie->getCategorie();
									$laCategorie .= ($unTarif->getGenre()) ? ' '.$uneCategorie->getGenre() : '';
								endif;
							?>
							<td>
								<?=$laCategorie;?>
							</td>
							<td><?=$unTarif->getPrix_old();?> (<?=$unTarif->getPrix_nv();?>)</td>
							<td><?=$unTarif->getCondition_old();?> (<?=$unTarif->getCondition_nv();?>)</td>
							<td><?=$unTarif->getAnnee();?></td>
							<td class="boutons-actions">
								<a href="<?=$unTarif->getId();?>" class="btn btn-modif btn-slim" title="Modifier le tarif">Modifier le tarif</a>
								<a href="<?=$unTarif->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer le tarif">Supprimer le tarif</a>
							</td>
						</tr><?php
						$i++;
					endforeach;?>
				</tbody><?php
			else:?>
				<tr>
					<td colspan="4">Aucun tarif enregistr&eacute;</td>
				</tr><?php
			endif;?>
		</table>
	</div>
</div>