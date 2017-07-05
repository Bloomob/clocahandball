<?php
	// MenuManagerManager = new MenuManagerManager($connexion);

	$options = array();
	// Si on récupère le param 'parent' dans l'url, on l'ajoute dans l'array $options
	if(isset($_GET['parent']))
		$options['where'] = 'parent='. intval($_GET['parent']);

    $listeMenuManager = $MenuManagerManager->retourneListe($options);
?>
<div class="wrapper menus-manager">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Menu manager</h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterMenuManagerModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#menuManagerModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un menu manager</button>
        </div>
        <div class="col-xs-12">
            <table class="table liste-menus-manager">
				<tr>
					<th>Nom</th>
					<th>Ordre</th>
					<th>Image</th>
					<th>Actif</th>
					<th>Est supprimable ?</th>
					<th></th>
				</tr><?php
				if(is_array($listeMenuManager)):
					foreach($listeMenuManager as $unMenuManager):?>
						<tr>
							<td><?=$unMenuManager->getNom();?></td>
							<td><?=$unMenuManager->getOrdre();?></td>
							<td><?=$unMenuManager->getImage();?></td>
							<td><?=($unMenuManager->getActif())?'Oui':'Non';?></td>
							<td><?=($unMenuManager->getEstSupprimable())?'Oui':'Non';?>
							</td>	
							<td>
								<button class="btn btn-warning edit-match" data-id="<?=$unMenuManager->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
								<button class="btn btn-danger delete-match" data-id="<?=$unMenuManager->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
							</td>
						</tr><?php
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
</div>