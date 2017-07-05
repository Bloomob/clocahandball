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
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterCategorieModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#categorieModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une catégorie</button>
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
</div>