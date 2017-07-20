<?php
	$TarifManager = new TarifManager($connexion);
	$CategorieManager = new CategorieManager($connexion);

    $options = array('orderby' => 'ordre');
    $listeCategories = $CategorieManager->retourneListe($options);

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
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterPriceModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#priceModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un tarif</button>
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
									$lastCategorie = new Categorie(array());
									$tab = explode(',', $unTarif->getCategorie());
									if(is_array($tab)):
										foreach($tab as $key => $club):
											$options = array('where' => 'id = '. $club);
											$uneCategorie = $CategorieManager->retourne($options);
											if($lastCategorie->getCategorie() != $uneCategorie->getCategorie() || $unTarif->getGenre()):																																				$laCategorie .= $uneCategorie->getCategorie();
													$laCategorie .= ($unTarif->getGenre()) ? ' '.$uneCategorie->getGenre() : '';
												if($key < count($tab)-1):
													$laCategorie .= ', ';
											 endif;
											endif;
											$lastCategorie = $uneCategorie;
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
						<td colspan="4">Aucun tarif enregistré</td>
					</tr><?php
				endif;?>
			</table>
		</div>
	</div>
	<div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="priceLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addPriceLabel">Ajouter un tarif</h4>
                    <h4 class="modal-title hidden" id="editPriceLabel">Modifier un tarif</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="date_naissance">Né(e) en <span class="text-danger">*</span></label><br>
                                    <input type="text" id="date_naissance" placeholder="Né(e) en" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="categorie">Categorie <span class="text-danger">*</span></label><br><select id="categorie" class="form-control selectpicker" multiple data-live-search="true" title="Choissisez une catégorie"><?php
                                        foreach($listeCategories as $uneCategorie):?>
                                            <option value="<?=$uneCategorie->getId();?>"><?=$uneCategorie->getCategorieAll();?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="prix_old">Prix <span class="text-danger">*</span></label><br>
                                    <input type="text" id="prix_old" placeholder="100" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="annee">Année <span class="text-danger">*</span></label><br>
                                    <select id="annee" class="form-control selectpicker" title="Choissisez une année"><?php
                                        for($i=$annee_suiv; $i >= 2012; $i--):?>
                                            <option value="<?=$i;?>"><?=$i;?></option><?php
                                        endfor;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="condition_old">Condition <span class="text-danger">*</span></label><br>
                                    <select id="condition_old" class="form-control selectpicker" title="Choissisez une condition">
                                    	<option value="1">1</option>
                                    	<option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="actif_non">Actif <span class="text-danger">*</span></label><br>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" name="actif" id="actif_oui" autocomplete="off" value="1"> Oui
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="radio" name="actif" id="actif_non" autocomplete="off" checked value="0"> Non
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
		                	<div class="col-sm-12">
			                    <p class="text-danger">* Champs obligatoires</p>
		                    </div>
	                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success add-tarif">Ajouter</button>
                    <button type="button" class="btn btn-warning edit-tarif hidden">Modifier</button>
                </div>
            </div>
        </div>
    </div>
</div>