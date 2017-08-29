<?php
	$CategorieManager = new CategorieManager($connexion);

	$options = array('orderby' => 'ordre');
	$listeCategories = $CategorieManager->retourneListe($options);
	// echo '<pre>';
	// var_dump($listeCategories);
	// echo '</pre>';
?>
<div class="wrapper categories">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Liste des catégories</h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterCategoryModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#categoryModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une catégorie</button>
        </div>
        <div class="col-xs-12">
            <table class="table liste-categories">
				<tr class="thead-inverse">
					<th>Categorie</th>
					<th>Raccourci</th>
					<th></th>
				</tr>
				</thead><?php
				$i=0;
				if(!empty($listeCategories)):?>
					<tbody><?php
						foreach($listeCategories as $uneCategorie):?>
							<tr id="id_<?=$uneCategorie->getId();?>" class="infos<?php if($i%2==1) echo ' odd'; ?><?php if($uneCategorie->getActif()==0) echo ' inactif'; ?>">
								<td><?=$uneCategorie->getCategorie();?> <?=$uneCategorie->getGenre();?> <?=$uneCategorie->getNumero();?></td>
								<td><?=$uneCategorie->getRaccourci();?></td>
								<td>
									<button class="btn btn-warning edit-match" data-id="<?=$uneCategorie->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
									<button class="btn btn-danger delete-match" data-id="<?=$uneCategorie->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
								</td>
							</tr><?php
							$i++;
						endforeach;?>
					</tbody><?php
				else:?>
					<tr>
						<td colspan="3">Aucune catégorie enregistrée</td>
					</tr><?php
				endif;?>
			</table>
		</div>
	</div>
	<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="priceLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addCategoryLabel">Ajouter une catégorie</h4>
                    <h4 class="modal-title hidden" id="editCategoryLabel">Modifier une catégorie</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="categorie">Categorie <span class="text-danger">*</span></label><br>
                                    <select id="categorie" class="form-control selectpicker" title="Choisissez une catégorie">
                                    	<option value="Séniors">Séniors</option><?php
                                        for($i=20; $i >= 9; $i--):?>
                                            <option value="-<?=$i;?> ans">-<?=$i;?> ans</option><?php
                                        endfor;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="genre">Genre <span class="text-danger">*</span></label><br>
                                    <select id="genre" class="form-control selectpicker" title="Choisissez un genre">
                                    	<option value="masculin">Masculin</option>
                                    	<option value="feminin">Féminin</option>
                                    	<option value="mixte">Mixte</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="numero">Numéro <span class="text-danger">*</span></label><br>
                                    <select id="numero" class="form-control selectpicker" title="Choisissez un numéro"><?php
                                        for($i=1; $i <= 3; $i++):?>
                                            <option value="<?=$i;?>"><?=$i;?></option><?php
                                        endfor;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ordre">Ajouter avant <span class="text-danger">*</span></label><br>
                                    <select id="ordre" class="form-control selectpicker" title="Ajouter avant"><?php
										if(!empty($listeCategories)):
											foreach($listeCategories as $uneCategorie):?>
	                                            <option value="<?=$uneCategorie->getOrdre();?>"><?=$uneCategorie->getCategorieAll();?></option><?php
	                                            $ordre = $uneCategorie->getOrdre();
	                                        endforeach;?>
	                                        <option value="<?= $ordre + 5 ;?>">Dernière position</option><?php
                                        endif;?>
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
                    <button type="button" class="btn btn-success add-categorie">Ajouter</button>
                    <button type="button" class="btn btn-warning edit-categorie hidden">Modifier</button>
                </div>
            </div>
        </div>
    </div>
</div>