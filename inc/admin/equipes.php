<?php
	$EquipeManager = new EquipeManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$RoleManager = new RoleManager($connexion);
	$HoraireManager = new HoraireManager($connexion);
	
	$options = array('orderby' => 'annee DESC, categorie');
	$listeEquipes = $EquipeManager->retourneListe($options);
	// echo '<pre>';
	// var_dump($listeEquipes);
	// echo '</pre>';
?>
<div class="tab_content2 equipes">
	<div>
		<h3>Liste des équipes</h3>
	</div>
	<div id="zone-ajout">
		<div class="boutons-actions action-ajout">
			<div class="left">
				<a href="#" class="btn btn-ajout">Ajouter une équipe</a>
			</div>
			<div class="clear_b"></div>
		</div>
	</div>
	<div class="clear_b"></div>
	<div id="tab_admin">
		<table>
			<tr class="titres">
				<th></th>
				<th class="boutons-actions">
					<h4>Catégorie</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Année</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Entraineurs</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Entrainements</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th></th>
			</tr>
			<?php include('liste_equipes.php'); ?>
		</table>
	</div>
</div>