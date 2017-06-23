<?php
	$FonctionManager = new FonctionManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$RoleManager = new RoleManager($connexion);
	
	$options = array('where' => 'annee_fin = 0', 'orderby' => 'type, role');
	$listeFonctions = $FonctionManager->retourneListe($options);
	// echo '<pre>';
	// var_dump($listeRoles);
	// echo '</pre>';
?>
<div class="wrap fonctions">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Liste des fonctions</h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filtresModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#addFunctionModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une fonction</button>
        </div>
        <div class="col-xs-12">
            <table class="table">
			<tr class="thead-inverse">
				<th>Prénom</th>
				<th>Nom</th>
				<th>Rôle</th>
				<th>Année de fonction</th>
				<th></th>
			</div><?php
			if(!empty($listeFonctions)):
				foreach($listeFonctions as $uneFonction):?>
					<tr class="<?=($uneFonction->getAnnee_fin()!=0)?'inactif':''; ?>"><?php
						$options = array('where' => 'id = '. $uneFonction->getId_utilisateur());
						$unUtilisateur = $UtilisateurManager->retourne($options);?>
						<td><?=$unUtilisateur->getPrenom();?></td>
						<td><?=$unUtilisateur->getNom();?></td>
						<?php
						if($uneFonction->getType()==4):
							$options = array('where' => 'id = '. $uneFonction->getRole());
							$uneCategorie = $CategorieManager->retourne($options);?>
							<td><?=$uneCategorie->getCategorieAll();?></td><?php
						else:
							$options = array('where' => 'id = '. $uneFonction->getRole());
							$unRole = $RoleManager->retourne($options);?>
							<td><?=$unRole->getNom();?></td><?php
						endif;
						?>
						<td><?=$uneFonction->getAnnee_debut();?> à <?=$uneFonction->getAnnee_fin();?></td>
						<td>
							<button class="btn btn-warning edit-function" data-id="<?=$uneFonction->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
							<button class="btn btn-danger delete-function" data-id="<?=$uneFonction->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
						</td>
					</tr><?php
				endforeach;
			else:?>
				<tr>
					<td colspan="6">Aucune fonction enregistrée</td>
				</tr><?php
			endif;?>
		</table>
	</div>
	<div id="filtres" style="display: none;">
		<div class="table">
				<div class="row boutons-actions">
					<div class="cell cell-1-2">
						<div class="btn btn-valide"> Valider</div>
					</div>
					<div class="cell cell-1-2 align_right">
						<div class="btn btn-reset btn-picto"> Réinitialisé</div>
					</div>
				</div>
			</div>
		<div class="filtre">
			<label for="tri_par_type">Tri par type</label><br/>
			<select id="tri_par_type">
				<option value="-">Tous les types</option><?php
				$options = array('where' => 'parent = 0', 'orderby' => 'ordre');
				$listeRoles = $RoleManager->retourneListe($options);
				if(!empty($listeRoles)):
					foreach($listeRoles as $unRole) :?>
						<option value="<?=$unRole->getRaccourci();?>" <?php
							if(isset($filtres['type']) && $unRole->getRaccourci() == $filtres['type']) {
								echo 'selected';
							} ?> 
						><?=$unRole->getNom();?></option><?php
					endforeach;
				endif;?>
			</select><br/>
			<br/>
			<label for="tri_par_role">Tri par rôle</label><br/>
			<select id="tri_par_role">
				<option value="-">Tous les rôles</option><?php
				$options = array('where' => 'parent != 0', 'orderby' => 'parent, ordre');
				$listeRoles = $RoleManager->retourneListe($options);
				if(!empty($listeRoles)):
					foreach($listeRoles as $unRole) :
						$options = array('where' => 'id = '. $unRole->getParent());
						$unRoleParent = $RoleManager->retourne($options);?>
						<option value="<?=$unRole->getRaccourci();?>" data-type="<?=$unRoleParent->getRaccourci();?>"<?php
							if(isset($filtres['type']) && $unRole->getRaccourci() == $filtres['type']) {
								echo 'selected';
							} ?> 
						><?=$unRole->getNom();?></option><?php
					endforeach;
				endif;
				$options = array('where' => 'actif != 0', 'orderby' => 'ordre');
				$listeCategories = $CategorieManager->retourneListe($options);
				if(!empty($listeRoles)):
					foreach($listeCategories as $uneCategorie) :?>
						<option value="<?=$uneCategorie->getRaccourci();?>" data-type="entr"<?php
							if(isset($filtres['type']) && $uneCategorie->getRaccourci() == $filtres['type']) {
								echo 'selected';
							} ?> 
						><?=$uneCategorie->getCategorie();?> <?=$uneCategorie->getGenre();?> <?=$uneCategorie->getNumero();?></option><?php
					endforeach;
				endif;?>
			</select>
		</div>
		<div class="filtre">
			Actif : <input type="checkbox" name="filtre_actif" checked>
		</div>
		<div class="clear_b"></div>
	</div>
</div>