<?php
	$TarifManager = new TarifManager($connexion);
	$CategorieManager = new CategorieManager($connexion);

	$options = array('orderby' => 'annee DESC, prix_old DESC', 'limit' => '0,20');
	$listeTarifs = $TarifManager->retourneListe($options);

	// echo '<pre>';
	// var_dump($annee, $listeTarifs);
	// echo '</pre>';
?>
<div class="wrapper tarifs">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Liste des tarifs</h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterActuModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#actuModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un tarif</button>
        </div>
        <div class="col-xs-12">
            <table class="table liste-tarifs">
				<tr class="thead-inverse">
					<th></th>
					<th>Né(e)s en</th>
					<th>Catégorie</th>
					<th>Prix</th>
					<th>Condition</th>
					<th>Année</th>
					<th></th>
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
								<td>
									<button class="btn btn-warning edit-match" data-id="<?=$unTarif->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
									<button class="btn btn-danger delete-match" data-id="<?=$unTarif->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
</div>