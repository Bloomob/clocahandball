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
<div class="tab_content2 fonctions">
	<h3>Fonctions</h3>
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
	<div id="zone-ajout">
		<div class="boutons-actions action-ajout">
			<div class="left">
				<a href="#" class="btn btn-ajout">Ajouter une fonction</a>
			</div>
			<div class="clear_b"></div>
		</div>
	</div>
	<div id="tab_admin">
		<table>
			<tr class="titres">
				<th></th>
				<th class="boutons-actions">
					<h4>Prénom / Nom</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Fonction</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="cell"></th>
			</div><?php
			$i=0;
			if(!empty($listeFonctions)):
				foreach($listeFonctions as $uneFonction):?>
					<tr id="id_<?=$uneFonction->getId();?>" class="infos<?php if($i%2==1) echo ' odd'; ?><?php if($uneFonction->getAnnee_fin()!=0) echo ' inactif'; ?>">
						<td><input type="checkbox" name="id_<?=$uneFonction->getId();?>"/></td>
						<?php
							$options = array('where' => 'id = '. $uneFonction->getId_utilisateur());
							$unUtilisateur = $UtilisateurManager->retourne($options);
						?>
						<td><?=$unUtilisateur->getPrenom();?> <?=$unUtilisateur->getNom();?></td>
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
						
						<td class="boutons-actions">
							<a href="#<?=$uneFonction->getId();?>" class="btn btn-modif btn-slim" title="Modifier la fonction">Modifier la fonction</a>
							<a href="#<?=$uneFonction->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer la fonction">Supprimer la fonction</a>
						</td>
					</tr><?php
					$i++;
				endforeach;
			else:?>
				<tr>
					<td colspan="6">Aucune fonction enregistrée</td>
				</tr><?php
			endif;?>
		</table>
	</div>
</div>