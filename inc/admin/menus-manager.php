<div class="row">
	<div class="col-xs-12">
        <h3>Menu manager</h3>
    </div>
    <div class="col-xs-12 text-right">
        <a href="#" class="add">Ajouter</a>
    </div>
	<div class="col-xs-12">
		<table class="table">
			<tr>
				<th></th>
				<th>Nom</th>
				<th>Ordre</th>
				<th>Image</th>
				<th>Actif</th>
				<th>Est supprimable ?</th>
				<th></th>
				<th></th>
			</tr><?php
			// On instancie les variables
			$i=0;
			$annee_actuelle = $annee;
			$options = array();
			// Si on récupère le param 'parent' dans l'url, on l'ajoute dans l'array $options
			if(isset($_GET['parent']))
				$options['where'] = 'parent='. intval($_GET['parent']);

            $listeMenuManager = $MenuManagerManager->retourneListe(options);
			// $listeMenuManager = listeMenuManager($options);
			if(is_array($listeMenuManager)):
				foreach($listeMenuManager as $unMenuManager):?>
					<tr class="<?php if($i%2==1) echo 'odd'; ?>">
						<td><input type="checkbox" name="id_<?=$unMenuManager->getId();?>"/></td>
						<td><?=$unMenuManager->getNom();?></td>
						<td><?=$unMenuManager->getOrdre();?></td>
						<td><?=$unMenuManager->getImage();?></td>
						<td><?=$unMenuManager->getActif();?></td>
						<td><?=$unMenuManager->getEstSupprimable();?></td>
						<td><a href="?onglet=menus-manager&amp;parent=<?=$unMenuManager->getId();?>"><i class="fa fa-gear" aria-hidden="true"></i></td>
						<td class="boutons">
							<a href="<?=$unMenuManager->getId();?>" class="suppr"><i class="fa fa-trash" aria-hidden="true"></i></a>
							<a href="<?=$unMenuManager->getId();?>" class="modif"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
							<a href="<?=$unMenuManager->getId();?>" class="voir"><i class="fa fa-eye" aria-hidden="true"></i></a>
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