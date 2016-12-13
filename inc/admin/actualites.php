<?php
	$ActuManager = new ActualiteManager($connexion);
	$UtilManager = new UtilisateurManager($connexion);

	$options = array('orderby' => 'date_creation desc, heure_creation desc, date_publication desc, heure_publication desc', 'limit' => '0, 20');
	$listeActualites = $ActuManager->retourneListe($options);
?>
<div class="tab_content2 actualites">
	<div>
		<h3>Liste des actualités</h3>
	</div>
	<div id="zone-ajout">
		<div class="boutons-actions action-ajout">
			<div class="left">
				<a href="#" class="btn btn-ajout">Ajouter une actualité</a>
			</div>
			<div class="clear_b"></div>
		</div>
	</div>
	<div class="clear_b"></div>
	<div id="tab_admin">
		<table>
			<tr class="titres">
				<th class="titre align_left w_45">
					<a href="#">Titre</a>
				</th>
				<th class="auteur w_20">
					<a href="#">Auteur</a>
				</th>
				<th class="status w_20">
					<a href="#">Status</a>
				</th>
				<th class="options w_15">
				</th>
			</tr>
			<?php include('liste_actualites.php'); ?>
		</table>
	</div>
</div>